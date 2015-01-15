<div>
    <ul class="list-inline">
        <li class="nickname">
            {$vuser_nickname}
        </li>
    </ul>
</div>

<div>
    <ul class="list-inline">
        <li id="desc-item-title">タイトル</li>
        <li id="desc-item-pullnum">PULL数</li>
        <li id="desc-item-info">インフォ</li>
        <li id="desc-item-pull">PULL</li>
    </ul>
{foreach $mylists as $list}
    <ul class="list-inline">
        <li class="item-mylist"> <a class="unread" href="{$list.url}" target="_brank">{$list.title}</a> </li>
        <li> <span class="badge" title="購読数">??</span> </li>
        <li class="icon-info"> <span class="glyphicon glyphicon-info-sign" title="情報を見る"></span> </li>
        <li class="icon-pull"> <a class="smart-push" href="{$list.url}"><span class="glyphicon glyphicon-plus" title="購読する"></span></a> </li>
    </ul>
{/foreach}
</div>

