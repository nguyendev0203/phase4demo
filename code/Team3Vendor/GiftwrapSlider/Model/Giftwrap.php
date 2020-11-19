<?php
namespace Team3Vendor\GiftwrapSlider\Model;

use Team3Vendor\GiftwrapSlider\Model\Giftwrap\FileInfo;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;

class Giftwrap extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'team3vendor_giftwrapslider_giftwrap';
	protected $_cacheTag = 'team3vendor_giftwrapslider_giftwrap';
	protected $_eventPrefix = 'team3vendor_giftwrapslider_giftwrap';

	/**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

	protected function _construct()
	{
		$this->_init('Team3Vendor\GiftwrapSlider\Model\ResourceModel\Giftwrap');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}

	/**
     * Retrieve the Image URL
     *
     * @param string $imageName
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImageUrl($imageName = null)
    {
        $url = '';
        $image = $imageName;
        if (!$image) {
            $image = $this->getData('image');
        }
        if ($image) {
            if (is_string($image)) {
                $url = $this->_getStoreManager()->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ).FileInfo::ENTITY_MEDIA_PATH .'/'. $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * Get StoreManagerInterface instance
     *
     * @return StoreManagerInterface
     */
    private function _getStoreManager()
    {
        if ($this->_storeManager === null) {
            $this->_storeManager = ObjectManager::getInstance()->get(StoreManagerInterface::class);
        }
        return $this->_storeManager;
    }
}