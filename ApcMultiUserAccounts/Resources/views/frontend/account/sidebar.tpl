{extends file='parent:frontend/account/sidebar.tpl'}

{* Link to the user downloads *}
{block name="frontend_account_menu_link_downloads"}
    {$smarty.block.parent}
    {if $multiUserShow}
        <li class="navigation--entry">
            <a href="{url module='frontend' controller='MultiUsers' action='index'}" title="{s namespace='MultiUsers' name="apc_Mitarbeiterzugänge"}Mitarbeiterzugänge{/s}" class="navigation--link{if {controllerName|lower} == 'multiusers'}is--active{/if}" rel="nofollow">
                {s namespace='MultiUsers' name="apc_Mitarbeiterzugänge"}Mitarbeiterzugänge{/s}
            </a>
        </li>
    {/if}    
{/block}
