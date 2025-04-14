<?php
namespace Vendor\CustomOrderProcessing\Model;

use Magento\Framework\Model\AbstractModel;
use Vendor\CustomOrderProcessing\Model\ResourceModel\OrderStatusHistory as ResourceModel;

class OrderStatusHistory extends AbstractModel {
    protected function _construct() {
        $this->_init(ResourceModel::class);
    }

    public function log($orderId, $oldStatus, $newStatus) {
        $this->setData([
            'order_id' => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ])->save();
    }
}