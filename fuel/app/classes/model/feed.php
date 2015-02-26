<?php

define('IMG_USER_THUMBNAIL', 'assets'.DS.'img'.DS.'user');          // ユーザのサムネイル保存先

class Model_Feed extends \Model
{
    public static function userlist($feedid, $usreid)
    {
        $users = Model_Pull::get_pull_users($feedid, $usreid);
        foreach($users as &$user){
            $user['thumbnail'] = Uri::create(IMG_USER_THUMBNAIL.DS.$user['thumbnail']); // URIに変換
        }
        unset($user);

        return $users;
    }
}
