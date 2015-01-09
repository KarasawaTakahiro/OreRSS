        <div class="signin">
            <form class="form-signin" action="/orerss/login" method="POST">
                <h2 class="form-signin-heading">ログイン</h2>
                <label for="inputNickname" class="sr-only">ニックネーム</label>
                <input type="text" id="inputNickname" class="form-control" name="nickname" placeholder="ニックネーム" required autofocus>

                <label for="inputPassword" class="sr-only">パスワード</label>
                <input type="password" id="inputPassword" class="form-control" name="passwd" placeholder="パスワード" required>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember-me" value="remember-me">ログインを保存
                    </label>
                </div>
                <button id="btn_login" class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
                <a href="/orerss/signup">
                    <button id="btn_login" class="btn btn-sm btn-primary btn-block" type="button" name="signup">新規登録</button>
                </a>
            </form>
        </div>

        {Asset::js('jquery-2.1.1.min.js')}
        {Asset::js('bootstrap.min.js')}

        {Asset::css('bootstrap.css')}
        {Asset::css('bootstrap-theme.min.css')}

        {Asset::css('login.css')}
        {Asset::js('login.js')}


