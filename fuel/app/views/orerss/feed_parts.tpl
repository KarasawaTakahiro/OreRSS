<div class="row">
  <div class="col-md-9 col-lg-9" style="background-color: #893234;">
    <p>Title</p>
    {foreach $items as $item}
      <p>
      {if $item.already_read == true}
        <a href="{$item.link}" target="_blank">{$item.title}</a>
      {else}
        <b> <a href="{$item.link}" target="_blank">{$item.title}</a> </b>
      {/if}
      </p>
    {/foreach}
  </div>
  
  <div class="col-md-3 col-lg-3" style="background-color: #893432;">
    <p>pubDate</p>
    {foreach $items as $item}
      <p>
        {if $item.already_read == true}
          {$item.pub_date}
        {else}
          <b>{$item.pub_date}</b>
        {/if}
      </p>
    {/foreach}
  </div>
</div>
