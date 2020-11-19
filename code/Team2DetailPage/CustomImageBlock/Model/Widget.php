<?php
namespace Team2DetailPage\CustomImageBlock\Model;

use \Magento\Widget\Model\Widget as BaseWidget;

class Widget
{
    public function beforeGetWidgetDeclaration(BaseWidget $subject, $type, $params = [], $asIs = true)
    {
        // I rather do a check for a specific parameters
        if(key_exists("widget_image_chooser", $params)) {
            $url = $params["widget_image_chooser"];
            if(strpos($url,'/directive/___directive/') !== false) {

                $parts = explode('/', $url);
                $key   = array_search("___directive", $parts);
                if($key !== false) {

                    $url = $parts[$key+1];
                    $url = base64_decode(strtr($url, '-_,', '+/='));

                    $parts = explode('"', $url);
                    $key   = array_search("{{media url=", $parts);
                    $url   = $parts[$key+1];

                    $params["widget_image_chooser"] = $url;
                }
            }
        }

        return array($type, $params, $asIs);
    }
}
