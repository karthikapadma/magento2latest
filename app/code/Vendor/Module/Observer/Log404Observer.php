<?php
namespace Vendor\Module\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use  Vendor\Module\Model\View;

class Log404Observer implements ObserverInterface
{
    protected $logger;
    protected $resourceConnection;
    protected $viewModel;

    public function __construct(
        LoggerInterface $logger,
        ResourceConnection $resourceConnection,
        View $viewModel
    ) {
        $this->logger = $logger;
        $this->resourceConnection = $resourceConnection;
        $this->viewModel = $viewModel;
    }

    public function execute(Observer $observer)
    {
        $response = $observer->getEvent()->getData('response');

        // Ensure the response object is available
        if ($response && $response instanceof \Magento\Framework\App\Response\Http) {
            $statusCode = $response->getHttpResponseCode();

            if ($statusCode == 404) {
                $request = $observer->getEvent()->getData('request');
                $url = $request->getUriString();

                // Log the URL to the database
                $this->viewModel->logAttemptedUrl($url);
            }
        }
    }
}
