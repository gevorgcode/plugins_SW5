{extends file="parent:frontend/account/sidebar.tpl"}



{block name="frontend_account_menu_title"}
        {if {config name=useSltCookie} && $userInfo}
                <h2 class="navigation--headline  {if {$userImageSrc}}have--account-image{/if}">
                        {if {$userImageSrc}}
                                <div class="profile--photo" role="menuitem">
                                        <span  class="photo--area">
                                                <img  src="{$userImageSrc}" alt="img">
                                        </span>
                                </div>
                        {/if}
                                {s name="AccountGreetingBefore"}{/s}
                                {$userInfo['firstname']}
                                {s name="AccountGreetingAfter"}{/s}

                </h2>
        {else}
                <h2 class="navigation--headline">
                        {s name="AccountHeaderNavigation"}{/s}
                </h2>
        {/if}
{/block}