<?php

class Controller_Orerss extends Controller{
    public function action_index(){
        /*
            // feed
            items = array(
                // 1 item
                array(
                    title=>'', link='', already_read=bool, pub_date='', 
                ),
                array(...),
            )
        */

        $data = array(
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread(),
                                 'read'   => Model_Feedtbl::get_feed_list_read(),
                                 ),
            'items'     => Model_Itemtbl::get_all_unread_itemlist(),
        );

        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    // item一覧ページ
    public function get_feed($feed_id){
        $data = array(
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread(),
                                 'read'   => Model_Feedtbl::get_feed_list_read(),
                                 ),
            'items'     => Model_Itemtbl::get_itemlist_column_from_feed_id($feed_id),
        );
        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    public function post_markRead($item_id){
      if(0 < \Model_Itemtbl::set_already_read($item_id, true)){
        return true;
      }else{
        return false;
      }
    }

    public function post_autoreadRead($feed_id, $item_id){
      $changed = \Model_Itemtbl::setRead($feed_id, $item_id);
      return json_encode($changed);
    }

    public function post_registNewFeed($feed_url){
      return json_encode(\Model_Rss::regist_new_feed($feed_url));
    }

    // テストコード 
    public function action_updateFeed($feed_id){
        echo '<pre>';
        var_dump((new \Model_Rss())->update());
        echo '</pre>';
    }



}

