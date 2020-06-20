<?php
namespace app\admin\controller;
use think\Model;
use think\facade\Cache;

class Order
{
	private $product_db;
	private $order_db;
	//static $redis_conf = array('host'=>'127.0.0.1','port'=>'6381');

    public function __construct(){
	$this->product_db = \Db::name('ms_goods');
	$this->order_db	  = \Db::name('order_info');
	$this->miaosha_order_db = \Db::name('ms_order');
	$this->logs_db	  = \Db::name('my_buy_logs');
	$this->now = date('H:i:s',time());
	//$this->redis = Cache::store('redis');	
	$this->redis = new \Redis();
	$this->redis->connect('127.0.0.1','6381');
    }
    public function createOrder()
    {

echo 543;die;
	$user_id = rand(1,20000);
	$p_id	 = rand(1,4);
	
	$name = $this->redis->get('name');
	echo 2;die;
	$p_info = $this->product_db->alias('a')->leftjoin(['goods'=>'b'],'a.goods_id=b.id')->where('b.id',$p_id)->select();
	
	$name = $p_info[0]['goods_name'];
	$order_info = array(
	    'user_id'=>$user_id,
	    'goods_id' => $p_id,
	    'goods_name' => $name,
	    'goods_count'=>1,
	    'order_channel'=>1,
	    'status'=>0,
	    'create_date'=>date('Y-m-d H:i:s',time()),
	);
	$order_id = $this->order_db->insert($order_info);//¿¿¿¿¿
	//$this->
	 
    }
    /**
     *	author long_zhao
     *@para
     *
     */
    public function decStock($p_id){
	$this->product_db->update(array('stock_count'=>"`stock_count`-1"),"mid=$p_id");
    
    }
    
}
