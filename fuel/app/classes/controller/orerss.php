<?php

class Controller_Orerss extends Controller{
    public function action_index(){
        /*
            // feed
            items = array(
                // 1 item
                array(
                    title=>'', link='', unread=bool, pubDate='', 
                ),
                array(...),
            )
        */

        $data = array(
            'items' => array(
                array('title' => 'hoge', 'link' => 'http', 'unread' => true, 'pubDate' => '2014/10/10 10:10:10'),
                array('title' => 'hoge', 'link' => 'http', 'unread' => false, 'pubDate' => '2014/10/10 10:10:10'),
            )
        );

        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    // フィード一覧ページ
    public function action_feed($feed_id){
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

