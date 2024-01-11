<?php
namespace Vendor\Module\Cron;

use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;

class OutOfStockCron
{
    protected $logger;
    protected $productCollectionFactory;
    protected $stockItemRepository;

    public function __construct(
        LoggerInterface $logger,
        CollectionFactory $productCollectionFactory,
        StockItemRepository $stockItemRepository
    ) {
        $this->logger = $logger;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->stockItemRepository = $stockItemRepository;
    }

    public function execute()
    {//var_dump('hi');exit;
        $this->logger->info("Cron job started at " . date('Y-m-d H:i:s'));
        try {
            $this->logger->info("Out of Stock Products:");

            // Get out-of-stock products
            $productCollection = $this->productCollectionFactory->create();
            $productCollection->addAttributeToSelect('*');
            $productCollection->joinField(
                'qty',
                'cataloginventory_stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left'
            );
            $productCollection->addFieldToFilter('qty', ['eq' => 0]);

            // Log out-of-stock product information
            foreach ($productCollection as $product) {
                $productId = $product->getId();
                $productName = $product->getName();
               
                $this->logger->info("Product ID: $productId, Product Name: $productName");
            }

            $this->logger->info("Cron job executed successfully.");
        } catch (\Exception $e) {
            $this->logger->error("Error in cron job: " . $e->getMessage());
        }
    }

}
