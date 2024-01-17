<?php
namespace Vendor\Module\Model\ResourceModel\View;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Remittance File Collection Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Vendor\Module\Model\View::class, \Vendor\Module\Model\ResourceModel\View::class);
    }
}