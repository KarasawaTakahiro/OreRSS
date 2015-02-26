
<div id="dashboard" class="link-panel">
    <a href="/orerss/dashboard">DASHBOARD</a>
</div>

<dl>
    <dt>新着動画あり</dt>
    <dd>
    <div id="feed-list-unread">
        {foreach $feed_list_unread as $feed}
        <div class="link-panel">
            <a href="/orerss/feed/{$feed.id}">
                <span class="unread feed-title">{$feed.title}</span>
                <span class="badge">{$feed.unread_num}</span>
            </a>
        </div>
        {/foreach}
    </div>
    </dd>
</dl>

<dl>
    <dt>フィードリスト</dt>
    <dd>
    <div id="feed-list-read">
        {foreach $feed_list_read as $feed}
        <div class="link-panel feed-title">
            <a href="/orerss/feed/{$feed.id}">{$feed.title}</a>
        </div>
        <div class="feed-unpull">
            <a class="unpull" href="#" name="{$feed.id}"><span class="glyphicon glyphicon-remove"></span></a>
        </div>
        {/foreach}
    </div>
    </dd>
</dl>
