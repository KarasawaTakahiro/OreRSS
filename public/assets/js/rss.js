
// ページ読み込み時に実行
$(function(){
  // 新規登録用ボタンのリスナを登録
  registNewFeed();
  // 更新用ボタンのリスナを登録
  feedRefresh();
  // 購読解除用ボタンのリスナ登録
  unpull();
  //
  smartpull();
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

  $(obj).attr('class', 'read'); // フォントの変更
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
        $("#"+list[i]).attr('class', 'read');   // フォントを変更
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
              $("#feed-list-unread").append('<p><a class="unread" href="/orerss/feed/' + data.id + '" >' + data.title + '</a></p>');
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

        // 削除の確認
        if(confirm("購読を解除しますか？") == false){
            return false;
        }

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
            // フィードページにいたらダッシュボードに移動
            var isfeed = location.href.match(/feed.[0-9]+/);    // フィードページかどうか
            if(isfeed != null){
                var pfeedid = isfeed[0].match(/[0-9]+/)[0];      // フィードIDを取得
                if(parseInt(pfeedid) == parseInt(feedid)){      // 削除したフィードのフィードページにいる
                    window.location.href = "/orerss/dashboard"; // dashboardにジャンプ
                }
            }
        }).fail(function(){                 // 失敗
        });

        return false;                       // ジャンプを無効化
    });

};

/*
 * smart pull
 */
var smartpull = function(){
    $(".smart-pull").submit(function(evt){
        var feedid = $(this).find("input").attr("value");

        $.ajax({
            url: '/orerss/smartpull',
            async: true,
            type: 'POST',
            data: {'feedid' : feedid},
            dataType: 'json',
        }).done(function(data){
            if(Array.isArray(data) == false){       // 配列の時は登録失敗している
                append_feed(data.id, data.title, data.unread_num);
            }
        });

        return false;
    });
};

/*
 * 未視聴リストにフィードを追加する
 */
var append_feed = function(id, title, unread_num){
    var div = $("<div>").addClass("link-panel");
    var a = $("<a>").attr("href", "/orerss/feed/" + id);
    var title = $("<span>").addClass("unread").addClass("feed-title").text(title);
    var num = $("<span>").addClass("badge").text(unread_num);
    a.append(title).append(num).appendTo(div);
    $("#feed-list-unread").append(div);
};

