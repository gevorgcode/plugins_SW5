{extends file="parent:frontend/checkout/cart.tpl"}

{* Main content *}
{block name="frontend_index_content"}
    {if $AmeriaPayParams}
        <div class="basket--info-messages">
            <div class="alert is--error is--rounded"> 
                <div class="alert--icon"> 
                    <i class="icon--element icon--cross"></i> 
                </div>
                <div class="alert--content">
                    <div>Մուտքագրված տվյալներով քարտ չի գտնվել:</div>
                </div>
            </div>   
        </div> 
    {/if}
    {if $responseFromPay}
        <div class="basket--info-messages">
            <div class="alert is--error is--rounded"> 
                <div class="alert--icon"> 
                    <i class="icon--element icon--cross"></i> 
                </div>
                <div class="alert--content">
                    <div>{s name='PaymentNotFinished' namespace='frontend/confirm/finish'}Կայքի ծանրաբեռնվածության պաճառով առկա են որոշակի խնդիրներ, խնդրում ենք կրկին փորձել կամ կապնվել մեզ հետ, մեր մասնագետները հնարավորինս արագ կլուծեն խնդիրը: Կապնվելու համար սեղմեք <a href="mailto:order@masisy.com">այստեղ:</a>{/s}</div>
                </div>
            </div>   
        </div> 
    {/if}    
    {$smarty.block.parent}
{/block}