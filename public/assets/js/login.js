$(function(){
    bind_checkNickname();
    bind_checkPasswd();
});

/*
 * エラー状態を管理
 */
var clearFlag = {
    "nickname":false,
    "password":false
};

var wornNicknameLess = function(){
    wornNickname("ニックネームは2文字以上です");
};

var wornNicknameMore = function (){
    wornNickname("ニックネームは10文字以下です");
};

var wornPasswordLess = function(){
    wornPassword("パスワードは6文字以上です");
};

var wornPasswordMore = function(){
    wornPassword("パスワードは12文字以下です");
};

