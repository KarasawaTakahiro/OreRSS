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

    /*
     * 項目削除
     */
    public static function del($userid, $feedid)
    {
        // 指定ユーザかつ指定フィードを親に持つ視聴状況を削除
        $query = \DB::query("delete watch from watch join item on item.id = watch.item_id where user_id = $userid and feed_id = $feedid")->execute();
        return $query;
    }

}
