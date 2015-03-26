<div class="container">
    <div class="login">
        <form class="form-login" action="/login" method="POST">
            <label for="inputNickname" class="sr-only">ニックネーム</label>
            <input type="text" id="inputNickname" class="form-control" name="nickname" placeholder="ニックネーム" required autofocus>
            <p id="wornNickname" class="text-danger"></p>

            <label for="inputPassword" class="sr-only">パスワード</label>
            <input type="password" id="inputPassword" class="form-control" name="passwd" placeholder="パスワード" required>
            <p id="wornPassword" class="text-danger"></p>

            <button id="btn_submit" class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
            <a href="/orerss/signup">
                <button class="btn btn-sm btn-primary btn-block" type="button" name="signup">新規登録</button>
            </a>
        </form>
    </div>
</div>

