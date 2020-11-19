<?php
namespace Team2BrowseAll\OnePageProducts\Controller\Product;

class Onepage extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $helperData;

    /**
     * @param \Team2BrowseAll\OnePageProducts\Helper\Data $helperData
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Team2BrowseAll\OnePageProducts\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
        $this->_coreRegistry = $coreRegistry;
        $this->categoryRepository = $categoryRepository;
        $this->_storeManager = $storeManager;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $categoryid = $this->helperData->getGeneralConfig('category_browseall');
        $store = $this->_storeManager->getStore();
        $category = $this->categoryRepository->get(
            $categoryid
        );

        $this->_coreRegistry->register('current_category', $category);

        $page = $this->resultPageFactory->create();
        $page->getLayout()->getBlock('page.main.title')->setPageTitle(__($this->helperData->getGeneralConfig('title')));

        $page->getConfig()->addBodyClass('page-products');
        $page->getConfig()->getTitle()->set(__('BEST SELLER'));
        $page->getConfig()->setDescription(__('BEST SELLER'));
        $page->getConfig()->setKeywords(__('BEST SELLER'));
        $page->getConfig()->addRemotePageAsset($this->_url->getUrl('team2/product/onepage'), 'canonical', ['attributes' => ['rel' => 'canonical']]);

        return $page;
    }
}
