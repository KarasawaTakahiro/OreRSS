<dl>
    <dt>このフィードをpullしている他のユーザ</dt>
    <dd>
        <div class="user-list">
            <ul class="list-inline">
                {foreach $userlist as $user}
                <li>
                    <a class="user-list-item btn btn-lg" href="/orerss/user/{$user.id}">{$user.nickname}</a>
                </li>
                {/foreach}
            </ul>
        </div>
    </dd>
</dl>
