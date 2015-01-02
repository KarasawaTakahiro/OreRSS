<?php
include_once('feedtbl.php');
include_once('itemtbl.php');

define('RSSURL_FRONT', 'http://www.nicovideo.jp/mylist/');
define('RSSURL_BACK', '?rss=2.0');

class Model_Rss extends \Model
{
    /*
        マイリストのURLをもらって、feedとitemを登録する
    */
    public function regist_new_feed($userId, $url){
        $feed_url = self::convert_url($url);
        $feed = self::get_feed($feed_url);


        // feedの新規登録
        if(self::is_registered_feed($feed_url) == false){
            // 未登録の時
            $feed_channel = self::parse($feed);
            \Model_Feedtbl::set($feed_url, $feed_channel->title);
            $id = \Model_Feedtbl::get_id_from_url($feed_url);       // feedのidを取得
            if($id == null) return null;                            // DBから参照失敗
            Model_Pull::add($id, $userId);

            foreach($feed_channel->item as $item){
                // itemの新規登録
                $itemId = self::regist_item($id, $item->title, $item->link, $item->pubDate, $item->guid);
                // 視聴情報の登録
                Model_Watch::add($itemId, $userId);
            }
            return array('title' => $feed_channel->title, 'id' => $id);
        }else{
            // マイリストが登録済み
            $id = \Model_Feedtbl::get_id_from_url($feed_url);       // feedのidを取得
            $feed_channel = \Model_Rss::get_localdata_channel_format($id);

            if($id == null) return null;                            // DBから参照失敗
            Model_Pull::add($id, $userId);

            foreach($feed_channel['item'] as $item){
                // itemの新規登録
                $itemId = self::regist_item($id, $item['title'], $item['link'], $item['pub_date'], $item['guid']);
                // 視聴情報の登録
                Model_Watch::add($itemId, $userId);
            }
            return array('title' => $feed_channel['title'], 'id' => $id);
        }

    }

    /*
        全てのfeedを更新する
        新しいitemの総数を返す
    */
    public function update(){
        $num = 0;   // 新規総数
        // DBから全てのフィードのidを取得
        foreach(\Model_Feedtbl::get_all_feed_ids() as $feed_id){
            $num += self::update_feed($feed_id);    // フィードを更新
        }

        return $num;
    }

    /*
        1つのfeedを更新する
        新しいitemの総数を返す
    */
    private function update_feed($feed_id){
        $update_num = 0;    // 新規総数

        // idからフィードのURLを取得
        $url = \Model_Feedtbl::get_url_from_id($feed_id);
        if(! $url){
            return 0;
        }

        // フィードの全itemを取得
        $items = self::get_items(self::get_feed($url));

        foreach($items as $item){
            if(self::is_registered_item_at($url, $item->guid)){
                // 登録済み
                continue;
            }else{
                // 未登録により新規登録
                self::regist_item($feed_id, $item->title, $item->link, $item->pubDate, $item->guid);
                $update_num += 1;
            }
        }
        return $update_num;
    }

    // feedの更新用のデータを取得
    public static function get_data_for_update(){
        $data = array();
        foreach(Model_Feedtbl::get_all_feed_ids() as $id){
            $column = Model_Feedtbl::get_all_column_from_id($id);
            array_push($data, array('id' => $column[0]['id'], 'title' => $column[0]['title']));
        }
        return $data;
    }


    /*
        フィードが登録済み
    */
    public static function is_registered_feed($rss_url){
        $id = \Model_Feedtbl::get_id_from_url($rss_url);

        if($id == null){
            return false;
        }else{
            return true;
        }
    }

    /*
        あるフィードのitemが登録済み

        $item_guidか$item_urlのどちらか以上をを渡す
    */
    public static function is_registered_item_at($rss_url, $item_guid=null, $item_url=null){
        $query = \DB::select(TABLE_ITEM.'.id')->from(TABLE_ITEM)->join(TABLE_FEED)->on(TABLE_ITEM.'.feed_id', '=', TABLE_FEED.'.id')->where('url', '=', $rss_url);
        if($item_guid){
            $query->where('guid', '=', $item_guid);
        }else if($item_url){
            $query->where('link', '=', $item_url);
        }else{
            return false;
        }

        if(0 < count($query->execute())){
            return true;
        }else{
            return false;
        }
    }
    /*
        マイリストのURLからRSSのURLに変換する
    */
    public static function convert_url($url){
        // URLからマイリスIDを抜き取る
        preg_match('/mylist\/\d+/', $url, $matches);
        preg_match('/\d+/', $matches[0], $m);
        $id = $m[0];
        return RSSURL_FRONT.$id.RSSURL_BACK;
    }

    /*
      マイリストのURLからマイリストIDを取得する
    */
    public static function pick_mylist_id($url){
        preg_match('/mylist\/\d+/', $url, $matches);
        preg_match('/\d+/', $matches[0], $m);
        return $m[0];
    }

    /*
      日付をmysql用に変換
    */
    private function convert_datetime($datetime){
        return strftime('%Y%m%d%H%M%S', strtotime((string)$datetime));
    }

    /*
        RSS URLを元にfeedのデータを取得する
    */
    private function get_feed($rssurl){
        $context = stream_context_create(array(
            'http'=>array(
                'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36'
                )
            )
        );
        return file_get_contents($rssurl, false, $context);
    }

    /*
        feedをパースして、channel内を返す
    */
    private function parse($feed_data){
        return simplexml_load_string($feed_data)->channel;
    }

    /*
        
    */
    private function get_items($feed_data){
        $items = array();
        foreach(self::parse($feed_data)->item as $item){
            array_push($items, $item);
        }
        array_reverse($items);
        return $items;
    }

    /*
        itemを登録する

        登録に成功したらidを返す
    */
    private function regist_item($feed_id, $title, $link, $pubDate, $guid){
        // itemを新規登録
        if(\Model_Itemtbl::set($title, $link, self::convert_datetime($pubDate), $feed_id, $guid)){

            return \Model_Itemtbl::get_id_from_guid($guid);     // idを返す
        }else{
            return null;
        }
    }

    /*
     * DBの情報をRSS2.0のchannel風にして返す
     */
    public static function get_localdata_channel_format($feedId)
    {
        $res = Model_Feedtbl::get_all_column_from_id($feedId)[0];
        $res['item'] = Model_itemtbl::get_itemlist_column_from_feed_id($feedId);
        return $res;
    }


}

