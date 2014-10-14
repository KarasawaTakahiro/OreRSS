<?php

define('PAGE_FEED', 'orerss/feed');


class Model_Url extends \Model
{
    public static function gen_continuous_playback_url($mylist_id, $movie_url){ 
        return $movie_url."?playlist_type=mylist_playlist&group_id=$mylist_id&mylist_sort=0"; 
    }

    public static function convert_continuous_playback_url($dataset){
        foreach($dataset as &$item){
            $item['link'] = Model_Url::gen_continuous_playback_url(
                                Model_Rss::pick_mylist_id(
                                    Model_Feedtbl::get_url_from_id($item['feed_id'])
                                ),
                                $item['link']
                            );
        }
        return $dataset;
    }

    public static function gen_feed_page_url($feed_id){
        return PAGE_FEED.'/'.$feed_id;
    }

}

