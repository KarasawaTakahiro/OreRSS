<?php

class Controller_Orerss extends Controller
{

    // Dashboard
    public function get_dashboard(){
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

        $userid = Session::get('userid');

        $data = array(
            // 取得済みのフィードリスト
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread($userid),  // 未読を含む
                                 'read'   => Model_Feedtbl::get_feed_list_read($userid),     // 未読を含まない
                                 ),
            // 未読のitem全てのリスト
            'items'     => Model_Itemtbl::get_all_unread_itemlist(),
        );

        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    // item一覧ページ
    public function get_feed($feed_id)
    {
        $userid = Session::get('userid');

        $data = array(
            // 取得済みのフィードリスト
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread($userid),
                                 'read'   => Model_Feedtbl::get_feed_list_read($userid),
                                 ),
            // 指定フィードのitemリスト
            'items'     => Model_Url::convert_continuous_playback_url(Model_Itemtbl::get_itemlist_column_from_feed_id($feed_id)),
        );
        return Response::forge(View_Smarty::forge('orerss/index', $data));
    }

    /*
     * ログインページ
     */
    public function get_login(){
        $data = array();

        return Response::forge(View_Smarty::forge('orerss/login', $data));
    }

    /*
     * ログイン
     */
    public function post_login(){

        // DB問い合わせ
        $userid = Model_User::login(Input::post('nickname'), Input::post('passwd'));

        if($userid){    // ログイン成功
            Session::set('userid', $userid);
            Session::set('nickname', $nickname);
            Response::redirect('/orerss/dashboard');
        }else{                  // ログイン失敗
            Response::redirect('/orerss/login');
        }

    }

    /*
     * 新規登録
     */
    public function get_signup()
    {
        $data = array();

        return Response::forge(View_Smarty::forge('orerss/signup', $data));
    }

    /*
     * 新規登録POST
     */
    public function post_signup()
    {
        $nickname = Input::post('nickname');
        $passwd = Input::post('passwd');


        // DB問い合わせ
        if(Model_User::isUnique($nickname) == false){                    // ユニークか
            Response::redirect('/orerss/signup');
        }

        Model_User::add($nickname, $passwd);                // 新規登録
        $userid = Model_User::login($nickname, $passwd);    // ログイン

        if($userid != null){    // ログイン成功
            Session::set('userid', $userid);
            Session::set('nickname', $nickname);
            Response::redirect('/orerss/dashboard');
        }else{                  // ログイン失敗
            Response::redirect('/orerss/signup');
        }
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

    // feedを更新する - ajax
    public function post_updateFeed(){
        $updated = (new Model_Rss())->update();
        return json_encode(array('update_num' => $updated));
    }

    // Ringからfeedを更新する
    public function get_updateRing(){
        (new Model_Rss())->update();
    }

}

