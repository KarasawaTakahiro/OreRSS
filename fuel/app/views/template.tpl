<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <title>俺RSS</title>
    </head>

    <body>
        <!-- header -->
        <header>
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- スマホサイズで表示される -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        {if $nickname != null}
                        <a class="navbar-brand" href="/orerss">俺RSS => {$nickname}RSS</a>
                        {else}
                        <a class="navbar-brand" href="/orerss">俺RSS</a>
                        {/if}
                    </div>

                    <!-- グローバルナビの中身 -->
                    {if $nickname != null}
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <p id="information" class="navbar-text"></p>
                        <a href="/orerss/logout">
                            <button type="button" id ="btn-logout" class="btn btn-default navbar-btn navbar-right" title="ログアウト">
                                <p class="nav-btn-icon"><span class="glyphicon glyphicon-log-out"></span></p>
                                <p class="nav-btn-text">ログアウト</p>
                            </button>
                        </a>
                        <form class="navbar-form navbar-right" id="registNewFeed" action="#" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="new-feed-url" title="マイリストURLを入力" placeholder="マイリストURLを入力">
                            </div>
                            <input type="submit" class="btn btn-default" name="feed_url" value="PULL" title="追加"/>
                        </form>
                        <button type="button" id ="btn-refresh" class="btn btn-default navbar-btn navbar-right" title="更新">
                            <p class="nav-btn-icon"><span class="glyphicon glyphicon-refresh"></span></p>
                            <p class="nav-btn-text">更新</p>
                        </button>
                    </div><!-- /.navbar-collapse -->
                    {/if}

                </div><!-- /.container-fluid -->
            </nav>
        </header>

        <!-- contents -->
        <div id="contents">
            {$contents}
        </div>

        <!-- footer -->
        <footer>
        </footer>

        {foreach $js as $i}
        {Asset::js($i)}
        {/foreach}

        {foreach $css as $i}
        {Asset::css($i)}
        {/foreach}

    </body>
</html>

