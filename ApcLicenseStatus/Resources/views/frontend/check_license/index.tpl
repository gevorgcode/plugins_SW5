{extends file='parent:frontend/index/index.tpl'}

{namespace name="ApcLicenseStatus"}

{block name='frontend_index_content_main'}
    <section class="{block name="frontend_index_content_main_classes"}content-main container block-group{/block}">
        <p>Check License-key by ordernumber</p>
        <p style="font-size: 12px;">*To get the entire list of orders, enter your email address</p>
        <form action="/CheckLicense/sendValidate" method="post">
            <input name="ordernumber_or_email" type="text" placeholder="Order number or email">
            <button class="is--secondary" type="submit">Submit</button>
        </form>               
    </section>
{/block}


