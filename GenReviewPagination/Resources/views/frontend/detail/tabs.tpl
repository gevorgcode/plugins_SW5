{extends file="parent:frontend/detail/tabs.tpl"}

{block name="frontend_detail_tabs_rating_content_inner"}
   
    {* Offcanvas buttons *}
    {block name='frontend_detail_rating_buttons_offcanvas'}
        <div class="buttons--off-canvas">
            {block name='frontend_detail_rating_buttons_offcanvas_inner'}
                {s name="OffcanvasCloseMenu" namespace="frontend/detail/description" assign="snippetOffcanvasCloseMenu"}{/s}
                <a href="#" title="{$snippetOffcanvasCloseMenu|escape}" class="close--off-canvas">
                    <i class="icon--arrow-left"></i>
                    {s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
                </a>
            {/block}
        </div>
        {*}div.review--form-container only for it-nerd {*}
        <div class="review--form-container">
            {include file="frontend/detail/comment/form.tpl"}
        </div>
    {/block}

    <div class="content--product-reviews" id="detail--product-reviews">
        {* Response save comment *}
        {if $sAction == "ratingAction"}
            {block name='frontend_detail_comment_error_messages'}
                {if $sErrorFlag}
                    {if $sErrorFlag['sCaptcha']}
                        {$file = 'frontend/_includes/messages.tpl'}
                        {$type = 'error'}
                        {s namespace="frontend/detail/comment" name="DetailCommentInfoFillOutCaptcha" assign="content"}{/s}
                    {else}
                        {$file = 'frontend/_includes/messages.tpl'}
                        {$type = 'error'}
                        {s namespace="frontend/detail/comment" name="DetailCommentInfoFillOutFields" assign="content"}{/s}
                    {/if}
                {else}
                    {if {config name="OptinVote"} && !{$smarty.get.sConfirmation} && !{$userLoggedIn}}
                        {$file = 'frontend/_includes/messages.tpl'}
                        {$type = 'success'}
                        {s namespace="frontend/detail/comment" name="DetailCommentInfoSuccessOptin" assign="content"}{/s}
                    {else}
                        {$file = 'frontend/_includes/messages.tpl'}
                        {$type = 'success'}
                        {s namespace="frontend/detail/comment" name="DetailCommentInfoSuccess" assign="content"}{/s}
                    {/if}
                {/if}

                {include file=$file type=$type content=$content}
            {/block}
        {/if}

        {* Review title *}
        {block name="frontend_detail_tabs_rating_title"}
            <div class="content--title">
                 {$sArticle.articleName} - {s name="DetailCommentHeaderBewertungen"}Bewertungen{/s}
            </div>
            <div class="rivew--headline"></div>
        {/block}

        {* Display review *}
        <div class="review--listing-container" data-ajax-submit="true">
            {action module=widgets controller=productReviewPagination sArticle=$sArticle.articleID}
        </div>

        {* Publish product review *}
        {block name='frontend_detail_comment_post'}
            <div class="review--form-container">
                {include file="frontend/detail/comment/form.tpl"}
            </div>
        {/block}
    </div>
{/block}

