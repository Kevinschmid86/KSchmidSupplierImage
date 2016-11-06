<?php
/**
 * Created by PhpStorm.
 * User: kevin.schmid
 * Date: 06.11.2016
 * Time: 12:03
 */


namespace KSchmidSupplierImage;

use Enlight_Event_EventArgs;
use Shopware\Components\Plugin;

class KSchmidSupplierImage extends Plugin
{

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onSecureDetailPostDispatch'
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $arguments
     */
    public function onSecureDetailPostDispatch(Enlight_Event_EventArgs $arguments)
    {
        /**@var $controller \Shopware_Controllers_Frontend_Detail */
        $controller = $arguments->get('subject');
        $connection = $this->container->get('dbal_connection');
        $controller->View()->addTemplateDir($this->getPath() . '/Resources/views');
        $config = $this->container->get('shopware.plugin.config_reader')->getByPluginName($this->getName());
        $mediapathComplete = '';

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
                    $this->container->get('shopware_storefront.context_service')->getShopContext()
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
                        //Get Shopware Mediaservice
                        $mediaservice = $this->container->get('shopware_media.media_service');

                        //Build SQL for media path
                       $mediapath = $connection->fetchColumn(
                            'SELECT path FROM s_media WHERE id = :mediaId',
                             array(':mediaId' => $manufacturerImage)
                        );

                        if($mediaservice->has($mediapath) == 1)
                        {
                            $mediapathComplete = $mediaservice->getUrl($mediapath);
                        }

                    }
                }
            }
        }

        $controller->View()->assign('kschmidManufacturerImage', $mediapathComplete);
    }

}