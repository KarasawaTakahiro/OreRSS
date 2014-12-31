<?php

class Model_Pull extends \Mode
{
    /*
     * 購読しているフィードのIDを返す
     */
    public static function get_pull_feed($userid)
    {
        $query = \DB::select('feed_id')->from('pull')
            ->where('user_id', '=', $userid)
            ->order_by('modified_at');

        return $query->execute()->as_array();
    }
}

