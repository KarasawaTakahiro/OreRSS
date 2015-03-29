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

    {include './feed_item_expand.tpl' feeds=$pulllists}
</div>
