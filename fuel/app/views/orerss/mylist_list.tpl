<div>
    <ul class="list-inline">
        <li class="nickname">
            {$vuser_nickname}
        </li>
    </ul>
</div>

<div>
{foreach $mylists as $list}
    <ul class="list-inline">
        <li class="item-mylist"> <a class="unread" href="{$list.url}">{$list.title}</a> </li>
        <li> <span class="badge" title="購読数">??</span> </li>
        <li class="icon-info"> <span class="glyphicon glyphicon-info-sign" title="情報を見る"></span> </li>
        <li class="icon-pull"> <span class="glyphicon glyphicon-plus" title="購読する"></span> </li>
    </ul>
{/foreach}
</div>

