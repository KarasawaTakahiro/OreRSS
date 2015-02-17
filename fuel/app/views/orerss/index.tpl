<div class="jumbotron">
    <p>マイリストの更新をチェック<br>
    ＋<br>
    新しいマイリストの発見</p>
    <h1>俺RSS</h1>
</div>

<div class="container">
    <h2>Update</h2>
    <div class="row">
        {foreach $updates as $item}
        <div class="col-md-4">
            <h3>{$item.mylistname}</h3>
            <img class="thumbnail-mylist-large" src="{$item.thumbnail}" />
            <div>{$item.moviename}</div>
            <p>{$item.datetime}</p>
        </div>
        {/foreach}
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- 左半分 -->
            <h2>Pickup</h2>
            {foreach $pickups as $item}
                <div>
                    <img class="thumbnail-mylist-middle" src="{$item.thumbnail}" />
                    <p>{$item.title}</p>
                    <p>{$item.description}</p>
                    <ul class="list-inline">
                        {foreach $item.users as $user}
                        <li><img class="thumbnail-user-small" src="{$user.thumbnail}" alt="{$user.name}" title="{$user.name}" /></li>
                        {/foreach}
                        <li><span class="badge">{$item.pullnum}</span></li>
                    </ul>
                </div>
            {/foreach}
        </div>
        <div class="col-md-4">
            <!-- 右半分 -->
            <h4>ログイン</h4>
            {include file='orerss/login_form.tpl'}

            <h4>初めての方へ</h4>
            <ul>
                <li>チュートリアル</li>
                <li>チュートリアル</li>
                <li>チュートリアル</li>
            </ul>

            <h4>お知らせ</h4>
            <ul>
                <li>サイトリニューアル</li>
                <li>サイトリニューアル</li>
                <li>サイトリニューアル</li>
            </ul>
        </div>
    </div>

</div>
