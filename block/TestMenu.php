<?php
namespace fec\block;
use Yii;

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