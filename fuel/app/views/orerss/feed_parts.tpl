<div class="row">
  <div class="col-md-8 col-lg-12" id="right-pain">
        <!--
        <ul class="list-inline">
            <li class="item-title">タイトル</li><li class="item-pubDate">更新日</li><li class="item-read">既読</li>
        </ul>
        -->
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
        {foreach $items as $item}
          <ul class="list-inline">
            <li class="item-title">
            {if $item.watched == false}
              <a class="unread" id="{$item.id}"href="{$item.link}" target="_blank" onclick="mark_read(this, {$item.id})">{$item.title}</a>
            {else}
              <a id="{$item.id}" href="{$item.link}" target="_blank">{$item.title}</a>
            {/if}
            </li>
            <li class="item-pubDate">{$item.pub_date}</li>
            <li class="item-read"><a href="#" onclick="autoMark({$item.feed_id}, {$item.id})"><span class="glyphicon glyphicon-upload"></a></li>
          </ul>
        {/foreach}
  </div>
</div>

