<?php

class Model_Util extends \Model
{
    const IMG_USER_THUMBNAIL = 'assets/img/user';     // ユーザのサムネイル保存先

    public static function uri_thumbnail_user($path)
    {
        return Uri::create(self::IMG_USER_THUMBNAIL.DS.$path);
    }
}

