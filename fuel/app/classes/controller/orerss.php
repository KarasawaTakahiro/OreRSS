<?php

class Controller_Orerss extends Controller{
    public function action_index(){

        return Response::forge(View_Smarty::forge('orerss/index'));
    }

    public function post_registNewFeed($mylist_url){
        $rss = new \Model_Rss();
        $rss->regist_new_feed($mylist_url);
    }



}

