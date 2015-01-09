
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
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <p id="information" class="navbar-text"></p>
                        <form class="navbar-form navbar-right" id="registNewFeed" action="#" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="new-feed-url">
                            </div>
                            <input type="submit" class="btn btn-default" name="feed_url" value="Append" />
                        </form>
                        <button type="button" id ="btn-refresh" class="btn btn-default navbar-btn navbar-right"><span class="glyphicon glyphicon-refresh"></span></button>
                    </div><!-- /.navbar-collapse -->

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

        <!-- Latest compiled and minified CSS -->
        {Asset::css('bootstrap.min.css')}
        <!-- Optional theme -->
        {Asset::css('bootstrap-theme.min.css')}
        <!-- jQuery -->
        {Asset::js('jquery-2.1.1.min.js')}
        <!-- Latest compiled and minified JavaScript -->
        {Asset::js('bootstrap.min.js')}
        {$assets}
    </body>
</html>

