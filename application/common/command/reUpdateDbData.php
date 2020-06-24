<?php
   namespace app\common\command;

   use think\console\Command;
    use think\console\Input;
    use think\console\input\Argument;
    use think\console\input\Option;
    use think\console\Output;

    class reUpdateDbData extends Command
    {
	protected function configure(){
	    $this->setName('CESHI');
	}
	protected function execute($input, $output)
	{  $return = $this->getKey(); 
	    $output->writeln('输出了：'.$return);
	}
	private function getKey()
	{
	   $redis = new \Redis();
	   $redis->connect('127.0.0.1',6381);
	   $userId = 1388;
	   $signStartTime = '2020-01-01';
	   $cacheKey = 'sign_'.$userId;
	   $offset = intval((time()-strtotime($signStartTime))/86400);
	    //$redis->setBit($cacheKey,$offset,1);
	   // $bitStatus = $redis->getBit($cacheKey,$offset);
	    //$signCount = $redis->bitCount($cacheKey);
	    //return $signCount;
	   //$key_value = $redis->get('name');
	   ///return $bitStatus;


	   //die;
	  // include_once  __DIR__.'/../../../my_vendor/DaemonCommand.php';
	$daemon=new \DaemonCommand(true);
	$daemon->daemonize();
	$daemon->start(2);//开启2个子进程工作
	echo '进程id:'.posix_getpid().";父进程：".posix_getppid().'\r\n';
	sleep(600);	

	}

    }
