<div class="row">
  <div class="col-md-8 col-lg-8" style="background-color: #883234;">
    <p>Title</p>
    {foreach $items as $item}
      <p>
      {if $item.already_read == false}
        <a class="unread" id="{$item.id}"href="{$item.link}" target="_blank" onclick="mark_read(this, {$item.id})">{$item.title}</a>
      {else}
        <a id="{$item.id}" href="{$item.link}" target="_blank">{$item.title}</a>
      {/if}
      </p>
    {/foreach}
  </div>
  
  <div class="col-md-3 col-lg-3" style="background-color: #893433;">
    <p>pubDate</p>
    {foreach $items as $item}
      <p> {$item.pub_date} </p>
    {/foreach}
  </div>

  <div class="col-md-1 col-lg-1" style="background-color: #832932;">
  <p>read</p>
  {foreach $items as $item}
    <p>
        <a href="#" onclick="autoMark({$item.feed_id}, {$item.id})"><span class="glyphicon glyphicon-upload"></a>
    </p>
  {/foreach}
  </div>


</div>
