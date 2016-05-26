Yii2 Fancy Ecommerce  (FEC)
=========


github: https://github.com/fancyecommerce/yii2-fec

[![Latest Stable Version](https://poser.pugx.org/fancyecommerce/fec/v/stable)](https://packagist.org/packages/fancyecommerce/fec) [![Total Downloads](https://poser.pugx.org/fancyecommerce/fec/downloads)](https://packagist.org/packages/fancyecommerce/fec) [![Latest Unstable Version](https://poser.pugx.org/fancyecommerce/fec/v/unstable)](https://packagist.org/packages/fancyecommerce/fec) [![License](https://poser.pugx.org/fancyecommerce/fec/license)](https://packagist.org/packages/fancyecommerce/fec)


> 更加详细的说明地址：http://www.fancyecommerce.com/category/yii2-%E6%8F%92%E4%BB%B6%E6%89%A9%E5%B1%95/

> QQ: 2358269014

> 有任何疑问可以发邮件到 2358269014@qq.com

1、安装
------------

安装这个扩展的首选方式是通过 [composer](http://getcomposer.org/download/).

执行

```
composer require --prefer-dist fancyecommerce/fec
```
或添加

```
"fancyecommerce/fec": "~1.0.0"
composer install
```

2、使用
------------

2.1 fec\helpers\xxxx ， 里面是一些常用的帮助类。
详细可以打开fec\helpers文件夹查看。

2.2 Redis Queue 队列的使用
在使用之前，您需要先进行配置如下：
```php
    'components' => [
          'queue' => [
              'class' => 'fec\component\RedisQueue',
          ],
      ],
      
      'controllerMap' => [
          'queue' => 'fec\component\redisqueue\QueueController'
      ],
```

详细的使用方法参看\fec\helper\CRedisQueue







