<div class="apc--checkout-finish-licens apc--account-download-licens">
    <p class="finish-licens-content">{$articleName}</p>
</div>

 <div class="panel--tr">
         <div class="download--name download--button-content panel--td column--info">
             {foreach $downloads as $download}
             <a href="{$download.link}" title="{"{$download.text}"|escape} {$articleName|escape}" class="btn is--primary is--small" target="_blank">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                 {$download.text}
             </a>
             {/foreach}
         </div>
 </div>
