<div class="container">
    <div class="row">

        <!-- left pain -->
        <div class="col-md-4 col-lg-4 " id="left-pain">
            <h2>メニュー</h2>
            {include file='./feed_list.tpl' feed_list_unread=$feed_list.unread feed_list_read=$feed_list.read}
            {include file='./user_list.tpl' userlist=$userlist title='あなたがPULLしているフィードをPULLしているユーザ'}
        </div>
        <!-- right pain -->
        <div class="col-md-8 col-lg-8">
            <h2>動画リスト</h2>
            {include file='./item_list.tpl' items=$items}
            <h2>ランダムフィード</h2>
            {include file='./randomfeed.tpl' items=$randomfeed}
        </div>
    </div>
</div>
