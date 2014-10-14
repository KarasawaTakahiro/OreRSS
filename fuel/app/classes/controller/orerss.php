<?php

class Controller_Orerss extends Controller{

    // index 兼 Dashboard
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
            // 取得済みのフィードリスト
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread(),  // 未読を含む
                                 'read'   => Model_Feedtbl::get_feed_list_read(),     // 未読を含まない
                                 ),
            // 未読のitem全てのリスト
            'items'     => Model_Itemtbl::get_all_unread_itemlist(),
        );

        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    // item一覧ページ
    public function get_feed($feed_id){
        $data = array(
            // 取得済みのフィードリスト
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread(),
                                 'read'   => Model_Feedtbl::get_feed_list_read(),
                                 ),
            // 指定フィードのitemリスト
            'items'     => Model_Itemtbl::get_itemlist_column_from_feed_id($feed_id),
        );
        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    // itemに既読をつける - ajax用API
    public function post_markRead($item_id){
      if(0 < \Model_Itemtbl::set_already_read($item_id, true)){
        return true;
      }else{
        return false;
      }
    }

    // automark用 既読にする - ajax用API
    public function post_automarkRead($feed_id, $item_id){
      $changed = \Model_Itemtbl::setRead($feed_id, $item_id);
      return json_encode($changed);
    }

    // フィードの新規登録 - ajax用API
    public function post_registNewFeed(){
      $feed_url = Input::post('url');
      $res = json_encode((new \Model_Rss())->regist_new_feed($feed_url));
      return $res;
    }

    // テストコード フィードの更新
    public function action_updateFeed($feed_id){
        echo '<pre>';
        var_dump((new \Model_Rss())->update());
        echo '</pre>';
    }



}

