$(function(){
    bind_checkNickname();
    bind_checkPasswd();
});

var bind_checkNickname = function(){
    var preString = "";                     // 比較対象文字列
    $("#inputNickname").keyup(function(){   // すべてのキー操作にバインド
        var string = $(this).val();         // テキストボックスの値取得
        if(string != preString){            // 文字列比較
            checkNickname();                // 違ったら呼び出し
            preString = string;             // 文字列入れ替え
        }
    });
};

var bind_checkPasswd = function(){
};

var checkNickname = function(){
    console.log("call");
};

var checkPasswd = function(){
};

