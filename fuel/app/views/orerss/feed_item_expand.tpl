<div class="list-item">
    <div class="thumb"><img src="{$feed.thumbnail}" /></div>
    <div class="text-info">
        <div class="title link-panel"><a href="{$feed.url}" target="_brank">{$feed.title}</a></div>
        <div class="description">{$feed.description}</div>
        <div class="pullusers">
            {foreach $feed.users as $user}
            <div class="link-panel">
                <a href="/user/{$user.id}">
                    {Asset::img("user/`$user.thumbnail`", ["alt"=>$user.nickname, "class"=>"thumbnail-user-small", "title"=>$user.nickname])}
                </a>
            </div>
            {/foreach}
        </div>
    </div>
    <div class="circle-info">
        <div class="pull link-panel"><a class="smart-push" href="{$feed.url}"><span class="glyphicon glyphicon-plus" title="購読する"></span></a></div>
        <div class="info"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></div>
        <div class="pullnum"><span class="badge">{$feed.pull_num}</span></div>
    </div>
    <div class="clear-left"></div>
</div>
