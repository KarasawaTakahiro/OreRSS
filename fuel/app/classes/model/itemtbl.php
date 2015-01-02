<?php

define('TABLE_ITEM', 'item');

class Model_Itemtbl extends \Model
{
    // idからカラムの全てを取得
    public static function get_all_column_from_id($id){
        $query = \DB::select()->from(TABLE_ITEM)->where('id', '=', $id);
        return $query->execute()->as_array();
    }

    /*
     * フィードに属するitemをソートして取得する
     */
    public static function get_itemlist_column_from_feed_id($feed_id)
    {
        $query = \DB::select('item.id', 'title', 'link', 'item.modified_at', 'item.pub_date', 'feed_id', 'guid')
                      ->from(TABLE_ITEM)
                      ->where('feed_id', '=', $feed_id)
                      ->order_by('pub_date', 'desc')
                      ->execute();
        return $query->as_array();
    }

    /*
     * フィードに属するitemをソートして取得する
     */
    public static function get_itemlist_column_from_feed_id_with_watched($feed_id, $userid) {
        $query = \DB::select('item.id', 'title', 'link', 'item.modified_at', 'item.pub_date', 'feed_id', 'guid', 'watched')
            ->from(TABLE_ITEM)
            ->join('watch')->on('watch.item_id', '=', 'item.id')
            ->where('feed_id', '=', $feed_id)
            ->where('watch.user_id', '=', $userid)
            ->order_by('pub_date', 'desc')
            ->execute();
        return $query->as_array();
    }

    // 全ての未読itemをソートして取得
    public static function get_all_unread_itemlist($userid){
        $query = \DB::select('item.id', 'title', 'link', 'watched', 'item.pub_date', 'feed_id')
            ->from('watch')
            ->join(TABLE_ITEM)->on('watch.item_id', '=', 'item.id')
            ->where('watched', '=', false)
            ->where('user_id', '=', $userid)
            ->order_by('item.pub_date')
            ->execute();

        $res = array();
        foreach($query->as_array() as &$item){
            // linkの情報をマイリストの連続再生URLに変更
            $item['link'] = Model_Url::gen_continuous_playback_url(
                                Model_Rss::pick_mylist_id(
                                    Model_Feedtbl::get_url_from_id($item['feed_id'])
                                ),
                                $item['link']
                            );
            array_push($res, $item);
        }

        return $res;
    }

    // idのpubDateを取得
    public static function get_pubDate($id){
        $query = \DB::select('pub_date')->where('id', '=', $id)
                                        ->execute();
        return $query->as_array()[0]['pub_date'];
    }

    // idのfeed_idを取得
    public static function get_feed_id($id){
        $query = \DB::select('feed_id')->from(TABLE_ITEM)
                                       ->where('id', '=', $id)
                                       ->execute();
        return $query->as_array()[0]['feed_id'];
    }

    // 新規登録
    public static function set($title, $url, $pub_date, $feed_id, $guid){
        $query = \DB::insert(TABLE_ITEM)->set(array(
                                    'title'     => $title,
                                    'link'      => $url,
                                    'pub_date'  => $pub_date,
                                    'feed_id'   => $feed_id,
                                    'guid'      => $guid
              ));
        $num = $query->execute();

        // feedの情報を変更
        //Model_Feedtbl::set_unread($feed_id);

        return $num;
    }

    //  idの既読情報を既読にする
    public static function set_already_read($id){
      $query = \DB::update(TABLE_ITEM)->value('already_read', true)
                                      ->where('id', '=', $id);
      $num = $query->execute();

      if(0 < $num){
        // feedの未読が0ならfeedの既読値を変更
        $feed_id = self::get_feed_id($id);
        $query = \DB::select()->from(TABLE_ITEM)->where('already_read', false)->execute();
        if(count($query->as_array() === 0)){
          Model_Feedtbl::set_already_read($feed_id);
        }
      }else{
        // クエリの実行に失敗
        return 0;
      }

      return $num;
    }

    // 指定のitemよりも古い物を全て見たとする
    public static function setRead($feed_id, $item_id){
      // 指定itemのpubDateを取得する
      $pub_date = \DB::select('pub_date')->from(TABLE_ITEM)->where('id', '=', $item_id)
        ->execute()[0]['pub_date'];
      // 対象となるカラムを取得
      $query = \DB::select('id', 'title', 'pub_date')->from(TABLE_ITEM)
        ->where('feed_id', '=', $feed_id)
        ->where('pub_date', '<=', $pub_date)
        ->where('already_read', '=', false)
        ->execute();

      // 情報の書き換え
      $res = array();
      foreach($query->as_array() as $col){
        \Model_Itemtbl::set_already_read($col['id'], true);
        array_push($res, $col['id']);
      }
      return $res;

    }

    // idを得る
    public static function get_id_from_guid($guid)
    {
        $query = \DB::select('id')->from(TABLE_ITEM)
            ->where('guid', '=', $guid)
            ->execute();
        if(count($query) < 1){
            return null;
        }else{
            return $query[0]['id'];
        }
    }

}
