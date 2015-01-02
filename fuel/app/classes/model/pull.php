<?php

class Model_Pull extends \Model
{
    /*
     * 購読しているフィードのIDを返す
     */
    public static function get_pull_feed($userid)
    {
        $query = \DB::select('feed_id')->from('pull')
            ->where('user_id', '=', $userid)
            ->order_by('modified_at');

        return $query->execute()->as_array();
    }

    /*
     * 新規登録
     */
    public static function add($feedid, $userid)
    {
        return \DB::insert('pull')->set(array(
            'feed_id'   => $feedid,
            'user_id'   => $userid,
            'pub_date'  => Date::time()->format('mysql'),
        ))->execute();
    }
}

