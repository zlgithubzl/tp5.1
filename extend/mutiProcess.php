<?php
    class mutiProcess
    {


	private $signal_handlers = [];
	private $cid = 0;
	private $all_cid = [];  //所有的子进程
	/**
	 *fork进程
	 *
	 */
	public function run($child_num){

	    pcntl_signal_dispatch();

	    cli_set_process_title("aaa");
	    $p_pname = cli_get_process_title();

	    pcntl_signal_dispatch();
	   $pid =  pcntl_fork();
	   $this->all_cid[] = $pid;
	   if($pid == -1){
	     exit('fork failed');//此处可以优化为自定义异常
	   }elseif($pid>0){
    	    $this->cid = $pid;
    	    $this->isRunning = true;    //  子进程状态
           //由主进程循环while调用wait来进行子进程回收优化为信号通知回收(探究可行性，子进程异常退出会通知主进程吗？？)。
            pcntl_signal();
            pcntl_signal();
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

        public function MasterSignalHandler($signal,$callback){
            $this->signal_handlers[$signal] = $callback;
        }

	/**If you have signal need to handle,you should call this funciton 子进程
	 * before you operate run function.
	 *@param $signal 信号
	 *@param $callback 信号处理函数
	 */
	public function registerSignalHandler($signal,$callback){
	    $this->signal_handlers[$signal] = $callback;
	}

//	private function signalHandler()
//	{
//	    	if(){
//
//            }
//	}

	/**循环来检查子进程状态。（看是否可以优化为信号通知给主进程来对子进程回收）
	 *@param  bool|true $block
	 *@param  int $usleep   休眠的秒数
	 *
	 */
	public function wait($block=true,$usleep = 1000)
	{
	    while(true){
	        if($this->isRunning === false){
	            return; //  子进程已经退出。疑问：那如果是fork了多个进程，如果此时主进程退出了，那岂不是只是回收了一个子进程，其他几个子进程成为了孤儿进程？？？
            }
            $this->checkChildStatus($block);
	        usleep($usleep);
        }
	}

        /**
         * @param bool $block
         */
	private function checkChildStatus($block){
        if(true === $block){
            $res = pcntl_waitpid($this->cid,$status);
        }else{
            $res = pcntl_waitpid($this->cid, $status,WNOHANG|WUNTRACED);
        }
        if($res > 0){//代表已经回收了子进程cid
            $this->getChildStatus($res,$status);
        }
    }


	private function getChildStatus($pid,$status){
        if(false === pcntl_wifexited($status)){
            echo '子进程：'.$pid.'异常退出，错误代码'.pcntl_wexitstatus($status)."\r\n";
        }elseif(true === pcntl_wifsignaled()){
            echo '子进程：'.$pid.'因为信号：'.pcntl_wtermsig($status).'而退出'."\r\n";
        }elseif(true === pcntl_wifstopped()){
            echo '子进程：'.$pid.'因为信号：'.pcntl_wstopsig($status).'而停止'."\r\n";
        }
        $this->isRunning = false;
    }
	
	

    }
