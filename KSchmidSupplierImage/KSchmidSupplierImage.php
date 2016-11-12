<?php
/**
 * Created by PhpStorm.
 * User: kevin.schmid
 * Date: 06.11.2016
 * Time: 12:03
 */


namespace KSchmidSupplierImage;

use Enlight_Event_EventArgs;
use League\Flysystem\Exception;
use Shopware\Components\Plugin;

class KSchmidSupplierImage extends Plugin
{

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onSecureDetailPostDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onSecureDetailPostDispatch'
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $arguments
     */
    public function onSecureDetailPostDispatch(Enlight_Event_EventArgs $arguments)
    {
        /**@var $controller \Shopware_Controllers_Frontend_Detail */
        $controller = $arguments->get('subject');
        $controller->View()->addTemplateDir($this->getPath() . '/Resources/views');
        $config = $this->container->get('shopware.plugin.config_reader')->getByPluginName($this->getName());
        $media = '';
        $shopContext = $this->container->get('shopware_storefront.context_service')->getShopContext();

        //Implement only for Manufacturer Action
        if($controller->Request()->getActionName() == 'manufacturer' && isset($config['supplierAttribute']))
        {
            //Get manufacturer id from params
            $manufacturerId = $controller->Request()->getParam('sSupplier', null);

            //Check if manufacturerId exists
            if(isset($manufacturerId))
            {
                //get Manufacturer from manufacturer service
                /**@var $manufacturer Manufacturer*/
                $manufacturer = $this->container->get('shopware_storefront.manufacturer_service')->get(
                    $manufacturerId,
                    $shopContext
                );

                //Check if manufacturer exists
                if(isset($manufacturer))
                {
                    //Now check if an image exists

                    $manufacturerArray = json_decode(json_encode($manufacturer->getAttribute('core')), true);

                    if(array_key_exists($config['supplierAttribute'], $manufacturerArray))
                    {
                        $manufacturerImage = $manufacturer->getAttribute('core')->get($config['supplierAttribute']);
                    }
                    else
                    {
                        $manufacturerImage = null;
                    }

                    if(isset($manufacturerImage))
                    {
                        $media = Shopware()->Container()->get('shopware_storefront.media_service')->get($manufacturerImage, $shopContext);
                        $media = Shopware()->Container()->get('legacy_struct_converter')->convertMediaStruct($media);

                    }
                }
            }
        }
        else if($controller->Request()->getParam('controller') == 'detail' && isset($config['supplierAttribute']))
        {
            //Get articleid from params
            $articleId = $controller->Request()->getParam('sArticle', null);

            //Get Article from ArticleId
            try {
                $article = Shopware()->Modules()->Articles()->sGetArticleById(
                    $articleId
                );
            } catch (\Exception $e) {
                $article = null;
            }

            if($article !== null)
            {
                $manufacturerArray = json_decode(json_encode($article['supplier_attributes']['core']), true);

                if(array_key_exists($config['supplierAttribute'], $manufacturerArray))
                {
                    $manufacturerImage = $article['supplier_attributes']['core']->get($config['supplierAttribute']);
                }
                else
                {
                    $manufacturerImage = null;
                }

                if(isset($manufacturerImage))
                {
                    $media = Shopware()->Container()->get('shopware_storefront.media_service')->get($manufacturerImage, $shopContext);
                    $media = Shopware()->Container()->get('legacy_struct_converter')->convertMediaStruct($media);
                }
            }
        }

        //$controller->View()->assign('kschmidManufacturerImage', $mediapathComplete);
        $controller->View()->assign('kschmidManufacturerImage', $media);
    }

}