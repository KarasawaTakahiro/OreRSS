<?php

class Model_Userp extends \Model
{
    public static function pulllist($userid)
    {
        $feeds = Model_Feedtbl::get_user_pull($userid);

        // サムネイル取得
        foreach($feeds as &$feed){
            $latest = Model_Feedtbl::get_latest_item($feed['id']);          // 最新item
            if($latest == null){
                $feed['thumbnail'] = '';
                continue;
            }
            $thumb = Model_Itemtbl::get_thumbnail_from_id($latest['id']);   // サムネ
            if($thumb == null){
                $feed['thumbnail'] = '';
                continue;
            }
            $feed['thumbnail'] = $thumb;
        }
        unset($feed);

        return $feeds;
    }

}

