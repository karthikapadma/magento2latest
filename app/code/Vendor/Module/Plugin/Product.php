<?php
namespace Vendor\Module\Plugin;
use Magento\Catalog\Model\Product as MainProduct;
class Product
{
    protected $_storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    public function afterGetName(MainProduct $subject, $result)
    {
        $websiteName = $this->_storeManager->getStore()->getWebsite()->getName();
        $result = $websiteName . ' - ' . $result; // Append website name before product name
        return $result;
    }
}