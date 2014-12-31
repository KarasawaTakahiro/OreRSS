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
    public static function get_feed_list_unread(){
        $query = \DB::select('feed.id', 'feed.title')->from('feed')
                                                     ->join('item')
                                                     ->on('feed.id', '=', 'item.feed_id')
                                                     ->join('watch')
                                                     ->on('watch.item_id', '=', 'item.id')
                                                     ->where('watched', '=', false)
                                                     ->group_by('feed.title')
                                                     ->order_by('watch.modified_at');

        var_dump($query->execute()->as_array());
    }

    // 既読のみのフィードリストを返す
    public static function get_feed_list_read(){
      $query = \DB::select('id', 'title')->from(TABLE_FEED)
                                         ->where('exist_unread', '=', false)
                                         ->order_by('timestamp')
                                         ->execute();

      return $query->as_array();
    }

    // idのカラムを未読にする
    public static function set_unread($id){
        $query = \DB::update(TABLE_FEED)->value('exist_unread', true)->where('id', '=', $id);
        return $query->execute();
    }

    // idのカラムを既読にする
    public static function set_already_read($id){
        $query = \DB::update(TABLE_FEED)->value('exist_unread', false)->where('id', '=', $id);
        return $query->execute();
    }

    // ルールに従ってソートしたフィードリストを返す
    public static function get_sorted_data_from_id($id){
        $query = \DB::select()->from(TABLE_FEED)->where('id', '=', $id)
                              ->order_by('timestamp')
                              ->order_by('exist_unread');
        return $query->execute()->as_array();
    }


}


