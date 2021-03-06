<?php

define('DIR_THUMBNAIL', DOCROOT.'assets'.DS.'img'.DS.'user');

class Controller_Orerss extends Controller_Template
{

// --- get ----------------------------------------------------------------------------

    /*
     * インデックスページ
     */
    public function get_index()
    {
        $data = array();

        if(self::help_userid() != null){            // ログイン時
            $data['login'] = true;
            $data['pickups'] = Model_Index::pickup(true);
            $data['updates'] = Model_Index::update();
            $data['userdata'] = array(
                'name' => self::help_nickname(),
                'thumbnail'    => Model_User::get_thumbnail(self::help_userid()),
            );
        }else{
            $data['login'] = false;
            $data['updates'] = Model_Index::update();
            $data['pickups'] = Model_Index::pickup();
        }

        $this->template->nickname = self::help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/index', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'rss.min.js', 'user.min.js');
        $this->template->css = array('bootstrap.min.css', 'index.min.css');
    }

    /*
     * dashboard
     * 未視聴動画一覧ページ
     * ログイン後はここに飛ぶ
     *      // feed
     *      items = array(
     *          // 1 item
     *          array(
     *              title=>'', link='', already_read=bool, pub_date='', 
     *          ),
     *          array(...),
     *      )
     */
    public function get_dashboard()
    {
        self::help_isLogin();

        $userid = Session::get('userid');

        $data = array(
            // 取得済みのフィードリスト
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread($userid),     // 未読を含む
                                 'read'   => Model_Feedtbl::get_feed_list_read($userid),        // 未読を含まない
                                 ),
            'items'     => Model_Itemtbl::get_all_unread_itemlist($userid), // 未読のitem全てのリスト
            'userlist'  => Model_Pull::get_near_users($userid),             // ユーザに近いユーザリスト
            'nickname'  => self::help_nickname(),
            'direction' => 'up',
            'randomfeed'=> Model_Dashboard::random_feed(),
        );


