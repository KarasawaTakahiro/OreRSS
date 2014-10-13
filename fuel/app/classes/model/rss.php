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
    public function regist_new_feed($url){
        $feed_url = self::convert_url($url);
        $feed = self::get_feed($feed_url);
        $feed_data = self::parse($feed);

        // 既に登録済み
        if(self::is_registered_feed($feed_url)){
            return null;
        }

        \Model_Feedtbl::set($feed_url, $feed_data->title);
        $id = \Model_Feedtbl::get_id_from_url($feed_url);
        if($id == null){
            // DBから参照失敗
            return null;
        }
        foreach($feed_data->item as $item){
            self::regist_item($id, $item->title, $item->link, $item->pubDate, $item->guid);
        }

        return array('title' => $feed_data->title, 'id' => $id);
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
            return null;
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
    */
    private function regist_item($feed_id, $title, $link, $pubDate, $guid){
            \Model_Itemtbl::set($title, $link, self::convert_datetime($pubDate), $feed_id, $guid);
            \Model_Feedtbl::set_unread($feed_id);

    }



}

