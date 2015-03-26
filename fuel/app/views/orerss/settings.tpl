<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h2>メニュー</h2>
            <div id="dashboard" class="link-panel">
                <a href="/orerss/dashboard">DASHBOARD</a>
            </div>

        </div>

        <div class="col-md-9">
            <h2>設定</h2>

            <div class="section">
                <dl id="thumb">
                    <dt>サムネイル</dt>
                    <dd>
                    <div id="thumbnail">
                        <div class="current">
                            {Asset::img("user/`$thumbnail`", ["class"=>"thumbnail-user-normal", "alt"=>"サムネイル"])}
                        </div>
                        <div class="future">
                            <form action="/orerss/settings" method="post" enctype="multipart/form-data">
                                <div class="input-group">
                                    <input class="form-control" name="thumbnail" type="file" placeholder="ファイルを選択" />
                                    <span class="input-group-addon"><input type="submit"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    </dd>
                </dl>
            </div>

        </div>

    </div>
</div>


