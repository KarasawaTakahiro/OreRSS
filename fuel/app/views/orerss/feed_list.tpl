
                    <div class="col-md-4 col-md-pull-8 col-lg-4 col-lg-pull-8" style="background-color: #999999;">
                        <p><a href="#">Dash Board</a></p>
                        <div id="feed-list-unread">
                          {foreach $feed_list_unread as $feed}
                            <p><b><a href="/orerss/feed/{$feed.id}">{$feed.title}</a></b></p>
                          {/foreach}
                        </div>
                        <hr>
                        <div id="feed-list-read">
                          {foreach $feed_list_read as $feed}
                            <p><a href="/orerss/feed/{$feed.id}">{$feed.title}</a></p>
                          {/foreach}
                        </div>
                    </div>
