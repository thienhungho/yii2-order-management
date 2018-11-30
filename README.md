Yii2 Order Management System
====================
Order Management System for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist thienhungho/yii2-order-management "*"
```

or add

```
"thienhungho/yii2-order-management": "*"
```

to the require section of your `composer.json` file.

Config
------------

Add module OrderManage to your `AppConfig` file.

```php
...
'modules'          => [
    ...
    /**
     * Order Manage
     */
    'order-manage' => [
        'class' => 'thienhungho\OrderManagement\modules\OrderManage\OrderManage',
    ],
    /**
     * My Order
     */
    'my-order' => [
        'class' => 'thienhungho\OrderManagement\modules\MyOrder\MyOrder',
    ],
    ...
],
...
```

### Migration

Run the following command in Terminal for database migration:

```
yii migrate/up --migrationPath=@vendor/thienhungho/yii2-order-management/migrations
```

Or use the [namespaced migration](http://www.yiiframework.com/doc-2.0/guide-db-migrations.html#namespaced-migrations) (requires at least Yii 2.0.10):

```php
// Add namespace to console config:
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationNamespaces' => [
            'thienhungho\OrderManagement\migrations\namespaced',
        ],
    ],
],
```

Then run:
```
yii migrate/up
```

Modules
------------

[OrderBase](https://github.com/thienhungho/yii2-order-management/tree/master/src/modules/OrderBase), [OrderManage](https://github.com/thienhungho/yii2-order-management/tree/master/src/modules/OrderManage), [MyOrder](https://github.com/thienhungho/yii2-order-management/tree/master/src/modules/MyOrder), 

Functions
------------

[Core](https://github.com/thienhungho/yii2-order-management/tree/master/src/functions/core.php)

Constant
------------

[Core](https://github.com/thienhungho/yii2-order-management/tree/master/src/const/core.php)

Models
------------

[Order](https://github.com/thienhungho/yii2-order-management/tree/master/src/models/Order.php), [OrderItem](https://github.com/thienhungho/yii2-order-management/tree/master/src/models/OrderItem.php), 