$(function(){
    bind_smartPush();
    bind_description();
});

var description_default_height = 0;

/*
 * ユーザページのマイリストから購読する
 */
var smartPush = function(mylistUrl){
    $.ajax({
        url:'/orerss/registNewFeed',
        async: true,
        type: 'POST',
        data: {'url':mylistUrl},
        dataType: 'json'
    }).done(function(data){
        // リスト一覧に追加
        if(data !== null){
            $("#feed-list-unread").append('<p><a class="unread" href="/orerss/feed/' + data.id + '" >' + data.title[0] + '</a></p>');
        }
    }).fail(function(data){
    });
};

/*
 * 説明文の範囲をトグル
 */
var toggle_description = function(obj){
    desc = obj.parents(".list-item").find(".description")[0];
    if(description_default_height < desc.scrollHeight && desc.scrollHeight != desc.offsetHeight){
        // 広げる
        $(desc).animate({"height":desc.scrollHeight});
    }else{
        // 元に戻す
        $(desc).animate({"height":description_default_height});
    }
};

/*
 * バインド
 */
var bind_smartPush = function(){
    $(".smart-push").click(function(){
        smartPush($(this).attr("href"));
        return false;                   // ページ遷移無効
    });
};

var bind_description = function(){
    description_default_height = $(".list-item .description").height();
    console.log(description_default_height);
    $(".info button").click(function(){
        toggle_description($(this));
    });
};
