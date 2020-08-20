<div class="review--listing">
    {foreach $sVotes as $vote}
        {* Review entry *}
        {include file="frontend/detail/comment/entry.tpl"}
        
        {* Review answer *}
        {if $vote.answer}
            {include file="frontend/detail/comment/answer.tpl"}
        {/if}
    {/foreach}
</div>    
{if $sNumberPages > 1}
    <div class="listing--actions block-group">
        <div class="listing--paging panel--paging">
            {* Pagination - Previous page *}
            {if $sPage > 1}
                <a href="{$sPages.previous}" class="paging--link paging--prev">
                    <i class="icon--arrow-left"></i>
                </a>
            {/if}

            {* Pagination - current page *}
            <a title="" class="paging--link is--active">{$sPage}</a>

            {* Pagination - Next page *}
            {if $sPage < $sNumberPages}
                <a href="{$sPages.next}" class="paging--link paging--next">
                    <i class="icon--arrow-right"></i>
                </a>
            {/if}

            {* Pagination - Number of pages *}
            <span class="paging--display">
                {s name="ListingTextFrom" namespace="frontend/listing/listing_actions"}{/s} <strong>{$sNumberPages}</strong> 
            </span>
        </div>
    </div>
{/if}