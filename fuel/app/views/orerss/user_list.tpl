<dl>
    <dt>{$title}</dt>
    <dd>
        <div class="user-list">
            <ul class="list-inline">
                {foreach $userlist as $user}
                <li>
                    <div class="link-panel">
                        <a href="/user/{$user.id}">
                            {Asset::img("user/`$user.thumbnail`", ["alt"=>$user.nickname, "class"=>"thumbnail-user-small", "title"=>$user.nickname])}
                        </a>
                    </div>
                </li>
                {/foreach}
            </ul>
        </div>
    </dd>
</dl>

