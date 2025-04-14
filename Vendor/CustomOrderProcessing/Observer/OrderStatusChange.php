<?php
namespace Vendor\CustomOrderProcessing\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Vendor\CustomOrderProcessing\Model\OrderStatusHistory;

class OrderStatusChange implements ObserverInterface {
    protected $orderStatusHistory;
    protected $emailSender;

    public function __construct(
        OrderStatusHistory $orderStatusHistory,
        \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $emailSender
    ) {
        $this->orderStatusHistory = $orderStatusHistory;
        $this->emailSender = $emailSender;
    }

    public function execute(Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $oldStatus = $order->getOrigData('status');
        $newStatus = $order->getStatus();

        // Log to DB
        $this->orderStatusHistory->log($order->getId(), $oldStatus, $newStatus);

        // Send email if shipped
        if ($newStatus === 'shipped') {
            $this->emailSender->send($order);
        }
    }
}