<?php

define('TABLE_FEED', 'feed');

class Model_Feedtbl extends \Model
{
    public static function get_all_column_from_id($id){
        $query = \DB::select()->from(TABLE_FEED)->where('id', '=', $id);
        return $query->execute()->as_array();
    }

    public static function set($url, $title){
        $query = \DB::insert(TABLE_FEED)->set(array(
                                    'url'      => $url,
                                    'title'    => $title,
                                    ));
        return $query->execute();
    }

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

    public static function set_unread($id){
        $query = \DB::update(TABLE_FEED)->value('exist_unread', true)->where('id', '=', $id);
        return $query->execute();
    }

    public static function set_already_read($id){
        $query = \DB::update(TABLE_FEED)->value('exist_unread', false)->where('id', '=', $id);
        return $query->execute();
    }

    public static function get_sorted_data_from_id($id){
        $query = \DB::select()->from(TABLE_FEED)->where('id', '=', $id)
                              ->order_by('timestamp')
                              ->order_by('exist_unread');
        return $query->execute()->as_array();
    }


}


