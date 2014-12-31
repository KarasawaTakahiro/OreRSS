<!DOCTYPE html>

<html lang="ja">
    <head>
    </head>
    <body>
        <div class="signin">
            <form class="form-signin">
                <h2 class="form-signin-heading">Please sign in</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
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

