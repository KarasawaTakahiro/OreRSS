{foreach $feeds as $feed}
<div class="pickup-item">
    <div class="item-container">
        <div class="pickup-item-thumbnail">
            <img src="{$feed.thumbnail}" />
        </div>
        <div class="item-info">
            <div class="title">{$feed.title}</div>
            <div class="description">{$feed.description}</div>
            <div class="pullusers">
                <ul class="list-inline">
                    {foreach $feed.users as $user}
                    <li>{Asset::img("user/`$user.thumbnail`", ["alt"=>"{$user.nickname}", "class"=>"thumbnail-user-small", "title"=>"{$user.nickname}"])}</li>
                    {/foreach}
                    <li><span class="badge">{$feed.pullnum}</span></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
{/foreach}
