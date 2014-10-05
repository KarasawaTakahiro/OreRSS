<?php

define('TABLE', 'item');

class Model_Itemtbl extends \Model
{
    public static function get_all_column_from_id($id){
        $query = \DB::select()->from(TABLE)->where('id', '=', $id);
        return $query->execute()->as_array();
    }

    public static function set($title, $url, $pub_date, $feed_id, $guid){
        $query = \DB::insert(TABLE).values(array(
                                    'title'     => $title,
                                    'page_url'  => $url,
                                    'pub_date'  => $pub_date,
                                    'feed_id'   => $feed_id,
                                    'guid'      => $guid
                                    ));
        return $query->execute();
    }

    public static function set_already_read($id, $already_read=false){
        $query = \DB::udpate(TABLE)->value('already_read', $already_read)
                                   ->where('id', '=', $id);
        return $query->execute();
    }

}
