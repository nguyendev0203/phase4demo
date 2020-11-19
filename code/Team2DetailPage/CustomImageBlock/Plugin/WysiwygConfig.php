<?php
namespace Team2DetailPage\CustomImageBlock\Plugin;

class WysiwygConfig
{
 public function afterGetConfig($subject, \Magento\Framework\DataObject $config)
 {
   $config->addData([
    'add_directives' => true,
   ]);

   return $config;
 }
}
