<?php

namespace Tweakwise\Magento2TweakwiseExport\Model\Write\Products;

use Tweakwise\Magento2TweakwiseExport\Model\ChildOptions;
use Tweakwise\Magento2TweakwiseExport\Model\Config;
use Magento\Catalog\Model\Product\Visibility;
use Magento\CatalogInventory\Api\StockConfigurationInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class ExportEntityChild extends ExportEntity
{
    /**
     * @var ChildOptions
     */
    protected $childOptions;

    /**
     * @var Config
     */
    protected $config;

    /**
     * ExportEntityChild constructor.
     * @param Config $config
     * @param Store $store
     * @param StoreManagerInterface $storeManager
     * @param StockConfigurationInterface $stockConfiguration
     * @param Visibility $visibility
     * @param array $data
     */
    public function __construct(
        Config $config,
        Store $store,
        StoreManagerInterface $storeManager,
        StockConfigurationInterface $stockConfiguration,
        Visibility $visibility,
        array $data = []
    ) {
        parent::__construct(
            $store,
            $storeManager,
            $stockConfiguration,
            $visibility,
            $data
        );

        $this->config = $config;
    }

    /**
     * @return ChildOptions
     */
    public function getChildOptions(): ?ChildOptions
    {
        return $this->childOptions;
    }

    /**
     * @param ChildOptions $childOptions
     */
    public function setChildOptions(ChildOptions $childOptions): void
    {
        $this->childOptions = $childOptions;
    }

    /**
     * @return bool
     */
    public function shouldExport(): bool
    {
        return $this->shouldExportByStock()
            && $this->shouldExportByStatus() &&
            $this->shouldExportByWebsite();
    }

    /**
     * @return bool
     */
    public function shouldExportByStock(): bool
    {
        if ($this->config->isOutOfStockChildren()) {
            return true;
        }

        return $this->isInStock();
    }
}
