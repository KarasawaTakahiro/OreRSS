<?php

class Controller_Orerss extends Controller{
    public function action_index(){

        return Response::forge(View_Smarty::forge('orerss/index'));
    }

    public function action_registNewFeed($mylistid){
        $rss = new \Model_Rss();
        $rss->regist_new_feed($mylistid);
    }



}

