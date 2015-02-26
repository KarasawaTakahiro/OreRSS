<?php

class Model_Dashboard extends \Model
{
    const IMG_USER_THUMBNAIL = 'assets/img/user';     // ユーザのサムネイル保存先
    public static function userlist($userid)
    {
        $users = Model_Pull::get_near_users($userid);
        foreach($users as &$user){
            $user['thumbnail'] = Uri::create(self::IMG_USER_THUMBNAIL.DS.$user['thumbnail']); // URIに変換
        }
        unset($user);

        return $users;
    }

}
