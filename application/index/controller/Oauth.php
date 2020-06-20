<?php
namespace app\index\controller;
class Oauth extends \think\Controller
{
    public function getToken()
    {
	$return = array('code'=>'2322dds232','expire'=>3600);
	return json($return); 
    }
}
