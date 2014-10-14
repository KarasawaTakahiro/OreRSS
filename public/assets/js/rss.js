
$(function(){
  console.log("listener");

  registNewFeed();

});


// 既読をつける
function mark_read(obj, item_id){
  $.ajax({
    url: '/orerss/markRead/'+item_id,
    async: true,
    method: 'POST',
  });
  $(obj).css('fontWeight', 'normal');
}

function autoMark(feed_id, item_id){
  console.log('autoMark');
  $.ajax({
    url: '/orerss/autoreadRead/'+feed_id+'/'+item_id,
    async: true,
    method: 'POST',
    dataType: 'json',
    success: function(list){
      for(var i=0; i<list.length; i++){
        $("#"+list[i]).css('fontWeight', 'normal');
      }
    },
  });

}

var registNewFeed = function(){
  $("#registNewFeed").submit(function(){
      var newFeedUrl = $(this).find("input[id=new-feed-url]").val();

      if(0 < newFeedUrl.length){
        $.ajax({
          url: '/orerss/registNewFeed/',
          async: true,
          type: 'POST',
          data: {'url':newFeedUrl},
          dataType: 'json',
          success: function(data){
            if(data !== null){
              $("#feed-list-unread").append('<p><a class="unread" href="/orerss/feed/' + data.id + '" >' + data.title[0] + '</a></p>');
              }
          },
        });  // ajax
      }else{
        console.log("else");
      }
      return false;
  });
};

