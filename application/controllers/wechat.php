<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wechat extends CI_Controller {

	public function wechat_info_list()
	{
		$this->smarty->display("wechat/wechat_info_list.htm");
	}

	public function get_wechat_info_list(){
		$search_theme = $this->input->post('search_theme');
		$wheres = array();
		if (!empty($search_theme))
		{
			$wheres[] = "theme LIKE '%".$search_theme."%'";
		}
		$where = implode(",",$wheres);

		list($page, $limit, $sort, $order) = get_list_param();
		$this->load->model("wechat_model");
		$responce = $this->wechat_model->get_wechat_info_list($page, $limit, $sort, $order,$where);
		$this->load->library("json");
		echo $this->json->encode($responce);
	}




}