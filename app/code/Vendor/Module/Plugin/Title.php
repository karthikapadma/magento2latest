<?php
namespace Vendor\Module\Plugin;
class Title
{
    protected $storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    public function beforeSet(\Magento\Framework\View\Page\Title $subject, $title)
    {
        $websiteName = $this->storeManager->getStore()->getWebsite()->getName();
        $title = $title ? $title . ' - ' . 'latest.magento.com' : $websiteName;

        return [$title];
    }
}