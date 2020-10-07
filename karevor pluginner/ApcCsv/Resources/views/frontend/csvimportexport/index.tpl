{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_content_main'}
    <section class="{block name="frontend_index_content_main_classes"}content-main container block-group{/block}">
        <p>For changing the payment status, you should attach the necessary *.csv file, <br> then click on "change and download" button. <br> The process  will take up to 5 minutes.</p>
        <table width="600">
            <form action="/Csvimportexport/download" method="post" enctype="multipart/form-data">

            <tr>
            <td width="20%">Select file</td>
            <td width="80%"><input type="file" name="file" id="file" required /></td>
            </tr>

            <tr>
            <td>Download</td>            
            <td><button type="submit" name="submit" >Change and download</button></td>
            </tr>

            </form>
            </table>          
    </section>
{/block}