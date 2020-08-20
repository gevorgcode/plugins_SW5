{extends file='parent:frontend/index/index.tpl'}

{namespace name="frontend/genBannerSlider"}

{block name="frontend_index_header"}
    {$smarty.block.parent}
    <div class="lic--moffice-top">
        <div class="lic--moffice-top-cont">
            <div class="lic--moffice-topl">
                <h1>Microsoft Office</h1>
                <p>{s name=mofficet1}In einer digitalisierten Welt ist eine Bürosoftware unabdingbar. Egal ob in der Schule, im Studium oder bei der Arbeit. Immer wieder müssen Textdokumente verarbeitet, Tabellenkalkulationen angefertigt oder Präsentationen erstellt werden.{/s} </p>
                <a href="{s name=mofficetbtnhref}https://license-now.de/office-organisation/{/s}" class="btn moffice--btn">{s name=mofficetbtn}Zu unseren Produkten{/s}</a>
            </div>
            <div class="lic--moffice-topr">
                <div class="lic--moffice-topr-imgc">
                    <img src="{media path="media/image/offproplus2019.png"}" alt="">
                </div>            
            </div>
        </div>    
    </div>
{/block}
 
{* Footer *}
{block name="frontend_index_footer"}    
    <div class="moffice--emotions">        
        <div class="moffice-emo1">
            <div class="emotion--wrapper" data-controllerurl="/widgets/emotion/index/emotionId/283/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
        </div>
        <div class="moffice-emo2">
            <div class="emotion--wrapper" data-controllerurl="/widgets/emotion/index/emotionId/271/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
        </div>        
    </div>
    {$smarty.block.parent}
{/block}  

                   
                                                         


