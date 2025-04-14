<?php
namespace Vendor\CustomOrderProcessing\Controller\Order;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Vendor\CustomOrderProcessing\Api\OrderStatusInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class UpdateStatus extends Action
{
    protected $orderStatus;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        OrderStatusInterface $orderStatus,
        JsonFactory $resultJsonFactory
    ) {
        $this->orderStatus = $orderStatus;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        $orderId = $this->getRequest()->getParam('increment_id');
        $status = $this->getRequest()->getParam('status');

        try {
            $message = $this->orderStatus->updateStatus($orderId, $status);
            return $result->setData(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
