<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->smarty->display("index.htm");
	}

	public function workbench()
	{
		$this->smarty->assign("add",array('a'=>'b','a1'=>'b1','a2'=>'b2'));
		$this->smarty->display("a.html");
	}
}
