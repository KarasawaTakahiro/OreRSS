
// ページ読み込み時に実行
$(function(){
  // 新規登録用ボタンのリスナを登録
  registNewFeed();
  // 更新用ボタンのリスナを登録
  feedRefresh();
  // 購読解除用ボタンのリスナ登録
  unpull();
});

function info(text){
}


// 既読をつける
function mark_read(obj, item_id){
  // 対象を既読にする
  $.ajax({
    url: '/orerss/markRead/'+item_id,
    async: true,
    method: 'POST',
  });

  $(obj).css('fontWeight', 'normal'); // フォントの変更
}

// automark
function autoMark(feed_id, item_id){
  //console.log('autoMark');
  //
  $.ajax({
    url: '/orerss/automarkRead/'+feed_id+'/'+item_id,
    async: true,
    method: 'POST',
    dataType: 'json',
    success: function(list){
      for(var i=0; i<list.length; i++){
        $("#"+list[i]).css('fontWeight', 'normal');   // フォントを変更
      }
    },
  });

}

// feed新規登録
var registNewFeed = function(){
  $("#registNewFeed").submit(function(){    // submitにバインド
      var tbox = $(this).find("input[id=new-feed-url]");
      var newFeedUrl = tbox.val();    // テキストボックスの値を取得

      if(0 < newFeedUrl.length){
        $.ajax({
          url: '/orerss/registNewFeed/',
          async: true,
          type: 'POST',
          data: {'url':newFeedUrl},   // feedのURLを引数にする
          dataType: 'json',
          success: function(data){
            // リスト一覧に追加
            if(data !== null){
              $("#feed-list-unread").append('<p><a class="unread" href="/orerss/feed/' + data.id + '" >' + data.title[0] + '</a></p>');
              tbox.val("");
            }
          },
        });  // ajax
      }

      return false;   // submitの動作を無効化
  });
};

var feedRefresh = function(){
  $("#btn-refresh").click( function(){
    var btn = $("#btn-refresh");    // ボタンオブジェクトを取得
    var icon = btn.children();      // ボタンの中身を退避
    var load_gif = '<img src="/assets/img/feed_refresh.gif" />';   // 更新中の中身

    btn.attr("disabled", true);   // ボタンを無効化
    btn.empty();                  // ボタンの中身を消す
    btn.append(load_gif);         // 中身を差し替え

    // ajaxでfeedのデータを取得
    $.ajax({
      url: '/orerss/updateFeed',
      async: true,
      type: 'POST',
      dataType: 'json',
    }).done(function(data){
      console.log("success: " + data.update_num);
      location.reload();
    }).fail(function(){
      btn.empty();                  // ボタンの中身を消す
      btn.append(icon);             // 中身を差し替え
    }).always(function(){
      $("#btn-refresh").attr("disabled", false);
      console.log("complete");
    });   // ajax


  });
};

/*
 * 購読解除ボタンのバインド
 */
var unpull = function(){
    $("a.unpull").click(function(){         // クリックイベントにバインド
        var feedid = $(this).attr("name");  // フィードID取得
        var parent = $(this).parent();      // 一覧から削除のために行全体を取得

        // ajaxでPOST
        $.ajax({
            url: '/orerss/unpullFeed',
            async: true,
            method: 'POST',
            data: {fid:feedid}
        }).done(function(){                 // 成功
            parent.remove();                // 一覧から削除
        }).fail(function(){                 // 失敗
        });

        return false;                       // ジャンプを無効化
    });

};

