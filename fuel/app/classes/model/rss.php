<?php
include_once('feedtbl.php');
include_once('itemtbl.php');

define('RSSURL_FRONT', 'http://www.nicovideo.jp/mylist/');
define('RSSURL_BACK', '?rss=2.0');
define('FEED_TITLE_PREFIX', 'マイリスト ');                 // フィードのタイトルの接頭語
define('FEED_TITLE_SUFFIX', '-ニコニコ動画');                 // フィードのタイトルの接尾語

class Model_Rss extends \Model
{
    /*
        マイリストのURLをもらって、feedとitemを登録する
    */
    public function regist_new_feed($userId, $url){
        $mylist_url = self::pickup_url($url);                       // マイリストURLを生成

        // feedの新規登録
        if(self::is_registered_feed($mylist_url) == false){
            // 未登録の時
            $feed = self::get_feed(self::convert_url($mylist_url));     // 問い合わせ
            $feed_channel = self::parse($feed);                         // channelを抽出
            $feed_title = self::parse_title($feed_channel->title);      // マイリストのタイトルを抽出
            \Model_Feedtbl::set($mylist_url, $feed_title);          // feed登録
            $id = \Model_Feedtbl::get_id_from_url($mylist_url);     // feedのidを取得
            if($id == null) return null;                            // DBから参照失敗

            self::pull($id, $userId);                               // 購読
            Model_Feedtbl::set_description($id, $feed_channel->description);    // 説明文を登録する
            foreach($feed_channel->item as $item){
                // itemの新規登録
                $itemId = self::regist_item($id, $item->title, $item->link, $item->pubDate, $item->guid);
                // 視聴情報の登録
                Model_Watch::add($itemId, $userId);
            }
            return array('title' => $feed_title, 'id' => $id);
        }else{      // マイリストがシステムに登録済み
            $id = \Model_Feedtbl::get_id_from_url($mylist_url);     // feedのidを取得
            if($id == null) return null;                            // DBから参照失敗
            if(Model_Pull::is_pull($userId, $id))return  array();   // 購読済みかどうか

            $feed_channel = \Model_Rss::get_localdata_channel_format($id);  // ローカルのデータを取得
            if($feed_channel == null) return null;                  // 参照失敗
            self::pull($id, $userId);                               // 購読
            foreach($feed_channel['item'] as $item){                // 動画情報を登録
                Model_Watch::add($item['id'], $userId);             // 視聴情報の登録
            }
            return array('title' => array($feed_channel['title']), 'id' => $id);
        }

    }

    /*
        全てのfeedを更新する
        新しいitemの総数を返す
    */
    public function update(){
        $num = 0;   // 新規総数
        // DBから全てのフィードのidを取得
        foreach(\Model_Feedtbl::get_all_feed_ids() as $feed_id){
            $num += self::update_feed($feed_id);     // フィードを更新
        }

        return $num;
    }

    /*
        1つのfeedを更新する
        新しいitemの総数を返す
    */
    private function update_feed($feed_id){
        $update_num = 0;    // 新規総数

        // idからフィードのURLを取得
        $url = \Model_Feedtbl::get_url_from_id($feed_id);
        if(! $url){
            return 0;
        }

        $furl = self::convert_url($url);        // RSSフィードURLに変換
        $res = self::get_feed($furl);           // フィードの全itemを取得
        if($res == null) return 0;              // フィードが404
        $channel = self::parse($res);           // パース
        Model_Feedtbl::set_description($feed_id, $channel->description);    // 動画説明文更新
        $items = self::get_items($channel);     // フィードの取得が成功

        foreach($items as $item){
            if(self::is_registered_item_at($url, $item->guid)){
                // 登録済み
                continue;
            }else{
                // 未登録により新規登録
                $itemid = self::regist_item($feed_id, $item->title, $item->link, $item->pubDate, $item->guid);
                if($itemid != null){            // 更新成功
                    $update_num += 1;           // 更新数++
                    self::add_update_watch($itemid);    // 視聴情報の新規登録
                }
            }
        }
        return $update_num;
    }

    // feedの更新用のデータを取得
    public static function get_data_for_update(){
        $data = array();
        foreach(Model_Feedtbl::get_all_feed_ids() as $id){
            $column = Model_Feedtbl::get_all_column_from_id($id);
            array_push($data, array('id' => $column[0]['id'], 'title' => $column[0]['title']));
        }
        return $data;
    }

    /*
        フィードがローカルに登録済みか
    */
    public static function is_registered_feed($rss_url){
        $id = \Model_Feedtbl::get_id_from_url($rss_url);

        if($id == null){
            return false;
        }else{
            return true;
        }
    }

