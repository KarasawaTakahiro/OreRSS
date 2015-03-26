<?php

class Model_Userp extends \Model
{
    public static function pulllist($userid)
    {
        $res = array();
        $feeds = Model_Feedtbl::get_user_pull($userid); // ユーザがPULLしているFeedを取得

        foreach($feeds as &$feed){
            // サムネイル取得
            $latest = Model_Feedtbl::get_latest_item($feed['id']);          // 最新item
            if($latest == null){
                $feed['thumbnail'] = '';
            }
            $thumb = Model_Itemtbl::get_thumbnail_from_id($latest['id']);   // サムネ
            if($thumb == null){
                $feed['thumbnail'] = '';
            }
            $feed['thumbnail'] = $thumb;

            // ユーザ取得
            $feed['users'] = Model_Pull::get_pull_users($feed['id'], $userid);    // FeedをPULLしている
            unset($feed);
        }

        return $feeds;
    }

    public static function get_vuser($userid)
    {
        $res = array();
        $data = Model_User::get_data($userid);
        $res['nickname'] = $data['nickname'];
        $res['id'] = $data['id'];
        if($data['thumbnail'] == null){
            $res['thumbnail'] = '';
        }else{
            $res['thumbnail'] = $data['thumbnail'];
        }
        return $res;
    }

}

