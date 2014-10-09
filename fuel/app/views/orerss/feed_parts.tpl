<div class="col-md-9 col-lg-9" style="background-color: #893234;">
  <p>Title</p>
  {foreach $items as $item}
    <p>
    {if $item.unread == true}
      <b> <a href="{$item.link}">{$item.title}</a> </b>
    {else}
      <a href="{$item.link}">{$item.title}</a>
    {/if}
    </p>
  {/foreach}
</div>

<div class="col-md-3 col-lg-3" style="background-color: #893432;">
  <p>pubDate</p>
  {foreach $items as $item}
    <p>
      {if $item.unread == true}
        <b>{$item.pubDate}</b>
      {else}
        {$item.pubDate}
      {/if}
    </p>
  {/foreach}
</div>

