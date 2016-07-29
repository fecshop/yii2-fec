<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fec\block;
use Yii;
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class TestMenu
{
	public $terry1;
	public $terry2;
	
    public function getLastData()
    {
        $arr = [
			'terry1' =>$this->terry1,
			'terry2' =>$this->terry2,
		];
        return $arr;
    }
} 