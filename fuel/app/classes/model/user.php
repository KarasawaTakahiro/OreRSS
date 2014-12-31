<?php

class Model_User extends \Model
{
    /*
     * ニックネームからuseridを得る
     */
    public static function getUserid($nickname, $passwd){
        if($nickname == false or $passwd == false){ // 引数チェック
            return null;
        }

        // ニックネームからuseridを得る
        $query = \DB::select('id')->from('user')
                                  ->where('nickname', '=', $nickname)
                                  ->where('passwd', '=', $passwd);
        $res = $query->execute();       // クエリを実行

        // 1つ目を返す
        if($res != null){
            return $res[0];
        }else{
            return null;
        }
    }
}
