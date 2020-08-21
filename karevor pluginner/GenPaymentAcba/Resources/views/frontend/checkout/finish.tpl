{extends file="parent:frontend/checkout/finish.tpl"}

  {* Main content *}
{block name="frontend_index_content"}
  
   {*}response params variable from acba payment - $AcbaPayParams{*}
   <div class="basket--info-messages">
       <div class="alert is--success is--rounded"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--check"></i> 
             </div>
             <div class="alert--content"> 
                 {$AcbaPayParams.actionCodeDescription}             
             </div> 
        </div>
    </div>    
{$smarty.block.parent}
{/block}