<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-push-4 col-lg-8 col-lg-push-4">
            <!-- right pain -->
            <h2>動画リスト</h2>
            {include file='./item_list.tpl' items=$items}
        </div>
        <!-- left pain -->
        <div class="col-md-4 col-md-pull-8 col-lg-4 col-lg-pull-8" id="left-pain">
            <h2>メニュー</h2>
            {include file='./feed_list.tpl' feed_list_unread=$feed_list.unread feed_list_read=$feed_list.read}
            {include file='./user_list.tpl' userlist=$userlist title='このフィードをPULLしているユーザ'}
        </div>
    </div>
</div>

