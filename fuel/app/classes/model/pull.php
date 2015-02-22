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

    /*
     * 指定したfeedを購読している自分以外のユーザの情報を返す
     */
    public static function get_pull_users($feedid, $userid)
    {
        $query = \DB::select('nickname', 'user.id')->from('pull')
            ->join('feed')->on('feed.id', '=', 'pull.feed_id')
            ->join('user')->on('user.id', '=', 'pull.user_id')
            ->where('pull.feed_id', '=', $feedid)
            ->execute()
            ->as_array();

        $res = array();
        foreach($query as $col){
            if($col['id'] != $userid){
                $user = array(
                    'nickname'  => $col['nickname'],
                    'id'        => $col['id']
                );
                array_push($res, $user);
            }
        }

        return $res;
    }

    /*
     * ユーザがフィードを購読しているか
     */
    public static function is_pull($userid, $feedid)
    {
        $query = \DB::select()->from('pull')
            ->where('feed_id', '=', $feedid)
            ->where('user_id', '=', $userid)
            ->execute()
            ->as_array();

        if(count($query) == 0){
            return false;
        }else{
            return true;
        }
    }

    /*
     * 項目削除
     */
    public static function del($userid, $feedid)
    {
        // ユーザIDかつフィードIDを持つものを削除
        $query = \DB::delete('pull')
            ->where('user_id', '=', $userid)
            ->where('feed_id', '=', $feedid)
            ->execute();
        return $query;
    }

    /*
     * 指定したfeedを購読している全ユーザの情報を返す
     */
    public static function get_all_pull_users($feedid, $userid)
    {
        $query = \DB::select('nickname', 'user.id', 'user.thumbnail')->from('pull')
            ->join('feed')->on('feed.id', '=', 'pull.feed_id')
            ->join('user')->on('user.id', '=', 'pull.user_id')
            ->where('pull.feed_id', '=', $feedid)
            ->execute()
            ->as_array();

        if(0 < count($query)){
            return $query;
        }else{
            return null;
        }

        return $query;
    }
}

