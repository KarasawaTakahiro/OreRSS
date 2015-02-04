<?php

/*
 * ユーザ新規登録時に使用する
 */
class Model_Signup extends \Model
{
    /*
     * ニックネームの整合性を確認する
     */
    public static function checkNickname($nickname)
    {
        $len = mb_strlen($nickname);

        // 2文字以上10文字以下
        if($len < 2 ||10 < $len){
            return false;
        }else{
            return true;
        }
    }

    /*
     * パスワードの整合性を確認する
     */
    public static function checkPasswds($pw, $rpw)
    {
        $re = '/[0-9a-zA-Z]+/';
        $len_pw = mb_strlen($pw);
        $len_rpw = mb_strlen($rpw);

        // 使用文字列チェック
        preg_match($re, $pw, $mat);
        if($mat == true){
            $mat = $mat[0];
            if($mat == null || ($len_pw != mb_strlen($mat))){
                return false;
            }
        }else{
            return false;
        }

        // 文字数チェック
        if($len_pw < 6 || 12 < $len_pw){
            return false;
        }

        // 一致チェック
        if($len_pw != $len_rpw || $pw != $rpw){
            return false;
        }

        return true;
    }

}

