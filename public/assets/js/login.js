$(function(){
    signin();
    login();
});

/*
 * 新規登録
 */
var signin = function(){
    $("#btn_signup").click(function (){
        $("form").attr("action", "/orerss/signup");
    });
};

/*
 * ログイン
 */
var login = function(){
    $("#btn_login").click(function (){
        $("form").attr("action", "/orerss/login");
    });
};
