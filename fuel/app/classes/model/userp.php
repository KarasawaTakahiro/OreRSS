<?php

class Model_Userp extends \Model
{
    public static function pulllist($userid)
    {
        $feeds = Model_Feedtbl::get_user_pull($userid); // ユーザがPULLしているFeedを取得

        foreach($feeds as &$feed){
            // サムネイル取得
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

            // ユーザ取得
            $feed['users'] = Model_Feed::userlist($feed['id'], $userid);    // FeedをPULLしている
        }
        unset($feed);

        return $feeds;
    }

    public static function get_vuser($userid)
    {
        $res = array();
        $data = Model_User::get_data($userid);
        $res['nickname'] = $data['nickname'];
        $res['thumbnail'] = $data['thumbnail'];
        $res['id'] = $data['id'];
        return $res;
    }

}

