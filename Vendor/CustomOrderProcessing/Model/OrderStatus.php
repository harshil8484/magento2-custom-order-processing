<?php
namespace Vendor\CustomOrderProcessing\Model;

use Vendor\CustomOrderProcessing\Api\OrderStatusInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\Order;

class OrderStatus implements OrderStatusInterface
{
    protected $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function updateStatus($incrementId, $status)
    {
        $order = $this->orderRepository->get($incrementId);
        if (!$order->getId()) {
            throw new LocalizedException(__('Order not found.'));
        }

        $validStatuses = $order->getStatusHistories(); // You can add custom validation here
        $order->setStatus($status);
        $order->addStatusToHistory($status, __('Status updated via API'));
        $this->orderRepository->save($order);

        return "Order status updated successfully.";
    }
}
