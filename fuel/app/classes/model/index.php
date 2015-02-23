<?php

define('PICKUP_NUM', 5);                                            // PICKUPに表示する数
define('IMG_USER_THUMBNAIL', 'assets'.DS.'img'.DS.'user');          // ユーザのサムネイル保存先

class Model_Index extends \Model
{
    public static function pickup()
    {
        // フィードの中からランダムにPICKUP_NUMだけを選ぶ
        $allids = Model_Feedtbl::get_all_feed_ids();                    // 全ID取得
        $inds = array_rand($allids, min(count($allids), PICKUP_NUM));   // ランダムにインデックスを選択
        shuffle($inds);                                                 // シャッフル

        // インデックスをIDに直す
        $ids = array();
        foreach($inds as $i){
            array_push($ids, $allids[$i]);
        }


        // 情報収集
        $pickups = array();
        foreach($ids as $id){
            $col = Model_Feedtbl::get_all_column_from_id($id)[0];   // 全カラムを取得
            $item['title'] = $col['title'];                         // タイトル
            $item['description'] = $col['description'];             // 説明文
            $item['pullnum'] = $col['pull_num'];                    // 購読数
            $latest = Model_Feedtbl::get_latest_item($id);          // フィードの最新itemを取得
            if($latest){
                $item['thumbnail'] = Model_Itemtbl::get_thumbnail_from_id($latest['id']);   // サムネイル
                $item['users'] = Model_Pull::get_all_pull_users($id, $latest);              // PULLユーザ情報
                foreach($item['users'] as &$user){
                    $user['thumbnail'] = Uri::create(IMG_USER_THUMBNAIL.DS.$user['thumbnail']); // URIに変換
                }
                unset($user);
            }else{
                $item['thumbnail'] = '';
                $item['users'] = array();
            }
            array_push($pickups, $item);
        }

        return $pickups;
    }

    /*
     * pickupに表示するデータ
     */
    public static function update($offset=0)
    {
        $updates = array();
        foreach(Model_Latest::get($offset) as $col){
            $item['thumbnail'] = Model_Itemtbl::get_thumbnail_from_id($col['item_id']);
            $item['mylistname'] = Model_Feedtbl::get_all_column_from_id($col['feed_id'])[0]['title'];
            $item['moviename'] = $col['title'];
            $item['datetime'] = $col['modified_at'];
            array_push($updates, $item);
        }

        return $updates;
    }
}
