<div class="user-info">
    <span>{Asset::img("user/`$vuser.thumbnail`", ["alt"=>"{$vuser.nickname}", "class"=>"thumbnail-user-small"])}</span>
    <span class="nickname">{$vuser.nickname}</span>
</div>

<div class="pull_list">
    <div class="list-header">
        <ul class="list-inline">
            <li class="thumb">最新サムネイル</li>
            <li class="text-info">
                <div class="title">タイトル</div>
                <div class="description">説明文</div>
                <div class="pulluser">PULLユーザ</div>
            </li>
            <li class="circle-info">
                <div class="pull">PULL</div>
                <div class="info">インフォ</div>
                <div class="pullnum">PULL数</div>
            </li>
        </ul>
    </div>

    <div class="list-body">
        {foreach $pulllists as $list}
        <div class="list-item">
            <div class="thumb"><img src="{$list.thumbnail}" /></div>
            <div class="text-info">
                <div class="title link-panel"><a href="{$list.url}" target="_brank">{$list.title}</a></div>
                <div class="description">{$list.description}</div>
                <div class="pullusers">
                    {foreach $list.users as $user}
                    <div class="link-panel">
                        <a href="/orerss/user/{$user.id}">
                            <img class="thumbnail-user-xsmall" src="{$user.thumbnail}" alt="{$user.nickname}" title="{$user.nickname}" />
                        </a>
                    </div>
                    {/foreach}
                </div>
            </div>
            <div class="circle-info">
                <div class="pull link-panel"><a class="smart-push" href="{$list.url}"><span class="glyphicon glyphicon-plus" title="購読する"></span></a> </div>
                <div class="info"><span class="glyphicon glyphicon-info-sign"></span></div>
                <div class="pullnum"><span class="badge">{$list.pull_num}</span></div>
            </div>
            <div class="clear-left"></div>
        </div>
        {/foreach}
    </div>
</div>
