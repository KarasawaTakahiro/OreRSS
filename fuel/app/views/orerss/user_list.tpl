
    <div class="user-list">
        <dl>
            <dt>このマイリストをpullしている他のユーザ</dt>
            <dd>
                <ul class="list-inline">
                    {foreach $userlist as $user}
                    <li>
                        <a class="user-list-item btn btn-lg" href="/orerss/user/{$user.id}">{$user.nickname}</a>
                    </li>
                    {/foreach}
                </ul>
        </dd>
    </div>
