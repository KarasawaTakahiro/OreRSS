<?php

class Controller_Orerss extends Controller{
    public function action_index(){
        /*
            array(
                array(
                    title=>'', link='', unread=bool, pubDate='', 
                )
            )
        */

        return Response::forge(View_Smarty::forge('orerss/index'));
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

