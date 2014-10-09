
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
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Brand</a>
                        <p class="navbar-text">a information</p>
                        <a class="navbar-icon" href="#">
                            <button type="submit" class="btn btn-default navbar-btn navbar-right"><span class="glyphicon glyphicon-refresh"></span></button>
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form navbar-right" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Append">
                            </div>
                            <button type="submit" class="btn btn-default">Append</button>
                        </form>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>

        <!-- contents -->
        <div id="contents">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-push-4 col-lg-8 col-lg-push-4" style="background-color: #4432aa;">
                        <!-- right pain -->
                            <div class="row">
                                <div class="col-md-10 col-lg-10" style="background-color: #893234;">
                                    <p>Title</p>
                                </div>
                                <div class="col-md-2 col-lg-2" style="background-color: #893432;">
                                    <p>pubDate</p>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-4 col-md-pull-8 col-lg-4 col-lg-pull-8" style="background-color: #999999;">
                        <!-- left pain -->
                        <p><a href="#">Dash Board</a></p>
                        <p><b>fjieoa;</b></p>
                        <p><b>fjieoa;</b></p>
                        <hr>
                        <p>fjieoa;</p>
                        <p>jfioea;</p>
                    </div>
                </div>
            </div>
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
    </body>
</html>

