{extends file='parent:frontend/account/index.tpl'}


{block name="frontend_account_index_info_content"}
    <div class="panel--body is--wide">
        <p>
            {$sUserData.additional.user.salutation|salutation}
            {if {config name="displayprofiletitle"}}
                {$sUserData.additional.user.title|escapeHtml}<br/>
            {/if}
            {$sUserData.additional.user.firstname|escapeHtml} {$sUserData.additional.user.lastname|escapeHtml}<br />
            {if $sUserData.additional.user.birthday}
                {$sUserData.additional.user.birthday|date:'dd.MM.y'}<br />
            {/if}
            {$sUserData.additional.user.email|escapeHtml}<br />
            {if $invoiceEmail} {$invoiceEmail}{/if}
        </p>
    </div>
{/block}