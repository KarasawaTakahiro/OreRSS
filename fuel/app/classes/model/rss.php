<?php

define('RSSURL_FRONT', 'http://www.nicovideo.jp/mylist/');
define('RSSURL_BACK', '?rss=2.0');

class Model_Rss extends \Model
{

    /*
        マイリストのURLからRSSのURLに変換する
    */
    private function convert_url($url){
        // URLからマイリスIDを抜き取る
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
        feedをパースして、channel内を返す
    */
    private function parse($feed_data){
        return simplexml_load_string($feed_data)->channel;
    }

    /*
        マイリストのURLをもらって、feedとitemを登録する
    */
    public function regist_new_feed($url){
        $rss_url = self::convert_url($url);
        $feed = self::get_feed($rss_url);
        $feed_data = self::parse($feed);
        \Model_Feedtbl::set($rss_url, $feed_data->title);
        $id = \Model_Feedtbl::get_id_from_url($rss_url);
        foreach($feed_data->item as $item){
            \Model_Itemtbl::set($item->title, $item->link, self::convert_datetime($item->pubDate), $item->$id, $item->guid);
        }
    }

}

