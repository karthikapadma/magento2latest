<?php
declare(strict_types=1);
namespace Vendor\Module\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Store\Model\Store;

class CreateCmsPage implements DataPatchInterface, PatchRevertableInterface
{
    const CMS_PAGE_IDENTIFIER = 'sample-cms-page11';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory

    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;

    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();


        // Append the relative path to the image



//var_dump( $imageUrl);exit;
        $this->pageFactory->create()
            ->setTitle('Sample CMS Page')
            ->setIdentifier(self::CMS_PAGE_IDENTIFIER)
            ->setIsActive(true)
            ->setPageLayout('1column')
            ->setContent('<div>Sample CMS Page Contents. <img src="<?php echo $this->getViewFileUrl(\'Vendor_Module::images/image.jpg\'); ?>" alt="Your Image"></div>')
            ->save();

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {
        $sampleCmsPage = $this->pageFactory
            ->create()
            ->load(self::CMS_PAGE_IDENTIFIER, 'identifier');

        if ($sampleCmsPage->getId()) {
            $sampleCmsPage->delete();
        }
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}