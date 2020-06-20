<?php
namespace app\index\controller;
use think\Model;
class Index
{
    public function index()
    
    {
    //file_put_contents('1.txt',1,8);die;
    $this->redis = new \Redis();
    $this->redis->connect('127.0.0.1','6381');
    $stock = $this->redis->get('goods_100_nums');
    //print_r($this->redis->lastsave());
    //生成一个唯一的随机数



    $a = $this->redis->set('lock','11',array('nx','ex'=>100));
    $ttl = $this->redis->ttl('lock');
    var_dump($ttl);
    if($stock > 0){
	
    }


    exit;







	
	$db = \Db::name('testing');
	
	$info = $db->select();
	var_dump($info);die;
	$cout = $info[0]['code'];
	var_dump($cout);die;
	if($info && $cout>0){
	    $num = $cout - 1;
	    #$db->update(array('id'=>10,'code'=>$num));
	    
	    file_put_contents('1.txt','抢购成功,现在库存：'.$cout."\r\n",8);
	    $db->query('update testing set code='.$num.' where id=10');
	}else{
	    file_put_contents('1.txt','抢购失败,现在库存：'.$cout."\r\n",8);
	}
	return;
	$option = [
	    'host'=>'127.0.0.1',
	    'port'=>'6381',
	
	];
	$redis = new \think\cache\driver\Redis($option);
	//var_dump($redis);die;
	$num = $redis->get('num');
	if($num>0){
	    $redis->dec('num');
	}
return;	
	$redis->inc('num');
	//echo $redis->get('name'); 
    }
    
    private function useRedis(){
    	$option = [
	    'host'=>'127.0.0.1',
	    'port'=>'6381',
	
	];
    $redis = new \think\cache\driver\Redis($option);
	$lock_res = $redis->setnx('lock',1);
	if($lock_res){
	    $num = $redis->get('num');
	    sleep(1);
	    if($num>0){
		file_put_contents('3.txt','success,kucun:'.$num."\r\n",8);
		$redis->dec('num');
	    }else{
	       file_put_contents('3.txt','failure,kucun:'.$num."\r\n",8);
	    }
	}else{
		file_put_contents('3.txt','活动太诱人，请稍后再试,kucun:'."\r\n",8);

	}

    }


    }
