<?php
namespace fec\helpers;
use Yii;
class CCache{
	
	const ALL_ROLE_KEY_CACHE_HANDLE  = 'all_role_key_cache';  # 菜单role cache
	# 得到cache 组件。
	public static function cacheM(){
		return Yii::$app->cache;
	}
	
	# 1.得到 cache
	public static function get($handle){
		$cache = self::cacheM();
		return $cache->get($handle);
	}
	
	# 2.设置 cache
	public static function set($handle,$data,$timeout=0){
		
		$cache = self::cacheM();
		if($timeout)
			return $cache->set($handle,$data,$timeout);
		return $cache->set($handle,$data);
		
	}

	# 3.刷新 Cache
	public static function flushAll(){
		$cache = self::cacheM();
		$cache->flush();
	}
	
	
	
}