        $this->template->nickname = $this->help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/dashboard', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'rss.min.js');
        $this->template->css = array('bootstrap.min.css', 'dashboard.min.css');

    }

    /*
     * フィード一覧ページ
     *  フィードに登録された動画の一覧とそれの視聴状況がわかる
     *  そのフィードを購読しているユーザが表示される
     */
    public function get_feed($feed_id)
    {
        self::help_isLogin();

        $userid = Session::get('userid');

        $data = array(
            // 取得済みのフィードリスト
            'feed_list' => array('unread' =>  Model_Feedtbl::get_feed_list_unread($userid),
                                 'read'   => Model_Feedtbl::get_feed_list_read($userid),
                                 ),
            // 指定フィードのitemリスト
            'items'     => Model_Url::convert_continuous_playback_url(Model_Itemtbl::get_itemlist_column_from_feed_id_with_watched($feed_id, $userid)),
            'nickname'  => self::help_nickname(),
            'userlist'  => Model_Pull::get_pull_users($feed_id, $userid),
            'direction' => 'down',
        );

        // 404
        if($data['items'] == null)
            throw new HttpNotFoundException;

        $this->template->nickname = $this->help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/feed', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'rss.min.js');
        $this->template->css = array('bootstrap.min.css', 'feed.min.css');
    }

    /*
     * ログインページ
     */
    public function get_login()
    {
        self::help_isLogout();
        $data = array();

        $this->template->nickname = $this->help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/login', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'sign-form.min.js', 'login.min.js');
        $this->template->css = array('bootstrap.min.css', 'login.min.css');
    }

    /*
     * 新規登録
     */
    public function get_signup()
    {
        self::help_isLogout();
        $data = array();

        $this->template->nickname = $this->help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/signup', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'sign-form.min.js', 'signup.min.js');
        $this->template->css = array('bootstrap.min.css', 'signup.min.css');
    }

    /*
     * ユーザページ
     */
    public function get_user($vuserid)
    {
        self::help_isLogin();

        $userid = Session::get('userid');

        // 404
        if(Model_User::get_nickname($vuserid) == null)
            throw new HttpNotFoundException;

        $data = array(
            'nickname' => self::help_nickname(),
            'pulllists' => Model_Userp::pulllist($vuserid),
            'vuser'     => Model_Userp::get_vuser($vuserid),
            // 取得済みのフィードリスト
            'feed_list' => array(
                'unread' =>  Model_Feedtbl::get_feed_list_unread($userid),     // 未読を含む
                'read'   => Model_Feedtbl::get_feed_list_read($userid),        // 未読を含まない
            ),
        );

        $this->template->nickname = self::help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/user', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'rss.min.js', 'user.min.js');
        $this->template->css = array('bootstrap.min.css', 'user.min.css');
    }

    /*
     * 設定画面
     */
    public function get_settings()
    {
        self::help_isLogin();

        $data = array();
        $data['thumbnail'] = Model_User::get_thumbnail(self::help_userid());
        $this->template->nickname = self::help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/settings', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'rss.min.js');
        $this->template->css = array('bootstrap.min.css', 'settings.min.css');
    }

    /*
     * チュートリアル
     */
    public function get_tutor($page=null)
    {
        // ページが存在するか
        if($page == null || ($page != 'whatis' && $page != 'rss' && $page != 'find')){
            $page = 'whatis';
        }

        $data = array('page'    => $page);
        $this->template->contents = View_Smarty::forge('orerss/tutor', $data);
        $this->template->nickname = self::help_nickname();
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'rss.min.js');
        $this->template->css = array('bootstrap.min.css', 'tutor.min.css');
    }

    /*
     * お知らせ
     */
    public function get_announce()
    {
        $data = array();
        $this->template->contents = View_Smarty::forge('orerss/announce', $data);
        $this->template->nickname = self::help_nickname();
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js', 'rss.min.js');
        $this->template->css = array('bootstrap.min.css', 'announce.min.css');
    }

    /*
     * ログアウト
     */
    public function get_logout()
    {
        Session::delete('userid');
        Response::redirect('/');
    }

// --- post -----------------------------------------------------------------------------

    /*
     * 新規登録POST
     */
    public function post_signup()
    {
        $nickname = Input::post('nickname');
        $passwd = Input::post('passwd');


        // DB問い合わせ
        if(Model_User::isUnique($nickname) == false){                    // ユニークか
            Response::redirect('/signup');
        }

        Model_User::add($nickname, $passwd);                // 新規登録
        $userid = Model_User::login($nickname, $passwd);    // ログイン

        if($userid != null){    // ログイン成功
            Session::set('userid', $userid);
            Session::set('nickname', $nickname);
            Response::redirect('/dashboard');
        }else{                  // ログイン失敗
            Response::redirect('/signup');
        }
    }

    /*
     * ログイン
     */
    public function post_login(){
        $nickname = Input::post('nickname');

        // DB問い合わせ
        $userid = Model_User::login($nickname, Input::post('passwd'));

        if($userid){    // ログイン成功
            Session::set('userid', $userid);
            Session::set('nickname', $nickname);
            Response::redirect('dashboard');
        }else{                  // ログイン失敗
            Response::redirect('/login');
        }

    }

    /*
     * 設定
     */
    public function post_settings()
    {
        $userid = self::help_userid();
        $thumbnail = self::help_userThumbnailUpload();  // サムネイルを取得
        if(0 < count($thumbnail['success'])){           // アップロード成功
            // 先に登録されているものかつ，デフォルトでないものを削除
            $thumb = Model_User::get_thumbnail($userid);
            if(($thumb != null) && (mb_substr($thumb, 0, 7) != 'default')){
                unlink(DIR_THUMBNAIL.DS.$thumb);
            }
            // サムネイルをDBに保存
            Model_User::set_thumbnail(self::help_userid(), $thumbnail['success'][0]['saved_as']);
        }

        Response::redirect('/settings');
    }

