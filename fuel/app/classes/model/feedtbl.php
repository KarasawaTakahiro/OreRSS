<?php

define('TABLE_FEED', 'feed');

class Model_Feedtbl extends \Model
{
    // idから全てのカラムを取得する
    public static function get_all_column_from_id($id){
        $query = \DB::select()->from(TABLE_FEED)->where('id', '=', $id);
        return $query->execute()->as_array();
    }

    // 全てのフィードのidを取得
    public static function get_all_feed_ids(){
        $ids = array();
        $query = \DB::select('id')->from(TABLE_FEED);
            foreach($query->execute()->as_array() as $id){
                array_push($ids, $id['id']);
            }

        return $ids;
    }

    // データの新規登録
    public static function set($url, $title){
        $query = \DB::insert(TABLE_FEED)->set(array(
                                    'url'      => $url,
                                    'title'    => $title,
                                    ));
        return $query->execute();
    }

    // フィードのURLからidを取得する
    // $url: feed url
    public static function get_id_from_url($url){
        $query = \DB::select('id')->from(TABLE_FEED)
                                  ->where('url', '=', $url)
                                  ->execute();

        if(0 < count($query->as_array())){
            return $query->as_array()[0]['id'];
        }else{
            return null;
        }
    }

    // idからフィードのURLを取得
    public static function get_url_from_id($id){
        $query = \DB::select('url')->from(TABLE_FEED)
                                  ->where('id', '=', $id)
                                  ->execute();

        if(0 < count($query->as_array())){
            return $query->as_array()[0]['url'];
        }else{
            return null;
        }
    }

    // 未読を含むフィードリストを返す
    public static function get_unread_list($userid)
    {
        $query = \DB::select('feed.id', 'feed.title')->from('feed')
                                                     ->join('item')
                                                     ->on('feed.id', '=', 'item.feed_id')
                                                     ->join('watch')
                                                     ->on('watch.item_id', '=', 'item.id')
                                                     ->join('user')
                                                     ->on('user.id', '=', 'watch.user_id')
                                                     ->join('pull')
                                                     ->on('pull.feed_id', '=', 'feed.id')
                                                     ->on('pull.user_id', '=', 'user.id')
                                                     ->where('watched', '=', false)
                                                     ->where('user.id', '=', $userid)
                                                     ->group_by('feed.id')
                                                     ->order_by('watch.modified_at');

        return $query->execute()->as_array();
    }

    // 既読のみのフィードリストを返す
    public static function get_feed_list_read($userid){
        $unwatch = \DB::select('feed.id', 'feed.title')->from('feed')
                                                     ->join('item')
                                                     ->on('feed.id', '=', 'item.feed_id')
                                                     ->join('watch')
                                                     ->on('watch.item_id', '=', 'item.id')
                                                     ->join('user')
                                                     ->on('user.id', '=', 'watch.user_id')
                                                     ->where('watched', '=', false)
                                                     ->where('user.id', '=', $userid)
                                                     ->group_by('feed.id')
                                                     ->order_by('watch.modified_at')
                                                     ->execute()
                                                     ->as_array();

        $watched = \DB::select('feed.id', 'feed.title')->from('feed')
                                                     ->join('item')
                                                     ->on('feed.id', '=', 'item.feed_id')
                                                     ->join('watch')
                                                     ->on('watch.item_id', '=', 'item.id')
                                                     ->join('user')
                                                     ->on('user.id', '=', 'watch.user_id')
                                                     ->where('watched', '=', true)
                                                     ->where('user.id', '=', $userid)
                                                     ->group_by('feed.id')
                                                     ->order_by('watch.modified_at', 'desc')
                                                     ->execute()
                                                     ->as_array();

        $i = 0;
        foreach($watched as $w){
            foreach($unwatch as $un){
                if($w['id'] == $un['id']){
                    unset($watched[$i]);      // 参照を解除
                    break;
                }
            }
            $i += 1;
        }

        return $watched;

    }

    // idのカラムを未読にする
    public static function set_unread($id){
        $query = \DB::update(TABLE_FEED)->value('exist_unread', true)->where('id', '=', $id);
        return $query->execute();
    }

