<dl>
    <dt>このフィードをPULLしている他のユーザ</dt>
    <dd>
        <div class="user-list">
            <ul class="list-inline">
                {foreach $userlist as $user}
                <li>
                    <a class="user-list-item" href="/orerss/user/{$user.id}">
                        <img src="{$user.thumbnail}" alt="{$user.nickname}" title="{$user.nickname}" />
                    </a>
                </li>
                {/foreach}
            </ul>
        </div>
    </dd>
</dl>
