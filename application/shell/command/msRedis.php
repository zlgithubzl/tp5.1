<?php
    namespace app\shell\command;
    use think\console\Command;
    use think\console\Input;
    use think\console\Output;
    use think\Db;

    class msRedis extends Command{
	protected function execute($input,$output){
	    $db = \Db::name('ms_goods');
	    $now = date('Y-m-d H:i:s',time());
	    $time = date('Y-m-d H:i:s',strtotime("$now +1 days"));
	    $ms_p = $db->where('start_date="'.$time.'"')->select();
	    //存入redis
	    $redis = new \Redis();
	    foreach($ms_p as $k=>$v){
		$redis->hset('ms_p_'.$v['id']);
		
	    }
	}

	protected function configure(){
	    parent::configure();
	    $this->setName('msRedis')->setDescription('this is testing script');
	}
    }
