{extends file='parent:frontend/account/profile.tpl'}

{* Email *}
{block name='frontend_account_profile_email_input_email'}
    {if $multiUser}
    {else}
        {$smarty.block.parent}
    {/if}    
{/block}
{* Email confirmation *}
{block name='frontend_account_profile_email_input_email_confirmation'}
    {if $multiUser}
    {else}
        {$smarty.block.parent}
    {/if}    
{/block}
{block name='frontend_account_profile_email_input_current_password'}
    {if $multiUser}
    {else}
        {$smarty.block.parent}
    {/if}    
{/block}
{block name="frontend_account_profile_email_required_info"}
    {if $multiUser}
    {else}
        {$smarty.block.parent}
    {/if}    
{/block}
{block name="frontend_account_profile_email_actions_submit"}
    {if $multiUser}
    {else}
        {$smarty.block.parent}
    {/if}    
{/block}