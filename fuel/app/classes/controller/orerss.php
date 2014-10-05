<?php

class Controller_Orerss extends Controller{
    public function action_index(){

        return Response::forge(View_Smarty::forge('orerss/index'));
    }


}

