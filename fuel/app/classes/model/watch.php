<?php

define('TABLE_WATCH', 'watch');

class Model_Watch extends \Model
{
    // 新規登録
    public static function add($itemId, $userId){
        $query = \DB::insert(TABLE_WATCH)->set(array(
            'item_id'   => $itemId,
            'user_id'   => $userId,
            'pub_date'  => Date::time()->format('mysql'),
        ));

        $num = $query->execute();
        return $num;
    }

    /*
     * 既読をつける
     *
     * 既読をつけた数を返す
     */
    public static function set_watched($userId, $itemId)
    {
        return \DB::update(TABLE_WATCH)->value('watched', true)
            ->where('user_id', '=', $userId)
            ->where('item_id', '=', $itemId)
            ->execute();
    }
}
