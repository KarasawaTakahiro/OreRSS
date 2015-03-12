<div class="container">
    <div class="signup">
        <form class="form-signin" action="/orerss/signup" method="POST">
            <h2 class="form-signin-heading">ユーザ登録</h2>

            <label for="inputNickname" class="sr-only">ニックネーム</label>
            <input type="text" id="inputNickname" class="form-control" name="nickname" placeholder="ニックネーム" required autofocus>
            <p id="wornNickname" class="text-danger"></p>

            <label for="inputPassword" class="sr-only">パスワード</label>
            <input type="password" id="inputPassword" class="form-control" name="passwd" placeholder="パスワード" required>
            <p id="wornPassword" class="text-danger"></p>

            <label for="inputRePassword" class="sr-only">パスワードの再入力</label>
            <input type="password" id="inputRePassword" class="form-control" name="passwd-re" placeholder="パスワードの再入力" required>
            <p id="wornRePassword" class="text-danger"></p>

            <button id="btn_submit" class="btn btn-lg btn-primary btn-block" type="submit">登録</button>
        </form>
    </div>
</div>
