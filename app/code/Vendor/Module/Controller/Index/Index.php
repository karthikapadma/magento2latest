<?php
namespace Vendor\Module\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    /**
     * Logging instance
     * @var \Webkul\Modulename\Logger\Logger
     */
    protected $_logger;

    /**
     * @param Context $context
     * @param \Webkul\Modulename\Logger\Logger $logger
     */
    public function __construct(
        Context $context,
        \Webkul\Modulename\Logger\Logger $logger
    ) {
        $this->_logger = $logger;
        parent::__construct($context);
    }


    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $this->_logger->info(print_r($data)); // log array Data to customfile.log
        $this->_logger->info("Some text string data"); // log string Data to customfile.log
        //  Write Your Code Here
        return $this->resultRedirectFactory->create()->setPath('*/*/*');
    }
}