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
/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CDB
{	
	
	
	public static $db;
	
	# 1.得到当前的db
	public static function getDb($db_name = 'db'){
		if(!self::$db){
			if(!$db_name){
				$db_name = 'db';
			}
			self::$db = Yii::$app->$db_name;
		}
		return self::$db;
	}
	

	# 1.通过sql查看所有的记录
	# example:  CDB::findBySql('select * from sales_order_info where order_id > :order_id'
	#							,[':order_id'=>1 ]);
	public static function findAllBySql($sql,$data=[],$db_name=''){
		# example: $sql = 'SELECT * FROM  sales_flat_quote';
		$db = self::getDb($db_name);
		$result = $db->createCommand($sql,$data)
					->queryAll();
		return $result;
	}
	
	
	
	# 2.通过sql查看一条记录
	# example: CDB::findOneBySql('select * from sales_order_info where order_id = :order_id'
	#							,[':order_id'=>1 ]);
	public static function findOneBySql($sql,$data=[],$db_name=''){
		# example: $sql ='SELECT * FROM post WHERE id=1'
		$db = self::getDb($db_name);
		$result = $db->createCommand($sql,$data)
				->queryOne();
		return $result;
	}
	
	# 3.通过sql插入记录
	# $sql 	= "insert into sales_order_info (increment_id) values (:increment_id) ";
	# $data = ['increment_id'=>'eeeeeeeeee'];
	# $dd 	= DB::insertBySql($sql,$data);
	public static function insertBySql($sql,$data=[],$db_name=''){
		$db = self::getDb($db_name);
		$result = $db->createCommand($sql,$data)
				->execute();
		return $result;
	
	}
	
	# 4.通过sql更新
	# $sql = "update sales_order_info set increment_id = :iid where increment_id = :increment_id";
	# $data = ['iid'=>'ddd','increment_id'=>'eeeeeeeeee'];
	# $dd = DB::insertBySql($sql,$data);
	public static function updateBySql($sql,$data=[],$db_name=''){
		$db = self::getDb($db_name);
		$result = $db->createCommand($sql,$data)
				->execute();
		return $result;
	
	}
	
	# 5.通过sql删除
	# $sql = "delete from sales_order_info  where increment_id = :increment_id";
	# $data = ['increment_id'=>'eeeeeeeeee'];
	# $dd = DB::insertBySql($sql,$data);
	public static function deleteBySql($sql,$data=[],$db_name=''){
		$db = self::getDb($db_name);
		$result = $db->createCommand($sql,$data)
				->execute();
		return $result;
	
	}
	
	# 6.批量插入数据方式
	# $table 		= 'sales_order_info';
	# $columnsArr = ['increment_id','order_status'];
	# $valueArr 	= [
	# 				['Tom', 30],
	# 				['Jane', 20],
	# 				['Linda', 25]
	# 				];
	# DB::batchInsert($table,$columnsArr,$valueArr);
		
	public static function batchInsert($table,$columnsArr,$valueArr,$db_name=''){
		$db = self::getDb($db_name);
		$db->createCommand()
					->batchInsert($table,$columnsArr,$valueArr)
					->execute();
	
	}
	
	
	# 一：常见操作-数据表查询
	/*
	@单一查询，返回是一个对象，可通过数组的形式调用 $customer['quote_id'];
		还可以通过属性的方式 $customer->quote_id;
		$customer = Customer::findOne(['customer_id' => (int)$customer_id]);
	
	@全部查询：返回的是对象
		$customers = Customer::find()
			->where(['status' => Customer::STATUS_ACTIVE])
			->orderBy('id')
			->all();
	@全部查询：返回的是数组  (查询100-109行)
		$customers = Customer::find()
			->asArray()
			->where(['status' => Customer::STATUS_ACTIVE])
			->orderBy(['id' => SORT_ASC,'name' => SORT_DESC])
			->limit(10)
			->offset(100)
			->all();
	@查询个数：
		$count = Customer::find()
			->where(['status' => Customer::STATUS_ACTIVE])
			->count();
	@以id为索引的方式查询
		$customers = Customer::find()->indexBy('id')->all();
		
	@用原生的sql查询：（只能针对这一个表）
		$sql = 'SELECT * FROM customer';
		$customers = Customer::findBySql($sql)->all();	
		
	@批量获取数据（不常用，针对大数据）
		一次提取 10 个客户信息
		foreach (Customer::find()->batch(10) as $customers) {
			$customers 是 10 个或更少的客户对象的数组
		}
		一次提取 10 个客户并一个一个地遍历处理
		foreach (Customer::find()->each(10) as $customer) {
			$customer 是一个 ”Customer“ 对象
		}
		贪婪加载模式的批处理查询
		foreach (Customer::find()->with('orders')->each() as $customer) {
		}
	*/
	
	
	# 常见操作2:数据表插入
	/*
	@插入新客户的记录
		$customer = new Customer();
		$customer->name = 'James';
		$customer->email = 'james@example.com';
		//等同于 $customer->insert();
		$customer->save();  
	
	@通过post数组的方式赋值
		$model = new Customer;
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
		}
		####由于AR继承自yii\base\Model，所以它同样也支持Model的数据输入、验证等特性。例如，你可以声明一个rules方法用来覆盖掉yii\base\Model::rules()里的；你也可以给AR实例批量赋值；你也可以通过调用yii\base\Model::validate()执行数据验证。
		####当你调用 save()、insert()、update() 这三个方法时，会自动调用yii\base\Model::validate()方法。如果验证失败，数据将不会保存进数据库。
	
	*/
	
	# 常见操作3:数据表更新
	/*
	@更新现有客户记录
		$customer = Customer::findOne(['id' => 1]);
		$customer->email = 'james@example.com';
		//等同于 $customer->update();
		$customer->save();  
		
	@所有客户的age（年龄）字段加1：
		Customer::updateAllCounters(['age' => 1]);		
	*/
	
	
	# 常见操作4：数据表数据删除
	/*
	@删除已有客户记录
		$customer = Customer::findOne(['id' => 1]);
		$customer->delete();

	@删除多个年龄大于20，性别为男（Male）的客户记录
		Customer::deleteAll('age > :age AND gender = :gender', [':age' => 20, ':gender' => 'M']);
			
			
	*/
	
	# 常见操作5：读取默认值
	/*
	
		你的表列也许定义了默认值。有时候，你可能需要在使用web表单的时候给AR预设一些值。
		如果你需要这样做，可以在显示表单内容前通过调用
		loadDefaultValues()方法来实现： 
		php $customer = new Customer();
		$customer->loadDefaultValues(); // ... 渲染 $customer 的 HTML 表单 ... `
	*/
	
	/*
	 常见操作6：事务操作
		# 开始事务
		$innerTransaction = Yii::$app->db->beginTransaction();
		try {
			$innerTransaction->commit();
		} catch (Exception $e) {
			$innerTransaction->rollBack();
		}
	
	*/
	
	 
	/*
	各种条件查询。 
	# where
    where('status=1') 
    where('status=:status', [':status' => $status])
    where([  
        'status' => 10,  
        'type' => null,  
        'id' => [4, 8, 15],  
    ]) 
    -------  
    $userQuery = (new Query())->select('id')->from('user');  
    // ...WHERE `id` IN (SELECT `id` FROM `user`)  
    $query->...->where(['id' => $userQuery])->...  
    --------  
    ['and', 'id=1', 'id=2'] //id=1 AND id=2  
    ['and', 'type=1', ['or', 'id=1', 'id=2']] //type=1 AND (id=1 OR id=2)  
    ['between', 'id', 1, 10] //id BETWEEN 1 AND 10  
    ['not between', 'id', 1, 10] //not id BETWEEN 1 AND 10  
    ['in', 'id', [1, 2, 3]] //id IN (1, 2, 3)  
    ['not in', 'id', [1, 2, 3]] //not id IN (1, 2, 3)  
    ['like', 'name', 'tester'] //name LIKE '%tester%'  
    ['like', 'name', ['test', 'sample']] //name LIKE '%test%' AND name LIKE '%sample%'  
    ['not like', 'name', ['or', 'test', 'sample']] //not name LIKE '%test%' OR not name LIKE '%sample%'  
    ['exists','id', $userQuery] //EXISTS (sub-query) | not exists  
    ['>', 'age', 10] //age>10  
	
	得到刚插入的id
	order_id = Yii::$app->db->getLastInsertID();
	
	$sql = 'SELECT * FROM  sales_flat_quote';
	Yii::$app->db->createCommand($sql,[])
					->queryAll();
		
		
	*/
	
}















