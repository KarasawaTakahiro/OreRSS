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
            return;
        }

        \Model_Feedtbl::set($feed_url, $feed_data->title);
        $id = \Model_Feedtbl::get_id_from_url($feed_url);
        if($id == null){
            // DBから参照失敗
            return;
        }
        foreach($feed_data->item as $item){
            self::regist_item($id, $item->title, $item->link, $item->pubDate, $item->guid);
        }
    }

    /*
        全てのfeedを更新する
    */

    /*
        1つのfeedを更新する
    */
    private function update_feed($feed_id){
        $update_num = 0;

        $url = \Model_Feedtbl::get_url_from_id($feed_id);
        if(! $url){
            return null;
        }

        $channels = self::parse(self::get_feed($url));
        foreach($channels as $channel){
            if(is_registered_item_at($url, $channel->guid)){
                continue;
            }else{
                self::regist_item($feed_id, $channel->title, $channel->link, $channel->pubDate, $channel->guid);
                update_num = update_num + 1;
            }
        }

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
        $query = \DB::select('id')->from(TABLE_ITEM)->join(TABLE_FEED)->on(TABLE_ITEM.'.feed_id', '=', TABLE_FEED.'.id')->where('url', '=', $rss_url);
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
    private function convert_url($url){
         URLからマイリスIDを抜き取る
        preg_match('/mylist\/\d+$/', $url, $matches);
        preg_match('/\d+$/', $matches[0], $m);
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
        feedをパースして、channel内を古い順に返す
    */
    private function parse($feed_data){
        return array_reverse(simplexml_load_string($feed_data)->channel);
    }

    /*
        itemを登録する
    */
    private function regist_item($feed_id, $title, $link, $pubDate, $guid){
            \Model_Itemtbl::set($title, $link, self::convert_datetime($pubDate), $feed_id, $guid);
            \Model_Feedtbl::set_unread($feed_id);

    }



}

