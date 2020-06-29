<?php
    class mutiProcess
    {


	private $signal_handlers = [];
	
	/**
	 *fork进程
	 *
	 */
	public function run($child_num){
	    cli_set_process_title("aaa");
	    $p_pname = cli_get_process_title();

	    pcntl_signal_dispatch();
	   $pid =  pcntl_fork();
	   if($pid == -1){
	     exit('fork failed');//此处可以优化为自定义异常
	   }elseif($pid>0){
	   die;echo 2;
		exit(0);
		$this->wait(false);
		exit;
	   }else{
	    //子进程
           echo "子进程已启动\r\n";
	    $s_pname = $p_pname."_s_".$child_num;
	    cli_set_process_title($s_pname);//设置子进程名称
	    if($this->signal_handlers){
            foreach($this->signal_handlers as $signal=>$callback){
                pcntl_signal($signal,$callback);
            };
	    }
	    sleep(15);
	    echo '子进程：'.$s_pname.'马上退出，bye'."\r\n";
	    
	   }

	}


	/**If you have signal need to handle,you should call this funciton
	 * before you operate run function.
	 *@param $signal 信号
	 *@param $callback 信号处理函数
	 */
	public function registerSignalHandler($signal,$callback){
	    $this->signal_handlers[$signal] = $callback;
	}

	/**
	 *@param  bool|true $block
	 *
	 *
	 */
	public function wait($block=true)
	{
	    if(true === $block){
	        pcntl_wait($status);
        }else{
	        pcntl_wait($status,WNOHANG|WUNTRACED);
        }
        echo '父进程即将退出';
	}
	
	

    }
