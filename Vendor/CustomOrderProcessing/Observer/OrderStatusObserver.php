<?php
namespace Vendor\CustomOrderProcessing\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;

class OrderStatusObserver implements ObserverInterface
{
    protected $resource;
    protected $transportBuilder;
    protected $storeManager;

    public function __construct(
        ResourceConnection $resource,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $oldStatus = $order->getOrigData('status');
        $newStatus = $order->getStatus();

        if ($oldStatus === $newStatus) {
            return;
        }

        // Insert into custom log table
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('custom_order_status_log');

        $connection->insert($tableName, [
            'order_id' => $order->getEntityId(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_at' => (new \DateTime())->format('Y-m-d H:i:s')
        ]);

        // Send email if status is shipped
        if ($newStatus == 'shipped') {
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('custom_order_shipped_email_template') // Define in admin
                ->setTemplateOptions([
                    'area' => 'frontend',
                    'store' => $this->storeManager->getStore()->getId()
                ])
                ->setTemplateVars(['order' => $order])
                ->setFrom(['email' => "sales@example.com", 'name' => "Sales"])
                ->addTo($order->getCustomerEmail())
                ->getTransport();
            $transport->sendMessage();
        }
    }
}
