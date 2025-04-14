<?php
namespace Vendor\CustomOrderProcessing\Controller\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderStatusUpdate implements \Vendor\CustomOrderProcessing\Api\OrderStatusUpdateInterface {
    protected $orderRepository;
    protected $logger;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
    }

    public function execute($orderIncrementId, $newStatus) {
        $order = $this->orderRepository->get($orderIncrementId);
        $oldStatus = $order->getStatus();

        // Validate status transition (simplified example)
        $validTransitions = [
            'pending' => ['processing', 'canceled'],
            'processing' => ['complete', 'shipped'],
        ];
        if (!isset($validTransitions[$oldStatus]) || !in_array($newStatus, $validTransitions[$oldStatus])) {
            throw new LocalizedException(__('Invalid status transition from %1 to %2', $oldStatus, $newStatus));
        }

        $order->setStatus($newStatus);
        $this->orderRepository->save($order);
        $this->logger->info("Order status updated: {$orderIncrementId} from {$oldStatus} to {$newStatus}");
        return true;
    }
}