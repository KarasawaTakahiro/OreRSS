$(function(){
    bind_checkNickname();
    bind_checkPasswd();
    bind_checkRePasswd();
});

var clearFlag = {
    "nickname":false,
    "password":false,
    "repassword":false
};

var setBtnState = function(key, value){
    var isClear = true;

    clearFlag[key] = value;

    for(var i in clearFlag){
        isClear &= clearFlag[i];
    }

    if(isClear){
        $("#btn_signup").removeAttr("disabled"); // 登録ボタンを有効化
    }else{
        $("#btn_signup").attr("disabled", true); // 登録ボタンを無効化
    }

};

var bind_checkNickname = function(){
    var preString = "";                     // 比較対象文字列
    $("#btn_signup").attr("disabled", true); // 登録ボタンを無効化
    $("#inputNickname").keyup(function(){   // すべてのキー操作にバインド
        var string = $(this).val();         // テキストボックスの値取得
        if(string != preString){            // 文字列比較
            setBtnState("nickname", checkNickname());   // 違ったらチェック関数呼び出し
            preString = string;             // 文字列入れ替え
        }
    });
};

var bind_checkPasswd = function(){
    var preString = "";                     // 比較対象文字列
    $("#inputPassword").keyup(function(){   // すべてのキー操作にバインド
        var string = $(this).val();         // テキストボックスの値取得
        if(string != preString){            // 文字列比較
            if(checkPasswd()){              // 違ったら呼び出し
                $("#btn_signup").removeAttr("disabled"); // 登録ボタンを有効化
            }else{
                $("#btn_signup").attr("disabled", true); // 登録ボタンを無効化
            }
            preString = string;             // 文字列入れ替え
        }
    });
};

var checkNickname = function(){
    var obj = $("#inputNickname");
    var len = obj.val().length;
    if(len < 2){                            // 文字数不足
        wornNickname("2文字以上で決めてください");
        return false;
    }else if(10 < len){                     // 文字数超過
        wornNickname("10文字以内で決めてください");
        return false;
    }else{                                  // 有効範囲内
        wornNickname("");
        return true;
    }
};

var checkPasswd = function(){
    var obj = $("#inputPassword");          // テキストボックス
    var len = obj.val().length;             // 文字列長
    var regex = /^[a-zA-Z0-9]+$/;           // 正規表現 半角英数字

    // 文字チェック
    if(obj.val().match(regex) == null){
        console.log("半角英数字のみが使えます");
        return false;
    }

    // 文字数チェック
    if(len < 6){                            // 文字数不足
        wornPassword("6文字以上で決めてください");
        return false;
    }else if(12 < len){                     // 文字数超過
        wornPassword("12文字以内で決めてください");
        return false;
    }else{
        wornPassword("");
        return true;
    }

};

var checkRePasswd = function(){
    // パスワードの同一性チェック
    if($("#inputPassword").val() != $("#inputRePassword").val()){
        wornRePassword("パスワードが合致していません");
        return false;
    }else{
        wornRePassword("");
        return true;
    }

    return true;
};

var wornNickname = function(wornString){
    $("#wornNickname").empty().append(wornString);
};

var wornPassword = function(wornString){
    $("#wornPassword").empty().append(wornString);
};

var wornRePassword = function(wornString){
    $("#wornRePassword").empty().append(wornString);
};

