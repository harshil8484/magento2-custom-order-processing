# **⚠️ Note: I am a Magento frontend developer with limited backend knowledge, but I have made every effort to complete this assessment as per the instructions. Thank you!**

# Vendor_CustomOrderProcessing

This module provides a custom order processing enhancement for Magento 2 with features such as a custom REST API, order status logging, and email notifications when an order is marked as "shipped".

## ✅ Features

- REST API to update order status via external systems
- Event observer to log order status changes
- Sends email notification when status is set to "shipped"
- Built with Magento best practices (DI, Repositories, no ObjectManager)

---

## 🔧 Installation & Setup

1. Copy the module to:

2. Run setup commands:
```bash
php bin/magento module:enable Vendor_CustomOrderProcessing
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush


🔌 REST API Endpoint
Method: POST
URL: /rest/V1/custom-order/update-status
Auth: Bearer Token (Admin or Integration token)

{
  "increment_id": "100000001",
  "status": "processing"
}


Optional Web Controller for Testing
http://<your-magento-site>/customorder/order/updatestatus?increment_id=100000001&status=processing


Email Notification
When an order's status is changed to shipped, an email is sent to the customer using the custom_order_shipped_email_template defined in:
