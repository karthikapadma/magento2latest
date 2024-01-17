<?php
namespace Vendor\Module\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Vendor\Module\Api\Data\ViewInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;


/**
 * Class View
 * @package Vendor\Module\Model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class View extends AbstractModel implements ViewInterface, IdentityInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'Vendor_module_view';

    /**
     * @var ResourceConnection
     */
    protected $logger;
    protected $resourceConnection;

    /**
     * View constructor.
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        LoggerInterface $logger,
        ResourceConnection $resourceConnection
    ) {
        $this->logger = $logger;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Post Initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Vendor\Module\Model\ResourceModel\View');
    }


    public function logAttemptedUrl($url)
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
                ['count' => $row['count'] + 1],
                ['entity_id = ?' => $row['entity_id']]
            );
        } else {
            // URL does not exist, insert a new record
            $connection->insert(
                $tableName,
                ['url' => $url, 'count' => 1]
            );
        }
    }
    
    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    
    public function getCount()
    {
        return $this->getData(self::COUNT);
    }

    

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Return identities
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    
    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }

   
    public function setCount($count)
    {
        return $this->setData(self::COUNT, $count);
    }

   
    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}