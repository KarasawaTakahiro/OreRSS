$(function(){
    bind_smartPush();
});

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
 * バインド
 */
var bind_smartPush = function(){
    $(".smart-push").click(function(){
        console.log($(this).attr("href"));
        smartPush($(this).attr("href"));
        return false;                   // ページ遷移無効
    });
};
