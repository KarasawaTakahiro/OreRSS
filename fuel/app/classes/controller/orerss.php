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
            'items'     => Model_Itemtbl::get_itemlist_column_from_feed_id(1),
        );

        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    // item一覧ページ
    public function action_feed($feed_id){
        $data = array(
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread(),
                                 'read'   => Model_Feedtbl::get_feed_list_read(),
                                 ),
            'items'     => Model_Itemtbl::get_itemlist_column_from_feed_id($feed_id),
        );
        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    // テストコード
    public function action_registNewFeed($mylist_url){
        $rss = new \Model_Rss();
        $rss->regist_new_feed($mylist_url);
    }

    // テストコード 
    public function action_updateFeed($feed_id){
        echo '<pre>';
        var_dump((new \Model_Rss())->update());
        echo '</pre>';
    }



}

