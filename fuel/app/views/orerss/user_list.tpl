<dl>
    <dt>このフィードをPULLしている他のユーザ</dt>
    <dd>
        <div class="user-list">
            <ul class="list-inline">
                {foreach $userlist as $user}
                <li>
                    <div class="link-panel">
                        <a href="/orerss/user/{$user.id}">
                            <img class="thumbnail-user-small" src="{$user.thumbnail}" alt="{$user.nickname}" title="{$user.nickname}" />
                        </a>
                    </div>
                </li>
                {/foreach}
            </ul>
        </div>
    </dd>
</dl>