// --- ajax ---------------------------------------------------------------------------

    /*
     * itemに既読をつける - ajax用API
     */
    public function post_markRead($item_id){
        $userid = Session::get('userid');
        if(0 < \Model_Watch::set_watched($userid, $item_id)){
            return true;
        }else{
            return false;
        }
    }

    /*
     * automark用 既読にする - ajax用API
     */
    public function post_automarkRead($feed_id, $item_id){
      $changed = \Model_Itemtbl::setRead($feed_id, $item_id, Session::get('userid'));
      return json_encode($changed);
    }

    /*
     * フィードの新規登録 - ajax用API
     */
    public function post_registNewFeed(){
      $feed_url = Input::post('url');
      $userId = Session::get('userid');

      $res = json_encode((new \Model_Rss())->regist_new_feed($userId, $feed_url));
      return $res;
    }

    /*
     * feedを更新する - ajax
     */
    public function post_updateFeed(){
        $updated = (new Model_Rss())->update();
        return json_encode(array('update_num' => $updated));
    }

    /*
     * フィードの購読解除
     */
    public function post_unpullFeed(){
      $userid = Session::get('userid');             // ユーザID
      $feedid = Input::post('fid');                 // フィードID
      Model_Watch::del($userid, $feedid);           // 動画の視聴状況を削除
      Model_Pull::del($userid, $feedid);            // 購読状況を削除

      return true;
    }

    /*
     * smart pull
     *
     * Input
     *  feedid - フィードID
     */
    public function post_smartpull(){
        $userid = self::help_userid();
        $feedid = Input::post('feedid');
        return json_encode(Model_Rss::pull_feed($feedid, $userid));
    }

    /*
     * Ringからfeedを更新する
     */
    public function get_updateRing(){
        (new Model_Rss())->update();
    }

// --- action --------------------------------------------------------------------

    /*
     * 404
     */
    public function action_404()
    {
        $data = array();
        $this->template->nickname = self::help_nickname();
        $this->template->contents = View_Smarty::forge('orerss/404', $data);
        $this->template->js = array('jquery.min.js', 'bootstrap.min.js');
        $this->template->css = array('bootstrap.min.css', '404.min.css');
    }

// --- help ---------------------------------------------------------------------

    /*
     * ユーザIDを取得
     */
    private function help_userid(){
        $userid = Session::get('userid', null);     // セッションのユーザIDを取得
        if($userid != null){ return $userid;        // 取得成功でIDを返す
        }else{ return null;                         // 取得失敗でnullを返す
        }
    }

    /*
     * セッションからユーザIDを取得してニックネームを取得する
     */
    private function help_nickname(){
        if(Session::get('userid') != null){
            return Model_User::get_nickname(Session::get('userid'));
        }else{
            return null;
        }
    }

    /*
     * ログイン状態でアクセスすべきページで呼ぶ
     */
    private function help_isLogin()
    {
        if(Session::get('userid') == null){
            Response::redirect('/login');
        }
    }

    /*
     * ログアウト状態でアクセスすべきページで呼ぶ
     */
    private function help_isLogout()
    {
        if(Session::get('userid') != null){
            Response::redirect('/logout');
        }
    }

    /*
     * 画像のアップロード
     */
    private function help_userThumbnailUpload()
    {
        $config = array(
            'path'          => DIR_THUMBNAIL,                   // 保存先
            'randomize'     => true,                            // ファイル名をランダムに
            'ext_whitelist' => array('jpg', 'jpeg', 'png'),     // うp可能拡張子
        );

        // うp開始
        Upload::process($config);
        if(Upload::is_valid()){
            Upload::save();
        }

        return array(
            'success'   => Upload::get_files(),
            'faileds'   => Upload::get_errors(),
        );
    }

}

