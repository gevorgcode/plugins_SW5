{extends file='parent:frontend/index/index.tpl'}

{namespace name="ApcLicenseStatus"}

{block name='frontend_index_content_main'}
    <section class="{block name="frontend_index_content_main_classes"}content-main container block-group{/block}">
        {if {$verified} eq 'no'}
            <div class="alert is--warning is--rounded" style="margin-top: 25px;"> 
                <div class="alert--icon"> 
                    <i class="icon--element icon--warning"></i>
                </div>
                <div class="alert--content"> 
                    We have sent a confirmation link to your <span style="color: #203e45">"{$hideEmail}"</span> email.
                    <br>
                    You need to confirm this to proceed.
                </div> 
            </div>
        {/if} 
        
        {if {$verified} eq 'yes'}
            <p>
                <span>------user ----------</span> <br>
                email: {$email}
                <br>salutation: {$user.salutation}
                <br>firstname: {$user.firstname}
                <br>lastname: {$user.lastname}
                {*}<br>order count: {$orderDetails|@count}{*}
                <br>
                <br>
                <br>               
                
            </p>
            {foreach $orderDetails as $orderDetail} 
                {if {$orderDetail.0.ordernumber} > 0}   
                <hr>            
                <div class="order">                  
                   <strong>
                    <br> <span>ordernumber: {$orderDetail.0.ordernumber}</span>
                    <br> <span>order date: {$orderDetail.0.s_order.ordertime}</span>
                    <br> <span>order ammount: {$orderDetail.0.s_order.invoice_amount}{$orderDetail.0.s_order.currency}</span>
                    {*}<br> <span>order status: {$orderDetail.0.s_order.status_name}</span>
                    <br> <span>payment status: {$orderDetail.0.s_order.cleared_name}</span>{*}
                    <br> <span>payment: {$orderDetail.0.s_order.payment_description}</span>                    
                    {if {$orderDetail.0.s_order.status} == 2 || {$orderDetail.0.s_order.cleared} == 12}
                        <br><span style="color: green">Order Paid</span>
                    {elseif {$orderDetail.0.s_order.status} == 4 || {$orderDetail.0.s_order.cleared} == 35}
                        <br><span style="color: red">Order canceled</span>
                    {else}
                        <br><span style="color: orange">Order in progress</span>
                    {/if}
                    {if $orderDetail.0.s_order.paymentID == 82}
                    <br><a class="btn" href="tel:08000008124" > <i class="icon--phone" style="font-size: 14px"> </i> 0800 000 81 24</a>
                    {/if}
                    {if {$orderDetail.0.s_order.status} == 4 || {$orderDetail.0.s_order.cleared} == 35}
                    {else}
                        {*}<br> <a target="_blank" class="is--primary" href="{$orderDetail.0.invoice_down_link}">download invoice</a>{*}
                        <br> <a class="is--primary" target="_blank" href="{url controller=CheckLicense action=sendInvoice onum=$orderDetail.0.ordernumber token=$token}">Resend invoice to email</a>
                    {/if}
                    
                    </strong> <br><br><br>
                    
                    
                    {foreach $orderDetail as $Detail}                    
                        <br> <span>article number :{$Detail.articleordernumber}</span>
                        <br> <span>article name :{$Detail.name}</span>
                        <br> <span>price :{$Detail.price}</span>
                        <br> <span>quantity :{$Detail.quantity}</span>
                        {foreach $Detail.esddetails as $esddetail}
                            {if {$esddetail.serial}}
                                <br><span>License key status: <span style="color: green; font-weight: bold">OK</span></span>                                
                            {/if}
                            {*}<br> <span>License key :{$esddetail.serial}</span>{*}
                        {/foreach}      
                           
                        {if $Detail.esddetails.0.serial} 
                             {if {$Detail.s_order.status} == 2 || {$Detail.s_order.cleared} == 12}
                                <br> <a target="_blank" href="{url controller=CheckLicense action=sendLicense onum=$orderDetail.0.ordernumber orderdetailsID=$Detail.orderdetailsID token=$token}" class="is--secondary">Resend license keys to email</a> 
                             {else}
                                 <br><br><span style="background: yellow">Order not paid yet!</span> <br>
                                 <a class="is--secondary btn is--disabled" disabled="disabled">❌ Resend license keys </a>
                             {/if}
                        {else}
                            {if {$orderDetail.0.s_order.status} == 4 || {$orderDetail.0.s_order.cleared} == 35}
                            {else}
                                <br><span>License key status: <span style="font-weight: bold; color: red">There is a problem</span></span>
                            {/if}
                        {/if}                                                                                                       
                            <div class="finish--download-link">
                                {if {$Detail.esdDownload.file_1}}
                                   <p><a class="is--primary"  href="{$Detail.esdDownload.file_1}" target="_blank">{$Detail.esdDownload.text_1} <i class="icon--download"></i> </a></p>                            
                                {/if}
                                {if {$Detail.esdDownload.file_2}}
                                    <p><a class="is--primary"  href="{$Detail.esdDownload.file_2}" target="_blank">{$Detail.esdDownload.text_2} <i class="icon--download"></i> </a></p>
                                {/if}
                                {if {$Detail.esdDownload.file_3}}
                                    <p><a class="is--primary"  href="{$Detail.esdDownload.file_3}" target="_blank">{$Detail.esdDownload.text_3} <i class="icon--download"></i> </a></p>
                                {/if}
                                {if {$Detail.esdDownload.file_4}}
                                    <p><a class="is--primary"  href="{$Detail.esdDownload.file_4}" target="_blank">{$Detail.esdDownload.text_4} <i class="icon--download"></i> </a></p>
                                {/if}

                                {if $Locale == en_GB}                
                                    {if {$Detail.esdDownload.file_5}}
                                       <p><a class="is--primary"  href="{$Detail.esdDownload.file_5}" target="_blank">{$Detail.esdDownload.text_5} <i class="icon--download"></i> </a></p>                            
                                    {/if}
                                    {if {$Detail.esdDownload.file_6}}
                                        <p><a class="is--primary"  href="{$Detail.esdDownload.file_6}" target="_blank">{$Detail.esdDownload.text_6} <i class="icon--download"></i> </a></p>
                                    {/if}
                                {/if}

                                {if $Locale == fr_FR}
                                    {if {$Detail.esdDownload.file_7}}
                                        <p><a class="is--primary"  href="{$Detail.esdDownload.file_7}" target="_blank">{$Detail.esdDownload.text_7} <i class="icon--download"></i> </a></p>
                                    {/if}
                                    {if {$Detail.esdDownload.file_8}}
                                        <p><a class="is--primary"  href="{$Detail.esdDownload.file_8}" target="_blank">{$Detail.esdDownload.text_8} <i class="icon--download"></i> </a></p>
                                    {/if}
                                {/if}
                            </div>                        
                           
                        
                           
                       <br>
                       <br>
                           
                        
                    {/foreach}
                                        
                    <hr>
                </div>
                {/if}
            {/foreach}            
        {/if}
       
        
        
        
        
        
        {*}
        
        
        {if {$verified} eq 'yes'}
            <p>
                <span>------user ----------</span> <br>
                email: {$email}
                {$user|var_dump}
                <br><br><br>
            </p>
            {foreach $orderDetails as $orderDetail}                
                <p>------order details-------</p>
                <p>ordernumber: {$orderDetail.0.ordernumber}</p>
                <p>invoice link: {$orderDetail.0.invoice_down_link}</p>
                {foreach $orderDetail as $Detail}                    
                    <p>{$Detail|var_dump}</p> <br>                    
                {/foreach}
                <hr>
            {/foreach}            
        {/if}
        
        {*}
        
    </section>
{/block}
