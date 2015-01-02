
    <div class="user-list">
        <ul class="list-inline">
            {foreach $userlist as $user}
            <li class="list-group-item">
            <a href="/orerss/user/{$user.id}">{$user.nickname}</a>
            </li>
            {/foreach}
        </ul>
    </div>
