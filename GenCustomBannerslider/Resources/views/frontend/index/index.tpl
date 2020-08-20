{extends file='parent:frontend/index/index.tpl'}

{* Maincategories navigation top *}
{block name='frontend_index_navigation_categories_top'}
    <div class="lic--top-container">
        {$smarty.block.parent}        
        {if {controllerName|lower} == "index"}
            {include file='frontend/index/lic-indextop.tpl'}            
        {/if}
    </div>    
{/block}

{block name="frontend_index_navigation_categories_top_include"}
    {$smarty.block.parent}
    <div class="lic--top--white"></div>
{/block}        

        