    // idのカラムを既読にする
    public static function set_already_read($id){
        /*
        $query = \DB::update(TABLE_FEED)->value('exist_unread', false)->where('id', '=', $id);
        return $query->execute();
         */
        return null;
    }

    // ルールに従ってソートしたフィードリストを返す
    public static function get_sorted_data_from_id($id){
        $query = \DB::select()->from(TABLE_FEED)->where('id', '=', $id)
                              ->order_by('timestamp')
                              ->order_by('exist_unread');
        return $query->execute()->as_array();
    }

    /*
     * 指定ユーザが購読しているfeedを返す
     * タイトルとfeedid
     */
    public static function get_user_pull($userid)
    {
        $query = \DB::select('feed.id', 'feed.title', 'feed.url', 'feed.pull_num', 'feed.description')
            ->from('feed')
            ->join('pull')->on('feed.id', '=', 'pull.feed_id')
            ->join('user')->on('user.id', '=', 'pull.user_id')
            ->where('user.id', '=', $userid)
            ->execute()
            ->as_array();

        return $query;
    }

    /*
     * フィードの購読数を１だけ増やす
     */
    public static function inc_pull_num($id)
    {
        // 現在の値を取得
        $query = DB::select('pull_num')->from(TABLE_FEED)
                                       ->where('id', '=', $id)
                                       ->execute();
        $num = $query->as_array()[0]['pull_num'];
        // 更新
        $query = DB::update(TABLE_FEED)->value('pull_num', $num+1)
                                       ->where('id', '=', $id)
                                       ->execute();
        return $query;
    }

    /*
     * マイリスト説明文を登録
     */
    public static function set_description($id, $description)
    {
        return DB::update(TABLE_FEED)
            ->value('description', $description)
            ->where('id', '=', $id)
            ->execute();
    }

    /*
     * マイリストの説明文を取得する
     */
    public static function get_description($id)
    {
        $query = DB::select('description')->from(TABLE_FEED)
            ->where('id', '=', $id)
            ->execute()
            ->as_array();

        if(0 < count($query)){
            return $query[0]['description'];
        }else{
            return null;
        }
    }

    /*
     * 指定フィードの最新itemを取得する
     */
    public static function get_latest_item($id, $limit=1)
    {
        $query = DB::select()->from('item')
            ->where('feed_id', '=', $id)
            ->order_by('pub_date', 'desc')
            ->limit($limit)
            ->execute()
            ->as_array();

        if(0 < count($query)){
            return $query[0];
        }else{
            return null;
        }
    }

    /*
     * 指定フィードのitemを新しい順に取得する
     */
    public static function get_later_item($id, $limit=1)
    {
        $query = DB::select()->from('item')
            ->where('feed_id', '=', $id)
            ->order_by('pub_date', 'desc')
            ->limit($limit)
            ->execute()
            ->as_array();

        if(0 < count($query)){
            return $query;
        }else{
            return null;
        }
    }

    /*
     * フィードの未読数を得る
     */
    public static function get_num_feed_list_unread($userid, $feedid)
    {
        $query = \DB::select()->from('feed')
            ->join('item')
            ->on('feed.id', '=', 'item.feed_id')
            ->join('watch')
            ->on('watch.item_id', '=', 'item.id')
            ->join('user')
            ->on('user.id', '=', 'watch.user_id')
            ->join('pull')
            ->on('pull.feed_id', '=', 'feed.id')
            ->on('pull.user_id', '=', 'user.id')
            ->where('watched', '=', false)
            ->where('user.id', '=', $userid)
            ->where('feed.id', '=', $feedid)
            ->execute();

        return count($query);
    }

    /*
     * フィードのリストを未読数とともに取得する
     */
    public static function get_feed_list_unread($userid)
    {
        $list = Model_Feedtbl::get_unread_list($userid);
        foreach($list as &$feed){
            $feed['unread_num'] = self::get_num_feed_list_unread($userid, $feed['id']);
            unset($feed);
        }

        return $list;
    }

    /*
     * 登録されたフィードの中からランダムに指定数取得
     */
    public static function get_random($limit=1)
    {
        return DB::query('SELECT * FROM '.TABLE_FEED.' ORDER BY rand() limit :lim')
            ->bind('lim', $limit)
            ->execute()
            ->as_array();
    }
}


