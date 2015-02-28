<div>
    <ul class="list-inline">
        <li class="nickname">
        {$vuser_nickname}
        </li>
    </ul>
</div>

<div class="pull_list">
    <div class="list-header">
        <ul class="list-inline">
            <li class="title">タイトル</li>
            <li class="pullnum">PULL数</li>
            <li class="info">インフォ</li>
            <li class="pull">PULL</li>
        </ul>
    </div>
    <div class="list-body">
        {foreach $pulllists as $list}
        <ul class="list-inline">
            <li class="thumb"><div class="thumb"><img src="{$list.thumbnail}" /></div></li>
            <li class="text-info">
                <div class="title link-panel"><a href="{$list.url}" target="_brank">{$list.title}</a></div>
                <div class="description">{$list.description}</div>
            </li>
            <li class="circle-info">
                <div class="info"><span class="glyphicon glyphicon-info-sign"></span></div>
                <div class="pullnum"><span class="badge">{$list.pull_num}</span></div>
            </li>
            <li class="pull link-panel"><a class="smart-push" href="{$list.url}"><span class="glyphicon glyphicon-plus" title="購読する"></span></a> </li>
        </ul>
        {/foreach}
    </div>
</div>
