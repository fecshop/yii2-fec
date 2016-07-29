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
use  yii\captcha\CaptchaAction;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CCaptchaAction extends CaptchaAction
{
	public $minLength = 4;
	public $maxLength = 4;
	/**
     * Generates a new verification code.
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        if ($this->minLength < 3) {
            $this->minLength = 3;
        }
        if ($this->maxLength > 20) {
            $this->maxLength = 20;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        $letters = [0,1,2,3,4,5,6,7,8,9];
        return array_rand($letters).array_rand($letters).array_rand($letters).array_rand($letters);
		//$vowels = '01234';
        //$code = '';
       // for ($i = 0; $i < $length; ++$i) {
            //if ($i % 2 && mt_rand(0, 10) > 2 || !($i % 2) && mt_rand(0, 10) > 9) {
            //    $code .= $vowels[mt_rand(0, 4)];
            //} else {
               // $code .= $letters[mt_rand(0, 20)];
           // }
       // }

        //return $code;
    }
}
