<?php

define('TABLE', 'feed');

class Model_Feedtbl extends \Model
{
    public static function get_all_column_from_id($id){
        $query = \DB::select()->from(TABLE)->where('id', '=', $id);
        return $query->execute()->as_array();
    }

    public static function set($url, $title){
        $query = \DB::insert(TABLE)->values(array(
                                    'url'      => $url,
                                    'title'    => $title,
                                    ));
        return $query->execute();
    }

    public static function get_id_from_url($url){
        $query = \DB::select('id')->from(TABLE)->where('url', '=', $url);
        return $query[0]['id'];
    }

    public static function set_unread($id){
        $query = \DB::update(TABLE)->value('exist_unread', true)->where('id', '=', $id);
        return $query->execute();
    }

    public static function set_already_read($id){
        $query = \DB::update(TABLE)->value('exist_unread', false)->where('id', '=', $id);
        return $query->execute();
    }

    public static function get_sorted_data_from_id($id){
        $query = \DB::select()->from(TABLE)->where('id', '=', $id)
                              ->order_by('timestamp')
                              ->order_by('exist_unread');
        return $query->execute()->as_array();
    }

}


