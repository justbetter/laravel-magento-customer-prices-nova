# Upgrade guide

## 4.2.x to 4.3.x

The 4.3.x release adds support for `justbetter/laravel-magento-customer-prices` version `^3.0`.

### Refactor

A few classes like the resource have been renamed. The resource `CustomerPrice` is now `CustomerPriceResource`. Make sure to update all references if you make use of it manually.
