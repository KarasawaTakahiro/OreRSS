<div class="jumbotron">
    <div class="container">
        <p>マイリストの更新をチェック<br>
        ＋<br>
        新しいマイリストの発見</p>
        <h1>俺RSS</h1>
    </div>
</div>

<div class="container">
    <h2>Update</h2>
    <hr />
    <div class="row">
        {foreach $updates as $item}
        <div class="col-md-4">
            <div class="update-item">
                <div class="item-container">
                    <h3 class="movie-datetime">{$item.datetime}</h3>
                    <div class="movie-name">{$item.moviename}</div>
                    <div class="update-item-thumbnail">
                        <img src="{$item.thumbnail}" />
                    </div>
                    <div class="item-info">
                        <ul class="list-inline">
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <h3>{$item.mylistname}</h3>
            </div>
        </div>
        {/foreach}
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- 左半分 -->
            <h2>Pickup</h2>
            <hr />
            {foreach $pickups as $item}
            <div class="pickup-item">
                <div class="item-container">
                    <div class="pickup-item-thumbnail">
                        <img src="{$item.thumbnail}" />
                    </div>
                    <div class="item-info">
                        <div class="title">{$item.title}</div>
                        <div class="description">{$item.description}</div>
                        <div class="pullusers">
                            <ul class="list-inline">
                                {foreach $item.users as $user}
                                <li>{Asset::img("user/`$user.thumbnail`", ["alt"=>"{$user.nickname}", "class"=>"thumbnail-user-small", "title"=>"{$user.nickname}"])}</li>
                                {/foreach}
                                <li><span class="badge">{$item.pullnum}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            {/foreach}
        </div>

        <div class="col-md-4">
            <!-- 右半分 -->
            <h4>ログイン</h4>
            {include file='orerss/login_form.tpl'}

            <h4>初めての方へ</h4>
            <ul class="list">
                <li>チュートリアル</li>
                <li>チュートリアル</li>
                <li>チュートリアル</li>
            </ul>

            <h4>お知らせ</h4>
            <ul class="list">
                <li>サイトリニューアル</li>
                <li>サイトリニューアル</li>
                <li>サイトリニューアル</li>
            </ul>
        </div>
    </div>
</div>

