<?php
namespace fec\helpers;
use Yii; 
use yii\captcha\Captcha;
/*

echo fec\helpers\CCaptcha::widget([
				'name' => 'captcha',
				'class' => Captcha::className(),
		]);

*/
class CCaptcha extends Captcha
{
	public $captchaAction = '/fecadmin/captcha/index';
	
	
}

