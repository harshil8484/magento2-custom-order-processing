# Vendor_CustomOrderProcessing - Magento 2 Module

![Magento 2](https://img.shields.io/badge/Magento-2.4%2B-brightgreen)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)
![License](https://img.shields.io/badge/License-OSL-3.0-lightgrey)

Enhances Magento 2 order processing with REST API, status logging, and Hyva theme support.

## 📌 Table of Contents

- [Features](#-features)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Testing](#-testing)
- [Architecture](#-architecture)
- [Troubleshooting](#-troubleshooting)
- [License](#-license)

## 🌟 Features

- **REST API** for updating order statuses
- **Status change logging** to database
- **Email notifications** for shipped orders
- **Admin interface** for viewing history
- **Hyva theme** compatibility
- **100% PSR-4 compliant**

## 🚀 Installation

### Prerequisites

- Magento 2.4.x
- PHP 7.4+
- MySQL 5.7+
- Composer

### Steps

bin/magento module:enable Vendor_CustomOrderProcessing
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
