<?php

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

        if($res == null) return null;                       // DBにない

        $arr = $res->as_array();                            // 配列化
        if(password_verify($passwd, $arr[0]['passwd'])){    // passwdの照合
            return $arr[0]['id'];                           //ユーザIDを返す
        }else{                                              // passwdが違う
            return null;
        }
    }

}
