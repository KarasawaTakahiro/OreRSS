<div class="randomfeed">
    {foreach $randomfeed as $feed}
    {if $feed@index % 2 == 0}
    <div class="row">
        {/if}
        <div class="col-md-6 frame">
            <div class="item">
                <div class="huge-thumbnail">
                    {foreach $feed.items as $item}
                    {Asset::img($item.thumbnail, ["alt"=>{$item.title}])}
                    {if $item@index % 2 == 1}
                    <br>
                    {/if}
                    {/foreach}
                </div>
                <div class="title">
                    <a href="{$feed.url}">{$feed.title}</a>
                </div>
                <div class="pull">
                    <form class="smart-pull" >
                        <button type="submit" href="#"><span class="glyphicon glyphicon-plus"></span></button>
                        <input type="hidden" name="id" value="{$feed.id}">
                    </form>
                </div>
            </div>
        </div>
    {if $feed@index % 2 == 1}
    </div>
    {/if}
    {/foreach}
</div>
