<?php

define('TABLE_ITEM', 'item');

class Model_Itemtbl extends \Model
{
    public static function get_all_column_from_id($id){
        $query = \DB::select()->from(TABLE_ITEM)->where('id', '=', $id);
        return $query->execute()->as_array();
    }

    public static function get_itemlist_column_from_feed_id($feed_id){
        $query = \DB::select('id', 'title', 'link', 'already_read', 'pub_date', 'feed_id')
                      ->from(TABLE_ITEM)
                      ->where('feed_id', '=', $feed_id)
                      ->order_by('pub_date')
                      ->execute();
        return $query->as_array();
    }

    public static function get_all_unread_itemlist(){
        $query = \DB::select('id', 'title', 'link', 'already_read', 'pub_date', 'feed_id')
                      ->from(TABLE_ITEM)
                      ->where('already_read', '=', false)
                      ->order_by('pub_date')
                      ->execute();

        $res = array();
        foreach($query->as_array() as &$item){
            $item['link'] = Model_Url::gen_continuous_playback_url(
                                Model_Rss::convert_url(
                                    Model_Feedtbl::get_url_from_id($item['feed_id'])
                                ),
                                $item['link']
                            );
            array_push($res, $item);
        }

        return $res;
    }

    public static function get_pubDate($id){
        $query = \DB::select('pub_date')->where('id', '=', $id)
                                        ->execute();
        return $query->as_array()[0]['pub_date'];
    }

    public static function set($title, $url, $pub_date, $feed_id, $guid){
        $query = \DB::insert(TABLE_ITEM)->set(array(
                                    'title'     => $title,
                                    'link'  => $url,
                                    'pub_date'  => $pub_date,
                                    'feed_id'   => $feed_id,
                                    'guid'      => $guid
              ));
        return $query->execute();
    }

    public static function set_already_read($id, $already_read=false){
      $query = \DB::update(TABLE_ITEM)->value('already_read', $already_read)
        ->where('id', '=', $id);
      return $query->execute();
    }

    /*
       指定のitemよりも古い物を全て見たとする
     */
    public static function setRead($feed_id, $item_id){
      $pub_date = \DB::select('pub_date')->where('id', '=', $item_id)
        ->execute()[0]['pub_date'];
      $query = \DB::update(TABLE_ITEM)->value('already_read', $already_read)
        ->where('feed_id', '=', $feed_id)
        ->where('id', '<=', $item_id)
        ->where('pub_date', '<=', $pub_date)
        ->execute();
    }

}
