<?php
namespace Team3Vendor\GiftwrapSlider\Model\Giftwrap;

use Team3Vendor\GiftwrapSlider\Model\ResourceModel\Giftwrap\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Team3Vendor\GiftwrapSlider\Model\Giftwrap\FileInfo;
use Magento\Framework\Filesystem;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $giftwrapCollectionFactory
     * @param array $meta
     * @param array $data
     */
    
    protected $_loadedData;

    /**
     * @var Filesystem
     */
    private $fileInfo;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $giftwrapCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $giftwrapCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        $this->_loadedData = array();
        foreach ($items as $giftwrap) {
            $giftwrap = $this->convertValues($giftwrap);
            $this->_loadedData[$giftwrap->getId()] = $giftwrap->getData();
        }
        return $this->_loadedData;
    }

    /**
     * Converts image data to acceptable for rendering format
     *
     * @param \Team3Vendor\GiftwrapSlider\Model\Giftwrap $giftwrap
     * @return \Team3Vendor\GiftwrapSlider\Model\Giftwrap $giftwrap
     */
    private function convertValues($giftwrap)
    {
        $fileName = $giftwrap->getImage();
        $image = [];
        if ($this->getFileInfo()->isExist($fileName)) {
            $stat = $this->getFileInfo()->getStat($fileName);
            $mime = $this->getFileInfo()->getMimeType($fileName);
            $image[0]['name'] = $fileName;
            $image[0]['url'] = $giftwrap->getImageUrl();
            $image[0]['size'] = isset($stat) ? $stat['size'] : 0;
            $image[0]['type'] = $mime;
        }
        $giftwrap->setImage($image);

        return $giftwrap;
    }

    /**
     * Get FileInfo instance
     *
     * @return FileInfo
     *
     * @deprecated 101.1.0
     */
    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}