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
	    //$output->writeln('输出了：'.$return);
	}
	private function getKey()
	{
	   //$redis = new \Redis();
	   //$redis->connect('127.0.0.1',6381);
    	//$daemon=new \DaemonCommand(true);
	//$daemon->daemonize();
	//$daemon->start(2);//开启2个子进程工作
	//echo '进程id:'.posix_getpid().";父进程：".posix_getppid().'\r\n';
	//sleep(600);	
	$m = new \mutiProcess();
	$m->run(1);
	//$m->wait(false);

	}

    }
