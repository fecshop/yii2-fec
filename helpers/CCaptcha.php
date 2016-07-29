<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fec\helpers;
use Yii; 
use yii\captcha\Captcha;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CCaptcha extends Captcha
{ 
	public $captchaAction = '/fecadmin/captcha/index';
	
	
}

