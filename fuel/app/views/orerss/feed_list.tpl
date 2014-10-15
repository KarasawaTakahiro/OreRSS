
                    <div class="col-md-4 col-md-pull-8 col-lg-4 col-lg-pull-8" id="left-pain">
                        <div id="dashboard">
                          <p><b><a href="/orerss">Dash Board</a></b></p>
                        </div>
                        <div id="feed-list-unread">
                          {foreach $feed_list_unread as $feed}
                            <p><a class="unread" href="/orerss/feed/{$feed.id}">{$feed.title}</a></p>
                          {/foreach}
                        </div>
                        <div id="feed-list-read">
                          {foreach $feed_list_read as $feed}
                            <p><a href="/orerss/feed/{$feed.id}">{$feed.title}</a></p>
                          {/foreach}
                        </div>
                    </div>
