<?php
namespace Vendor\CustomOrderProcessing\Api;

interface OrderStatusUpdateInterface {
    /**
     * Update order status via API
     * @param string $orderIncrementId
     * @param string $newStatus
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute($orderIncrementId, $newStatus);
}