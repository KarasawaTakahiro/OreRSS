<!DOCTYPE html>

<html lang="ja">
    <head>
    </head>
    <body>
        <div class="signin">
            <form class="form-signin" action="/orerss/login" method="POST">
                <h2 class="form-signin-heading">ログインしてください</h2>
                <label for="inputNickname" class="sr-only">ニックネーム</label>
                <input type="text" id="inputNickname" class="form-control" placeholder="ニックネーム" required autofocus>
                <label for="inputPassword" class="sr-only">パスワード</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="パスワード" required>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me">ログインを保存
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>
        </div>

        {Asset::js('jquery-2.1.1.min.js')}
        {Asset::js('bootstrap.min.js')}

        {Asset::css('bootstrap.css')}
        {Asset::css('bootstrap-theme.min.css')}

        {Asset::css('login.css')}

    </body>
</html>

