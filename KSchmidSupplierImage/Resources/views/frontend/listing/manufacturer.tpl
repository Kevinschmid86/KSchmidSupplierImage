{extends file='parent:frontend/listing/manufacturer.tpl'}

{block name="frontend_listing_list_filter_supplier_headline"}

    {if $kschmidManufacturerImage}
        <div class="hero--mediafile">
            {if isset($kschmidManufacturerImage.thumbnails[1].sourceSet)}
                <img class ="vendor--image" srcset="{$kschmidManufacturerImage.thumbnails[1].sourceSet}"
                     alt="{$kschmidManufacturerImage.description|escape}"
                     title="{$manufacturer->getName()|truncate:160}" />
            {else}
                <img class="vendor--image" src="{link file=$kschmidManufacturerImage.source}"
                     alt="{$kschmidManufacturerImage.description|escape}"
                     title="{$manufacturer->getName()|truncate:160}" />
            {/if}
        </div>
    {/if}

    {$smarty.block.parent}

{/block}