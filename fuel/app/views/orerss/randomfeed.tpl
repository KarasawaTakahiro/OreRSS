<div class="randomfeed">
    {assign var="i" value=0}
    {foreach $randomfeed as $feed}
    {if $i % 2 == 0}
    <div class="row">
        {/if}
        <div class="col-md-6 frame">
            <div class="item">
                <div class="huge-thumbnail">
                    {foreach $feed.items as $item}
                    {if $item.thumbnail == null}
                    {Asset::img('thumbnail_nothing.png', ["alt"=>{$item.title}])}
                    {else}
                    {Asset::img($item.thumbnail, ["alt"=>{$item.title}])}
                    {/if}
                    {if $item@iteration % 2 == 0}
                    <br />
                    {/if}
                    {/foreach}
                </div><!-- thumb -->
                <div class="title">
                    <a href="{$feed.url}">{$feed.title}</a>
                </div>
                <div class="pull">
                    <form class="smart-pull" >
                        <button type="submit" href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span></button>
                        <input type="hidden" name="id" value="{$feed.id}" />
                    </form>
                </div>
            </div>
        </div>
        {if $i % 2 == 1}
    </div>
    {/if}
    {math equation="x+1" x=$i assign=i}
    {/foreach}
</div>

