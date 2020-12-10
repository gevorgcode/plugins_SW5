{extends file="parent:frontend/account/index.tpl"}


{block name="frontend_account_index_addresses"}
        {$smarty.block.parent}
        <div class="account--picture account--box panel has--border is--rounded">
                <h2 class="panel--title is--underline">
                        {s namespace="frontend/account/index" name="AccountImageSelect"}You can choose you profile image{/s}
                </h2>
                {if {$userImageSrc}}
                        <div style="border: 1px solid #dadae6; width: fit-content; margin-bottom: 20px;">
                                <img class="userPhoto" style="height: 100px; cursor: pointer" src="{$userImageSrc}"
                                     alt="user image" title="Change">
                        </div>
                {/if}
                <form class="user--form {if {$userImageSrc}}is--hidden{/if}" action="/widgets/Image/file/"
                      enctype="multipart/form-data" method="post" style="padding: 20px;">
                        <span class="file"><input type="file" name="media"></span>
                        <button class="btn-file" type="submit">Save</button>
                </form>
        </div>
{/block}