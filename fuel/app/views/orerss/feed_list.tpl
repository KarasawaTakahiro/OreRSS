
<div id="dashboard">
    <p><a href="/orerss/dashboard"><b>Dash Board</b></a></p>
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
