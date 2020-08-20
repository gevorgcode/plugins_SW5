{extends file="parent:frontend/detail/tabs.tpl"}


{* Tab navigation *}
{block name="frontend_detail_tabs_navigation"}
    <div class="tab--navigation">
        {block name="frontend_detail_tabs_navigation_inner"}
            {* Description tab *}
            {block name="frontend_detail_tabs_description"}
                <a href="#" class="tab--link" title="{s name='DetailTabsDescription'}{/s}" data-tabName="description">{s name='DetailTabsDescription'}{/s}</a>
            {/block}

            {* Rating tab *}
            {block name="frontend_detail_tabs_rating"}
                {if !{config name=VoteDisable}}
                    <a href="#" class="tab--link" title="{s name='DetailTabsRating'}{/s}" data-tabName="rating">
                        {s name='DetailTabsRating'}{/s}
                        {block name="frontend_detail_tabs_navigation_rating_count"}
                            <span class="product--rating-count">{$sArticle.sVoteAverage.count}</span>
                        {/block}
                    </a>
                {/if}
            {/block}
            {*Custom Tab*}
            {if $tabs}
                {foreach $tabs as $tab}
                    <a href="#" class="tab--link" title="{$sArticle.attributes.core->get("tab_name")}" data-tabName="description">{$tab.tab_name}</a>
                {/foreach}
            {/if}

        {/block}
    </div>
{/block}

{block name="frontend_detail_tabs_content_inner"}
    {$smarty.block.parent}
    {if $tabs}
        {foreach $tabs as $tab}
            <div class="tab--container">
                    <div class="tab--header">
                            <a href="#" class="tab--title" title="{$tab.tab_name}">{$tab.tab_name}</a>
                    </div>
                    {* Description preview *}
                    <div class="tab--preview">
                            {*}{$sArticle.description_long|strip_tags|truncate:100:'...'}<a href="#" class="tab--link" title="{s name="PreviewTextMore"}{/s}">{s name="PreviewTextMore"}{/s}</a>{*}
                    </div>
                    
                    <div class="tab--content">
                       <div class="apc--tab-content">
                           {$tab.tab_content}
                       </div>
                    </div>
            </div>
        {/foreach}
    {/if}
{/block}
