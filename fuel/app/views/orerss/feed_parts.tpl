<div class="row">
  <div class="col-md-9 col-lg-9" style="background-color: #893234;">
    <p>Title</p>
    {foreach $items as $item}
      <p>
      {if $item.already_read == false}
        <a class="unread" href="{$item.link}" target="_blank" onclick="mark_read(this, {$item.id})">{$item.title}</a>
      {else}
        <a href="{$item.link}" target="_blank">{$item.title}</a>
      {/if}
      </p>
    {/foreach}
  </div>
  
  <div class="col-md-3 col-lg-3" style="background-color: #893432;">
    <p>pubDate</p>
    {foreach $items as $item}
      <p>
        {if $item.already_read == false}
          <b>{$item.pub_date}</b>
        {else}
          {$item.pub_date}
        {/if}
      </p>
    {/foreach}
  </div>
</div>
