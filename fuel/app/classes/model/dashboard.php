<?php

class Model_Dashboard extends \Model
{
    const RANDOM_FEED_NUM = 6;                      // ランダムフィードの数

    /*
     * ランダムフィード
     */
    public static function random_feed()
    {
        $feeds = array();

        // データ取得
        foreach(Model_Feedtbl::get_random(self::RANDOM_FEED_NUM) as $feed){
            $item['id'] = $feed['id'];
            $item['title'] = $feed['title'];
            $item['url'] = $feed['url'];
            $item['items'] = Model_Feedtbl::get_later_item($feed['id'], 4);

            array_push($feeds, $item);
        }

        return $feeds;
    }

}
