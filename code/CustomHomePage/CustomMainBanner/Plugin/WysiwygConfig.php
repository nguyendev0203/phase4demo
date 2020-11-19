<?php
namespace CustomHomePage\CustomMainBanner\Plugin;

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
