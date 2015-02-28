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
            <li class="title link-panel"><a class="unread" href="{$list.url}" target="_brank">{$list.title}</a> </li>
            <li class="pullnum"><span class="badge" title="購読数">{$list.pull_num}</span> </li>
            <li class="info"><span class="glyphicon glyphicon-info-sign" title="情報を見る"></span> </li>
            <li class="pull link-panel"><a class="smart-push" href="{$list.url}"><span class="glyphicon glyphicon-plus" title="購読する"></span></a> </li>
            <li><img src="{$list.thumbnail}" /></li>
            <li>{$list.description}</li>
        </ul>
        {/foreach}
    </div>
</div>
