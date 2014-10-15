
// ページ読み込み時に実行
$(function(){
  // 新規登録用ボタンのリスナを登録
  registNewFeed();
  // 更新用ボタンのリスナを登録
  feedRefresh();

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
      var newFeedUrl = $(this).find("input[id=new-feed-url]").val();    // テキストボックスの値を取得

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
            }
          },
        });  // ajax
      }

      return false;   // submitの動作を無効化
  });
};

var feedRefresh = function(){
  $("#btn-refresh").click( function(){
      var feedUpdate = function(feed_id, feed_title){
        info(feed_title);   // infoの更新
        $.ajax({
          url: '/orerss/getFeedData',
          async: true,
          type: 'POST',
          data: {'feed_id':feed_id},
          dataType: 'json',
        }).done(function (data){

        }).fail(function (){
        });
      };

      // ajaxでfeedのデータを取得
      var getFeedDatas = function(){
        $.ajax({
          url: '/orerss/getFeedData',
          async: false,
          type: 'POST',
          dataType: 'json',
        }).done(function(data){
          console.log("success");
          feedUpdate();
        }).fail(function(){
          return null;
        });   // ajax
      };

      console.log(feedDatas);

      /*
      $.ajax({
        url: '/orerss/updateFeed',
        async: true,
        type: 'POST',
        data: {'feed_id':feed_id},   // feedのURLを引数にする
        dataType: 'json',
        success: function(data){
        }
      });
      */
    }
  );
};