    /*
        あるフィードのitemが登録済み

        $item_guidか$item_urlのどちらか以上をを渡す
    */
    public static function is_registered_item_at($rss_url, $item_guid=null, $item_url=null){
        $query = \DB::select(TABLE_ITEM.'.id')->from(TABLE_ITEM)->join(TABLE_FEED)->on(TABLE_ITEM.'.feed_id', '=', TABLE_FEED.'.id')->where('url', '=', $rss_url);
        if($item_guid){
            $query->where('guid', '=', $item_guid);
        }else if($item_url){
            $query->where('link', '=', $item_url);
        }else{
            return false;
        }

        if(0 < count($query->execute()->as_array())){
            return true;
        }else{
            return false;
        }
    }

    /*
        マイリストのURLからRSSのURLに変換する
    */
    public static function convert_url($url){
        return self::pickup_url($url).RSSURL_BACK;       // RSSフィードのURLに変換
    }

    /*
     * マイリストのURLを抽出する
     */
    public static function pickup_url($url){
        // URLからマイリスIDを抜き取る
        preg_match('/mylist\/\d+/', $url, $matches);
        preg_match('/\d+/', $matches[0], $m);
        $id = $m[0];
        return RSSURL_FRONT.$id;                        // マイリストのURLに変換
    }

    /*
      マイリストのURLからマイリストIDを取得する
    */
    public static function pick_mylist_id($url){
        preg_match('/mylist\/\d+/', $url, $matches);
        preg_match('/\d+/', $matches[0], $m);
        return $m[0];
    }

    /*
      日付をmysql用に変換
    */
    private function convert_datetime($datetime){
        return strftime('%Y%m%d%H%M%S', strtotime((string)$datetime));
    }

    /*
        RSS URLを元にfeedのデータを取得する
        データの取得に失敗した場合はnullを返す
    */
    private function get_feed($rssurl){
        $context = stream_context_create(array(
            'http'=>array(
                'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36',
                'ignore_errors' => true,
                )
            )
        );
        $content = file_get_contents($rssurl, false, $context);

        $pos = strpos($http_response_header[0], '404');
        if($pos !== false){     // 404
            return null;
        }else{                  // 404じゃない時
            return $content;
        }
    }

    /*
        feedをパースして、channel内を返す
    */
    private function parse($feed_data){
        return simplexml_load_string($feed_data)->channel;
    }

    /*
        
    */
    private function get_items($channel){
        $items = array();
        foreach($channel->item as $item){
            array_push($items, $item);
        }
        array_reverse($items);
        return $items;
    }

    /*
        itemを登録する

        登録に成功したらidを返す
    */
    private function regist_item($feed_id, $title, $link, $pubDate, $guid){
        // itemを新規登録
        if(\Model_Itemtbl::set($title, $link, self::convert_datetime($pubDate), $feed_id, $guid)){
            $itemid = Model_Itemtbl::get_id_from_guid($guid);
            Model_Latest::set($itemid);         // 新規テーブルに登録

            return $itemid;     // idを返す
        }else{
            return null;
        }
    }

    /*
     * DBの情報をRSS2.0のchannel風にして返す
     */
    public static function get_localdata_channel_format($feedId)
    {
        $res = Model_Feedtbl::get_all_column_from_id($feedId)[0];
        $res['item'] = Model_itemtbl::get_itemlist_column_from_feed_id($feedId);
        return $res;
    }

    /*
     * feedを購読する
     */
    public static function pull($feedid, $userid)
    {
        if(Model_Pull::add($feedid, $userid)){                          // 購読
            Model_Feedtbl::inc_pull_num($feedid);                       // 購読数を増やす
        }
    }

    /*
     * 新規に登録されたitemに対してpullしているユーザのwatchを追加
     */
    public static function add_update_watch($itemid)
    {
        // itemidが所属するfeedを購読している全ユーザを得る
        $users = DB::select('user_id')->from('pull')
            ->join('item')->on('pull.feed_id', '=', 'item.feed_id')
            ->where('item.id', '=', $itemid)
            ->execute()
            ->as_array();

        // 取得したユーザに対してitemidのwatchを追加
        foreach($users as $user){
            Model_Watch::add($itemid, $user['user_id']);
        }
    }

    /*
     * フィードのタイトルからマイリストのタイトル部分を抽出する
     */
    private static function parse_title($title)
    {
        $rear = mb_substr($title, mb_strlen(FEED_TITLE_PREFIX));        // 接頭語を削除
        $len = mb_strlen($rear);
        $mylisttitle =  mb_substr($rear, 0, $len-mb_strlen(FEED_TITLE_SUFFIX)); // 接尾語を削除

        return $mylisttitle;
    }

}

