/* OVERRIDE
 * ニックネームの文字数が少なかった時の関数
 */
var wornNicknameLess = function(){ };

/* ORVERRIDE
 * ニックネームの文字数が多かった時の関数
 */
var wornNicknameMore = function(){ };

/* ORVERRIDE
 * パスワードの文字数が少なかった時の関数
 */
var wornPasswordLess = function(){ };

/* OVERRIDE
 * パスワードの文字数が多かった時の関数
 */
var wornNicknameMore = function(){ };

/*
 * イベントのバインド
 */
var bind_checkNickname = function(){
    var preString = "";                     // 比較対象文字列
    $("#btn_submit").attr("disabled", true); // 登録ボタンを無効化
    $("#inputNickname").keyup(function(){   // すべてのキー操作にバインド
        var string = $(this).val();         // テキストボックスの値取得
        if(string != preString){            // 文字列比較
            setBtnState("nickname", checkNickname());   // 違ったらチェック関数呼び出し
            preString = string;             // 文字列入れ替え
        }
    });
};

/*
 * イベントのバインド
 */
var bind_checkPasswd = function(){
    var preString = "";                     // 比較対象文字列
    $("#inputPassword").keyup(function(){   // すべてのキー操作にバインド
        var string = $(this).val();         // テキストボックスの値取得
        if(string != preString){            // 文字列比較
            setBtnState("password", checkPasswd());
            preString = string;             // 文字列入れ替え
        }
    });
};

/*
 * ニックネームの文字列に関してチェックする
 */
var checkNickname = function(){
    var obj = $("#inputNickname");
    var len = obj.val().length;
    if(len < 2){                            // 文字数不足
        wornNicknameLess();
        return false;
    }else if(10 < len){                     // 文字数超過
        wornNicknameMore();
        return false;
    }else{                                  // 有効範囲内
        wornNicknameClear();
        return true;
    }
};

/*
 * パスワードの文字列に関してチェックする
 */
var checkPasswd = function(){
    var obj = $("#inputPassword");          // テキストボックス
    var len = obj.val().length;             // 文字列長
    var regex = /^[a-zA-Z0-9]+$/;           // 正規表現 半角英数字

    // 文字チェック
    if(obj.val().match(regex) == null){
        return false;
    }

    // 文字数チェック
    if(len < 6){                            // 文字数不足
        wornPasswordLess();
        return false;
    }else if(12 < len){                     // 文字数超過
        wornPasswordMore();
        return false;
    }else{
        wornPasswordClear("");
        return true;
    }

};

/*
 * 登録ボタン(#btn_submit)の状態を操作する
 *
 * clearFlagJSONのkeyをvalueに書き換える
 * clearFlagの全要素が真なら真，それ以外は偽とし，
 * 真の時，登録ボタンを有効化
 * 偽の時，登録ボタンを無効化
 */
var setBtnState = function(key, value){
    var isClear = true;

    clearFlag[key] = value;

    for(var i in clearFlag){
        isClear &= clearFlag[i];
    }

    if(isClear){
        $("#btn_submit").removeAttr("disabled"); // 登録ボタンを有効化
    }else{
        $("#btn_submit").attr("disabled", true); // 登録ボタンを無効化
    }

};

/*
 * ニックネームに関する警告文を操作する
 */
var wornNickname = function(wornString){
    $("#wornNickname").empty().append(wornString);
};

/*
 *  ニックネームに関する警告文を削除する
 */
var wornNicknameClear = function(){
    wornNickname("");
};

/*
 * パスワードに関する警告文を操作する
 */
var wornPassword = function(wornString){
    $("#wornPassword").empty().append(wornString);
};

var wornPasswordClear = function(){
    wornPassword("");
};
