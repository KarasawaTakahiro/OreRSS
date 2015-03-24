<?php

define('TABLE_NAME_', 'user');

class Model_User extends \Model
{
    /*
     *  ユーザIDがユニークか
     */
    public static function isUnique($nickname){
        $query = \DB::select()->from('user')->where('nickname', '=', $nickname)->execute();

        if(count($query) == 0){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 新規登録
     */
    public static function add($nickname, $passwd)
    {
        // 保存
        $query = \DB::insert('user')->set(array(
                             'nickname'    => $nickname,
                             'passwd'      => password_hash($passwd, PASSWORD_DEFAULT),
                             'pub_date'     => Date::time()->format('mysql'),
                             'thumbnail'    => 'default'.rand(1, 6).'.png',
                              ));

        return $query->execute();

    }

    /*
     * ログイン
     */
    public static function login($nickname, $passwd)
    {
        if($nickname == false or $passwd == false){ // 引数チェック
            return null;
        }

        // ニックネームからuseridを得る
        $query = \DB::select()->from('user')
                              ->where('nickname', '=', $nickname);
        $res = $query->execute();                           // クエリを実行

        if(count($res) == 0) return null;                   // DBにない

        $arr = $res->as_array();                            // 配列化
        if(password_verify($passwd, $arr[0]['passwd'])){    // passwdの照合
            return $arr[0]['id'];                           //ユーザIDを返す
        }else{                                              // passwdが違う
            return null;
        }
    }

    /*
     * ニックネームを得る
     */
    public static function get_nickname($id)
    {
        $query = \DB::select('nickname')->from('user')
            ->where('id', '=', $id)
            ->execute()
            ->as_array();

        if(count($query) < 1){
            return null;
        }else{
            return $query[0]['nickname'];
        }

    }

    /*
     * サムネイル登録
     */
    public static function set_thumbnail($userid, $filename)
    {
        $query = DB::update(TABLE_NAME_)
            ->value('thumbnail', $filename)
            ->where('id', '=', $userid)
            ->execute();

        return $query;
    }

    /*
     * サムネイルファイル名取得 
     */
    public static function get_thumbnail($userid)
    {
        return DB::select('thumbnail')->from(TABLE_NAME_)
            ->where('id', '=', $userid)
            ->execute()
            ->as_array()[0]['thumbnail'];
    }

    /*
     * パスワード以外の情報を取得
     */
    public static function get_data($userid)
    {
        $query = DB::select('id', 'modified_at', 'pub_date', 'nickname', 'thumbnail')
            ->from(TABLE_NAME)
            ->where('id', '=', $userid)
            ->execute()
            ->as_array();

        if(0 < count($query)){
            return $query[0];
        }else{
            return null;
        }
    }

}
