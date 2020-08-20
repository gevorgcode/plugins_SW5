{extends file='parent:frontend/account/index.tpl'}

{* Welcome text *}
{block name="frontend_account_index_welcome"}
    {$smarty.block.parent}
    {if $B2bStatus}
        {if {$B2bStatus eq "bronze"}}
            <div class="account-status account-bronze">
                <div><p style="margin: 0">{s name='getsaccountbr'}Profitieren Sie als&nbsp; <b>Bronze Member,</b> jetzt von ihren Vorteilen.{/s}</p></div>
                <img src="{media path="media/vector/it-nerd24_bronze.svg"}" alt="">
            </div>
        {elseif {$B2bStatus eq "silver"}}
            <div class="account-status account-silver">
                <div><p style="margin: 0">{s name='getsaccountsil'}Profitieren Sie als&nbsp;<b>Silver Member,</b> jetzt von ihren Vorteilen.{/s}</p></div>
                <img src="{media path="media/vector/it-nerd24_silver.svg"}" alt="">
            </div>
        {elseif {$B2bStatus eq "gold"}}
            <div class="account-status account-gold">
                <div><p style="margin: 0">{s name='getsaccountgol'}Profitieren Sie als&nbsp;<b>Gold Member,</b> jetzt von ihren Vorteilen.{/s}</p></div>
                <img src="{media path="media/vector/it-nerd24_gold.svg"}" alt="">
            </div>
        {/if}
    {/if}
{/block}


