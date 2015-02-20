<?php

define('TABLE_NAME', 'latest');
define('RECORDS_NUM', 12);

class Model_Latest extends \Model
{
    /*
     * 新規登録
     *
     * $itemid: ItemテーブルのID
     */
    public static function set($itemid)
    {
        // 新しいものを取り出す
        $query = DB::select('item_id')->from(TABLE_NAME)
            ->order_by('pub_date', 'desc')
            ->limit(RECORDS_NUM-1);
        $new = $query->execute()->as_array();

        // 規定数以上なら削除する
        if(0 < count($new)){
            $query = DB::delete(TABLE_NAME)
                ->where('item_id', 'not in', $new)
                ->execute();
        }

        // 記録
        $query = DB::insert(TABLE_NAME)->set(array(
                        'item_id'   => $itemid))
                    ->execute();

        return $query;
    }

    /*
     * 値の取得
     * 新しい順にitemテーブルの情報を付与して返す
     */
    public static function get()
    {
        $query = DB::select('*')->from(TABLE_NAME)
            ->join('item')->on(TABLE_NAME.'.item_id', '=', 'item.id')
            ->order_by(TABLE_NAME.'.pub_date', 'desc')
            ->execute()
            ->as_array();
        return $query;
    }

}

