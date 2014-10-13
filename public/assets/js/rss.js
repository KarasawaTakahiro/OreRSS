// 既読をつける

function mark_read(obj, item_id){
  $.ajax({
    url: '/orerss/markRead/'+item_id,
    async: true,
    method: 'POST',
  });
  $(obj).css('fontWeight', 'normal');
}
