<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h2>メニュー</h2>
            <div id="dashboard" class="link-panel">
                <a href="/dashboard">DASHBOARD</a>
            </div>
            <ul>
                <li><a href="/tutor/whatis">何ができるの？</a></li>
                <li>
                    <ul>
                        <li><a href="/tutor/whatis#whatis">俺RSSとは</a></li>
                        <li><a href="/tutor/whatis#check">更新チェック</a></li>
                        <li><a href="/tutor/whatis#record">視聴状況の記録</a></li>
                        <li><a href="/tutor/whatis#find">動画の発見</a></li>
                    </ul>
                </li>
                <li><a href="/tutor/rss">更新チェック機能について</a></li>
                <li>
                    <ul>
                        <li><a href="/tutor/rss#pull">登録編</a></li>
                        <li><a href="/tutor/rss#list">購読編</a></li>
                        <li><a href="/tutor/rss#watch">視聴編</a></li>
                        <li><a href="/tutor/rss#unpull">解除編</a></li>
                    </ul>
                </li>
                <li><a href="/tutor/find">フィード発見機能について</a></li>
                <li>
                    <ul>
                        <li><a href="/tutor/find#linkedto">他ユーザとのつながり</a></li>
                        <li><a href="/tutor/find#randomfeed">ランダムフィード</a></li>
                    </ul>
                 </li>
            </ul>
        </div>
        <div class="col-md-9">
            {include file="./tutor/$page.tpl"}
        </div>
    </div>
</div>
