
            {*
            items = array(
            array(
            'watched'   => bool,
            'id'        => int,
            'link'      => str,
            'title'     => str,
            'pub_date'  => str
            )
            )
            *}

            <div class="list">
                <div class="list-header">
                    {* ヘッダ *}
                    <ul class="list-inline">
                        <li class="title">動画タイトル</li>
                        <li class="pubDate">投稿日</li>
                        <li class="mark">マーク</li>
                    </ul>
                </div>

                <div class="list-body">
                    {* リスト *}
                    {foreach $items as $item}
                    <ul class="list-inline">
                        <li class="title link-panel">
                        {if $item.watched == false}
                            <a class="unread" id="{$item.id}" href="{$item.link}" target="_blank" onclick="mark_read(this, {$item.id})">{$item.title}</a>
                        {else}
                            <a id="{$item.id}" href="{$item.link}" target="_blank">{$item.title}</a>
                        {/if}
                        </li>
                        <li class="pubDate">{$item.pub_date}</li>
                        <li class="mark link-panel"><a href="#" onclick="autoMark({$item.feed_id}, {$item.id})"><span class="glyphicon glyphicon-{$direction}load" title="ここまで見た！"></a></li>
                    </ul>
                        {/foreach}
                </div>
            </div>
