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

        echo '<pre>';
        var_dump($new);
        echo '</pre>';

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

        echo '<pre>';
        var_dump($query);
        echo '</pre>';

        return $query;
    }

}

