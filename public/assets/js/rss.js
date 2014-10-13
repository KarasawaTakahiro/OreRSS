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

