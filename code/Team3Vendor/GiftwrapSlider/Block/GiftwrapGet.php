<?php
namespace Team3Vendor\GiftwrapSlider\Block;

class GiftwrapGet extends \Magento\Framework\View\Element\Template
{
	protected $_giftwrapFactory;
	protected $_storeManager;
	protected $_urlInterface;    
	protected $storeConfig;
	protected $currencyCode;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Team3Vendor\GiftwrapSlider\Model\GiftwrapFactory $giftwrapFactory,
		\Magento\Store\Model\StoreManagerInterface $storeManager, 
		\Magento\Framework\UrlInterface $urlInterface,
		\Magento\Store\Model\StoreManagerInterface $storeConfig,
		\Magento\Directory\Model\CurrencyFactory $currencyFactory,
		array $data = []
	){
		$this->_giftwrapFactory = $giftwrapFactory;
		$this->_storeManager = $storeManager; 
		$this->_urlInterface = $urlInterface;
		$this->storeConfig = $storeConfig;
        $this->currencyCode = $currencyFactory->create();
		return parent::__construct($context, $data);
	}

	public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

	public function getCollection()
	{
		return $this->_giftwrapFactory->create()
			->getCollection()
			->addFieldToFilter('store_ids', array('in' => array(0, $this->getStoreId())))
			->addFieldToFilter('status', 1);
	}

	public function getBaseImgUrl() {
		return $this->_urlInterface->getBaseUrl() . 'media/Team3Vendor/GiftwrapSlider/giftwraps_slider/';
	}

	public function getCurrentCurrencySymbol()
    {
        $currentCurrency = $this->storeConfig->getStore()->getCurrentCurrencyCode();
        $currency = $this->currencyCode->load($currentCurrency);
        return $currency->getCurrencySymbol();
    }

    public function getCurrentGiftwrapName() {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');  
        return 'Giftwrap ' . $cart->getQuote()->getGiftwrapName();
    }
}