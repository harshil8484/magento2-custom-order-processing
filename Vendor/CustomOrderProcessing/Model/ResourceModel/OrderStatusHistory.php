<?php
namespace Vendor\CustomOrderProcessing\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderStatusHistory extends AbstractDb {
    protected function _construct() {
        $this->_init('vendor_order_status_history', 'entity_id');
    }
}