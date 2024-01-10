<?php
namespace Vendor\Module\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;

class Log404Observer implements ObserverInterface
{
    protected $logger;
    protected $resourceConnection;

    public function __construct(
        LoggerInterface $logger,
        ResourceConnection $resourceConnection
    ) {
        $this->logger = $logger;
        $this->resourceConnection = $resourceConnection;
    }

    public function execute(Observer $observer)
    {
        $response = $observer->getEvent()->getData('response');

        // Ensure the response object is available
        if ($response && $response instanceof \Magento\Framework\App\Response\Http) {
            $statusCode = $response->getHttpResponseCode();

            if ($statusCode == 404) {
                $request = $observer->getEvent()->getData('request');
                $uri = $request->getUriString();

                // Log the URL to the database
                $this->logAttemptedUrl($uri);
            }
        }
    }

    protected function logAttemptedUrl($url)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $connection->getTableName('log_404_logs');

        $select = $connection->select()
            ->from($tableName)
            ->where('url = ?', $url);

        $row = $connection->fetchRow($select);

        if ($row) {
            // URL already exists, update the attempt count
            $connection->update(
                $tableName,
                ['attempt_count' => $row['attempt_count'] + 1],
                ['id = ?' => $row['id']]
            );
        } else {
            // URL does not exist, insert a new record
            $connection->insert(
                $tableName,
                ['url' => $url, 'attempt_count' => 1]
            );
        }
    }
}
