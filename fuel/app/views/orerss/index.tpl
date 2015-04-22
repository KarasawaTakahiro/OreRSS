<div class="jumbotron">
    <div class="container">
        <h1>俺RSS</h1>
        <p>マイリストの更新をチェック<br>
        ＋<br>
        新しいマイリストの発見</p>
    </div>
</div>

<div class="container">
    <h2>Update</h2>
    <hr />
    <div class="row">
        {foreach $updates as $item}
        <div class="col-md-4">
            <div class="update-item">
                <div class="item-container">
                <h3>{$item.mylistname}</h3>
                    <div class="update-item-thumbnail">
                        <img src="{$item.thumbnail}" />
                    </div>
                    <div class="item-info">{$item.moviename}</div>
                    <div class="clear"></div>
                    <h3 class="movie-datetime">{$item.datetime}</h3>
                </div>
            </div>
        </div>
        {/foreach}
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- 左半分 -->
            <h2>Pickup</h2>
            <hr />
            {if $login}
                {include file='./feed_item_expand.tpl' feeds=$pickups}
            {else}
                {include file='./feed_item.tpl' feeds=$pickups}
            {/if}
        </div>

        <div class="col-md-4">
            <!-- 右半分 -->
            {if $nickname == null}
            <h2>ログイン</h2>
            <div class="container">
                {include file='orerss/login_form.tpl'}
            </div>
            {else}
            <h2>ユーザ</h2>
            <div id="user">
                <div class="inline-block">
                    {Asset::img("user/`$userdata.thumbnail`", ['class'=>'thumbnail-user-normal'])}
                </div>
                <div class="inline-block">
                    <div class="font-lg">
                        {$userdata.name}
                    </div>
                    <div id="dashboard" class="link-panel">
                        <a href="/dashboard">Dash Board</a>
                    </div>
                </div>
            </div>
            {/if}

            <h2>初めての方へ</h2>
            <ul class="list">
                <li><a href="/tutor/whatis">何ができるの？</a></li>
                <li><a href="/tutor/rss">更新チェック機能</a></li>
                <li><a href="/tutor/find">フィード発見機能</a></li>
            </ul>

            <h2>お知らせ</h2>
            <ul class="list">
                <li><a href="/announce">お知らせ</a></li>
            </ul>

            <h2>Twitter</h2>
            <div class="twitter">
                {literal}
                <a class="twitter-timeline" href="https://twitter.com/OreRSS" data-widget-id="581717197770240000">@OreRSSさんのツイート</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                {/literal}
            </div>
        </div>
    </div>
</div>

