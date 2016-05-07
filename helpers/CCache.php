<?php
namespace fec\helpers;
use Yii;
class CCache{
	
	const ALL_ROLE_KEY_CACHE_HANDLE  = 'all_role_key_cache';  # 菜单role cache
	# 得到cache 组件。
	public static function cacheM(){
		return Yii::$app->cache;
	}
	
	# 得到 data  cache
	public static function get($handle){
		$cache = self::cacheM();
		return $cache->get($handle);
	}
	
	# 设置 data  cache
	public static function set($handle,$data){
		
		$cache = self::cacheM();
		return $cache->set($handle,$data);
		
	}

	# 刷新 Data  Cache
	public static function flushAll(){
		$cache = self::cacheM();
		$cache->flush();
	}
	
	
	
}