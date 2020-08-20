{extends file='parent:frontend/account/sidebar.tpl'}

{namespace name="ApsB2b/frontend"}

{* Link to the user product notes *}
{block name="frontend_account_menu_link_notes"}
    {if {$B2bStatus}}
        <li class="navigation--entry">
            <a href="{url module='frontend' controller='account' action = 'geschaftskunde'}" title="{s name="geschaftskunde"}Geschäftskunde{/s}" class="navigation--link{if {controllerAction|lower} == 'geschaftskunde'} is--active{/if}" rel="nofollow">
                {s name="geschaftskunde"}Geschäftskunde{/s}
            </a>
        </li>
    {/if}
    {$smarty.block.parent}
{/block}
