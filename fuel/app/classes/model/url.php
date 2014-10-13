<?php

define('PAGE_FEED', 'orerss/feed');


class Model_Url extends \Model
{
    public static function gen_continuous_playback_url($mylist_id, $movie_url){ 
        return $movie_url."?playlist_type=mylist_playlist&group_id=$mylist_id&mylist_sort=0"; 
    }

    public static function gen_feed_page_url($feed_id){
        return PAGE_FEED.'/'.$feed_id;
    }

}

