
$(function(){

  registNewFeed();
  console.log("listener");

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
    alert('registNewFeed');
    var newFeedUrl = $(this).find("input[id=new-feed-url]").val();
    alert(newFeedUrl);

    if(0 < newFeedUrl.length){
      $ajax({
        url: '/orerss/registNewFeed/'+newFeedUrl,
        async: true,
        type: 'POST',
        dataType: 'json',
        success: function(json){
          if(json !== NULL){
            var data = $.parseJSON(json);
            $("#feed-list-unread").append('<p><a class="unread" href="/orerss/feed' + data.id + '" >' + data.name + '</a></p>');
          }
        },
      });
    }
    return false;
  });
};

