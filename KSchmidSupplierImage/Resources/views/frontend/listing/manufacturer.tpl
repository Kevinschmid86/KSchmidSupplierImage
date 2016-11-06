{extends file='parent:frontend/listing/manufacturer.tpl'}

{block name="frontend_listing_list_filter_supplier_headline"}

    {if $kschmidManufacturerImage}
        <div class="hero--mediafile">
            <img class="vendor--image" src="{link file=$kschmidManufacturerImage}" alt="{$manufacturer->getName()|escape}">
        </div>
    {/if}

    {$smarty.block.parent}

{/block}