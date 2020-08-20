{extends file="parent:frontend/detail/image.tpl"}


{* Product image - Thumbnails *}
{block name='frontend_detail_image_thumbs'}
    {if $sArticle.sConfigurator.0.groupID eq "10"}
        <div class="usb--stick-logo-cont">           
           <div class="usb--stick-usb usb-l">               
                   <img src="{media path="media/vector/license-now_usb.svg"}" alt="">               
               <div class="usb--stick-usb-r">
                   <p class="usb--stick-usb-r-t">{s name="usbtxt1" namespace="frontend/apcUsbStick"}Verfügbar auf{/s}</p>
                   <p class="usb--stick-usb-r-b">{s name="usbtxt2" namespace="frontend/apcUsbStick"}USB Stick{/s}</p>
               </div>
           </div>    
           <div class="usb--stick-usb">
               <img src="{media path="media/vector/versandLic.svg"}" alt="">  
               <div class="usb--stick-usb-r">
                   <p class="usb--stick-usb-r-t">{s name="usbtxt3" namespace="frontend/apcUsbStick"}Lizenzschlüssel{/s}</p>
                   <p class="usb--stick-usb-r-b">{s name="usbtxt4" namespace="frontend/apcUsbStick"}in 30 Sek.{/s}</p>
               </div>
           </div>       
        </div>
    {/if}
    {$smarty.block.parent}
{/block}

{* added 'if' in theme/.../detail/image.tpl str22,26 *}