<div class="vag_language_selecion">
    <div class="box">
        <div class="lang_select">
            <div class="select_panel">
                <span class="panel_headtext">
                     {s name='countrySelectionPopUpText' namespace="themes/SicsTheme/frontend/index/index"}Sprache auswählen{/s}</span>
                </span>
                <i class="icon--arrow-down select_panel_arrow "></i>
            </div>
            <div class="lang_panel">
                {foreach $languages as $language name='langs'}
                    <div class="lang_sample {if $language->getId() === $vagShop->getId()}selected{/if}" data-lang-id="{$language->getId()}">
                        <div class="language--flag {$flags[$smarty.foreach.langs.index]["locale"]}"></div>
                        <span class="lang_name">{$flags[$smarty.foreach.langs.index]["language"]}</span>
                    </div>
                {/foreach}
            </div>
        </div>
        <div class="top-bar--language navigation--entry">
            <form method="post" class="language--form">
                <div class="field--select">
                    <select name="__shop" class="language--select" data-auto-submit="true">
                        {foreach $languages as $language}
                            <option value="{$language->getId()}">
                                {$language->getName()}
                            </option>
                        {/foreach}
                    </select>
                    <input type="hidden" name="__redirect" value="1">
                    <span class="arrow"></span>
                </div>
            </form>
        </div>
    </div>
</div>   
