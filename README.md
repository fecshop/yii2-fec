Yii2 Fancy Ecommerce  (FEC)
=========


github: https://github.com/fancyecommerce/yii2-fec

[![Latest Stable Version](https://poser.pugx.org/myweishanli/yii2-extjs-rbac/v/stable.png)](https://github.com/fancyecommerce/yii2-fec)
[![Total Downloads](https://poser.pugx.org/myweishanli/yii2-extjs-rbac/downloads.png)](https://github.com/fancyecommerce/yii2-fec)

> 注: 功能正在开发中...

> 更详细的配置说明文档正在编写中...

> QQ: 2358269014

> 有任何疑问可以发邮件到 2358269014@qq.com

---
有任何建议或者需求欢迎来反馈 [issues](../../issues)

欢迎点击右上方的 star 收藏

fork 参与开发，欢迎提交 Pull Requests，然后 Pull Request

---

1、安装
------------

安装这个扩展的首选方式是通过 [composer](http://getcomposer.org/download/).

执行

```
composer require --prefer-dist fancyecommerce/yii2-fec
```
或添加

```
"fancyecommerce/yii2-fec": "~1.0.0"
```

2、使用
------------


调用
```php
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






Demo
------------

demo地址: http://backend.yii.drupecms.com/

帐号: drupecms

密码: drupecms


