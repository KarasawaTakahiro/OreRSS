
                        <div id="dashboard">
                          <p><b><a href="/orerss/dashboard">Dash Board</a></b></p>
                        </div>

                        <dl>
                          <dt>新着動画あり</dt>
                          <dd>
                            <div id="feed-list-unread">
                              {foreach $feed_list_unread as $feed}
                              <p><a class="unread" href="/orerss/feed/{$feed.id}">{$feed.title}</a></p>
                              {/foreach}
                            </div>
                            </dd>
                          </dl>

                          <dl>
                            <dt>フィードリスト</dt>
                            <dd>
                              <div id="feed-list-read">
                                {foreach $feed_list_read as $feed}
                                <p><a href="/orerss/feed/{$feed.id}">{$feed.title}</a></p>
                                {/foreach}
                              </div>
                            </dd>
                          </dl>
