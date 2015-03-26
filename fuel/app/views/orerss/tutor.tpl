<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h2>メニュー</h2>
            <div id="dashboard" class="link-panel">
                <a href="/orerss/dashboard">DASHBOARD</a>
            </div>
            <ul>
                <li><a href="/orerss/tutor/whatis">何ができるの？</a></li>
                <li>
                    <ul>
                        <li><a href="/orerss/tutor/whatis#whatis">俺RSSとは</a></li>
                        <li><a href="/orerss/tutor/whatis#check">更新チェック</a></li>
                        <li><a href="/orerss/tutor/whatis#record">視聴状況の記録</a></li>
                        <li><a href="/orerss/tutor/whatis#find">動画の発見</a></li>
                    </ul>
                </li>
                <li><a href="/orerss/tutor/rss">更新チェック機能について</a></li>
                <li>
                    <ul>
                        <li><a href="/orerss/tutor/rss#pull">登録編</a></li>
                        <li><a href="/orerss/tutor/rss#list">購読編</a></li>
                        <li><a href="/orerss/tutor/rss#watch">視聴編</a></li>
                        <li><a href="/orerss/tutor/rss#unpull">解除編</a></li>
                    </ul>
                </li>
                <li><a href="/orerss/tutor/find">フィード発見機能について</a></li>
                <li>
                    <ul>
                        <li><a href="/orerss/tutor/find#linkedto">他ユーザとのつながり</a></li>
                        <li><a href="/orerss/tutor/find#randomfeed">ランダムフィード</a></li>
                    </ul>
                 </li>
            </ul>
        </div>
        <div class="col-md-9">
            {include file="./tutor/$page.tpl"}
        </div>
    </div>
</div>
