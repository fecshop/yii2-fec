Yii2 Fancy Ecommerce  (FEC)
=========


github: https://github.com/fancyecommerce/yii2-fec

[![Latest Stable Version](https://poser.pugx.org/fancyecommerce/fec/v/stable)](https://packagist.org/packages/fancyecommerce/fec) [![Total Downloads](https://poser.pugx.org/fancyecommerce/fec/downloads)](https://packagist.org/packages/fancyecommerce/fec) [![Latest Unstable Version](https://poser.pugx.org/fancyecommerce/fec/v/unstable)](https://packagist.org/packages/fancyecommerce/fec) [![License](https://poser.pugx.org/fancyecommerce/fec/license)](https://packagist.org/packages/fancyecommerce/fec)

> QQ: 2358269014

> 邮箱：2358269014@qq.com

---
有任何建议或者需求欢迎来反馈 [issues](../../issues)

欢迎点击右上方的 star 收藏

---

1、安装
------------

安装这个扩展的首选方式是通过 [composer](http://getcomposer.org/download/).

执行

```
composer require --prefer-dist fancyecommerce/fec
```
或添加

```
"fancyecommerce/fec": "~1.1.2"
composer install
```

2、使用 CProflie
------------


调用
```php
<?php
use fec\helpers\CUrl;
use fec\helpers\CProfile;
class Menu{
	public static function getMenuData(){
		$obj_data = ["DMenu","Info",'getMenu',true];
		$men_arr = CProfile::getInstance()->fetch($obj_data);
		return $men_arr;
	}
```

配置：
```php
<?php
public function getModulesConfig(){
		return [
			
			'DMenu' => [
							'moduleDir' =>'\appdata\code\Blog\DMenu',
							'apiurl'  =>'http://120.24.37.249:100/dmenu',
							'token'  =>'xxxxxx',
						],	
		];
		
	}
```

数据来源：
```php
<?php
namespace appdata\code\Blog\DMenu\o;
use Yii;
class Info
{
	public static function getMenu($current_menu=''){
		$menuArr = self::getMenuArr();
		return json_encode($menuArr );
	}

```
远程：
```php
<?php
namespace appdata\code\Blog\DMenu\controllers;

use Yii;
use fec\controllers\ModulesapiController;
use fec\helpers\CUrl;
class InfoController extends ModulesapiController
{
  
	public $_name_space = __NAMESPACE__;
	
	
	
}
```


