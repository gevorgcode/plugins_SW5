{extends file='parent:documents/index.tpl'}

{block name="document_index_info_currency"}
    {$smarty.block.parent}
    <p>{s name="DocumentIndexCustomPdf"}{/s}</p>    
{/block}


 {block name="document_index_head_right"}
    {$Containers.Header_Box_Right.value}
    {s name="DocumentIndexCustomerID"}{/s} {$User.billing.customernumber|string_format:"%06d"}<br />
    {if $User.billing.ustid}
    {s name="DocumentIndexUstID"}{/s} {$User.billing.ustid|replace:" ":""|replace:"-":""}<br />
    {/if}
    {s name="DocumentIndexOrderID"}{/s} {$Order._order.ordernumber}<br />
    {s name="DocumentIndexDate"}{/s} {$Document.date}<br />
    {s name="DocumentIndexDeliveryDate"}{/s} {$Document.date}<br />
{/block}