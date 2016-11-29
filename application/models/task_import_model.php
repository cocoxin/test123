<?php
/**
 * 批量数据导入类
 * 
 */
class Task_import_model extends CI_Model
{
	//进度临时文件
	private $_progress_file = '';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('array');
		$this->userId = $this->session->userdata('user_id');
		$this->deptId = $this->session->userdata('dept_id');
		$this->userName = $this->session->userdata('user_name');

		$this->syncClient = 1 ;//同步修改CRM客户数据
		$this->checkClientDuplicate = 1;//与CRM客户查重
		$this->syncProject = 1;//同步修改客户数据 
		$this->relevanceClient = 1 ;
	}

	/**
     * 设置导入进度
     * @param string $value
     * @param string $key 缓存的键
     */
	public function _set_progress($value, $key = '')
	{

		$key = empty($key) ? $this->_progress_file : $key;
		
		// $this->cache->save($key, $value);
		file_put_contents(APPPATH."lock/".$key, $value);
	}
	/**
	  * 删除进度
	  *
	  */
	public function _remove_progress($key = '' )
	{
		$key = empty($key) ? $this->_progress_file : $key;
		@unlink(APPPATH."lock/".$key);
	}
    /**
     * 任务名模糊查询任务信息条件
     * @param array $condition
     * @return array
     */
	private function get_pro_id_condition($condition = array())
	{
		$wheres = array();
		if(!empty($condition['task_name']))
		{
			$wheres[] = "pro_name like '%".$condition['task_name']."%'";
		}
		return $wheres;
	}

    /**
     * 获取导入日志检索条件
     * @param $pro_id
     * @return array
     */
    private function get_import_log_condition($pro_id)
    {
        $wheres = array();
        if(!empty($pro_id))
        {
            $wheres[] = "pro_id in ($pro_id)";
        }
        return $wheres;
    }

    /**
     * 数据导入日志-数据列表
     * @param array $condition
     * @param int $page
     * @param int $limit
     * @param null $sort
     * @param null $order
     * @return stdClass
     */
	public function get_import_log($condition=array(),$page=0, $limit=0, $sort=NULL, $order=NULL)
	{
        $pro_name = isset($condition['task_name'])?$condition['task_name'] : "";
        $id_arr = array();
        if(!empty($pro_name)){
        	$pro_name = $this->db_read->escape_like_str($pro_name);
            $sql = "SELECT pro_id FROM est_project WHERE pro_name LIKE '%".$pro_name."%'";
            $ids_arr = $this->db_read->query($sql);
            $id_arr = $ids_arr->result_array();
            $id_arr = array_column($id_arr,'pro_id');
            if(!empty($id_arr))
        	{
            	$this->db_read->where_in('pro_id', $id_arr);
        	}
        	else 
        	{
        		$responce = new stdClass();
				$responce -> total = 0;
				$responce -> rows  = array();
				return $responce;
        	}
        }


		$this->db_read->select('count(*) as total',FALSE);
		$total_query = $this->db_read->get('est_import_log');
		$total = $total_query->row()->total;
		$responce = new stdClass();
		$responce -> total = $total;
		if(empty($page))
		{
			list($page, $limit, $sort, $order) = get_list_param();
		}
		if( ! empty($sort))
		{
			$this->db_read->order_by($sort,$order);
		}
		$start = get_list_start($total,$page,$limit);
		$this->db_read->limit($limit,$start);
        if(!empty($id_arr))
        {
            $this->db_read->where_in('pro_id', $id_arr);
        }
		$_data = $this->db_read->get('est_import_log');
		$this->db_read->flush_cache();//清除缓存细信息
		$impt_way = array('-1'=>'','0'=>'Excel导入','1'=>'客户导入');

		$this->load->model('project_manage_model');
		$project = $this->project_manage_model->getAllProjectName();
		foreach($_data->result_array() AS $i=>$item)
		{
			$item["pro_name"] = empty($project[$item['pro_id']]) ? "" : $project[$item['pro_id']];
			$item["impt_time"] = empty($item["impt_time"]) ? "" : date("Y-m-d H:i:s",$item["impt_time"]);
			$item["impt_way"] =  isset($impt_way[$item['impt_way']])?$impt_way[$item['impt_way']]:'';
			$responce -> rows[$i] = $item;
		}
		return $responce;
	}

    /**
     * 通过pro_name模糊查询pro_id
     * @param array $condition
     * @param int $page
     * @param int $limit
     * @param null $sort
     * @param null $order
     * @return string
     */
    public function get_pro_id($condition=array(),$page=0, $limit=0, $sort=NULL, $order=NULL)
    {
        $wheres = $this->get_pro_id_condition($condition);
        $where = implode(" AND ",$wheres);
        if( ! empty($where))
        {
            $this->db_read->start_cache();
            $this->db_read->where($where);
            $this->db_read->stop_cache();
        }
        $this->db_read->select('pro_id,pro_name',FALSE);
        $query = $this->db_read->get('est_project');
        $this->db_read->flush_cache();//清除缓存细信息
        $pro_id=array();
        foreach($query->result_array() AS $i=>$item)
        {
            $pro_id[]=$item['pro_id'];
        }

        $ids=implode(",",$pro_id);
        return $ids;
    }

    /**
     * 导出该批次中，导入失败的数据（客户）
     * @param int $impt_id
     * @return bool
     */

	public function export_failure_data($impt_id=0)
	{
		if (empty($impt_id))
		{
			return FALSE;
		}
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		//得到需要导出的数据详细信息
		$export_data = $this->get_import_error_data($impt_id);
		$responce = new stdClass();
		$responce -> rows = array();
		if(count($export_data)>0)
		{
			foreach ($export_data AS $key => $item)
			{
				$responce->rows[$key] = $item;
			}
		}
		$title = array();
	    $title["name"]  = array("批次号","客户电话",'原因');
        $title["field"] = array("impt_id","phone",'reson');
		$responce->name = "失败数据";
		$responce->title = $title;
		//构造导出数据
		$this->load->model("oper_log_model");
        $export_data = $this->oper_log_model->export_detail($responce->title,$responce->rows);
        //导出csv文件
        $this->load->library('Csv');
        $this->csv->creatcsv($responce->name,$export_data);
		return true;
	}

    /**
     * 得到该批次，导入失败的数据（客户）
     * @param int $impt_id
     * @return array
     */
	private function get_import_error_data($impt_id = 0)
	{
		if (empty($impt_id))
		{
			return array();
		}
		$query = $this->db_read->get_where("est_clear_error_data",array("impt_id"=>$impt_id));
		return $query->result_array();
	}

	/**
	 * 得到某导入日志信息
	 *
	 * @param int $impt_id
	 * @return array 
	 * <code>
	 * array(
	 *  [impt_id]=> 批次号,
	 *  [impt_total]=> 导入总数,
	 *  [impt_success]=> 导入成功数,
	 *  [impt_fail]=> 导入失败数
	 * )
	 * </code>
	 * 
	 * @author zgx
	 */
	public function get_import_log_info( $impt_id = 0 )
	{
		if(!$impt_id)
		{
			return array();
		}

		$this->db_read->select("impt_id,impt_total,impt_success,impt_fail");
		$this->db_read->where("impt_id",$impt_id);
		$query = $this->db_read->get("est_import_log");
		$import_info = $query->row_array();

		return $import_info;
	}
	/**
	  * 取得项目可用字段
	  */
	public function getProClientFields( $filter = TRUE )
	{
		$fields = $this->db_read->query('desc est_project_client')->result_array();
		//cle_province_id cle_city_id user_id
		$fields = array_column($fields,'Type','Field'); 
		if( $filter ){
			unset($fields['cle_province_id'],$fields['cle_city_id'],$fields['user_id'],$fields['cle_pingyin'],$fields['cle_province_name'],$fields['cle_city_name'],$fields['cle_phone2'],$fields['cle_phone3'],$fields['impt_id']);
		}
		foreach ($fields as $key => $value) {
			if( stripos( $value, 'varchar') !== FALSE)
			{//varchar
				$value = str_replace('varchar(', '', $value);
				$value = str_replace(')', '', $value);
				$value = intval($value);
				$fields[$key] = array('type'=>'str','len'=>$value);
			}
			else if(stripos($value, 'int') !== FALSE) 
			{
				$value = str_replace('int(','', $value);
				$value = str_replace(')', '', $value);
				$value = intval($value);
				$fields[$key] = array('type'=>'int','len'=>$value);
			}
			else if(in_array($value,array('text','date','datetime'))) 
			{
				$fields[$key] = array('type'=>$value,'len'=>0);
			}

		}
		return $fields;
	}
	/**
	  * 客户选择导入 非查重
	  */
	public function selectImpt($pro_id,$ids) 
	{
		//取得客户
		$where = array('cle_id in ('.join(',',$ids).')');
		$client = $this->getClientList($where);
		//事务开始
		$this->db_write->trans_begin();
		//取得导入ID
		$impt_id = $this->getImptId($pro_id,count($ids));
		//插入时间
		$insertTime = date('Y-m-d H:i:s',time());
		//插入日期
		$insertDate = date('Y-m-d',time());
		//获得可用的字段
		$enable_fileds = $this->descTable('est_project_client');
		$noImpt = array();

		$base_array = array('pro_id'=>$pro_id,'impt_type'=>2,'relevant_type'=>1,'relevant_cle_id'=>0,'impt_id'=>$impt_id,'task_num'=>'','insert_time'=>$insertTime,'insert_date'=>$insertDate,'data_source'=>'');
		//过滤掉 enable_fileds 字段
		$enable_fileds_key = array_diff(array_keys($enable_fileds), array_keys($base_array));
		$enable_fileds     = array();
		foreach ($enable_fileds_key as $keyname) {
			$enable_fileds[$keyname] = 0;
		}

		$reClient = array();
		foreach ($client as $key => $value) {
			$t = $base_array;
			// 删除字段中的无关字段
			$irrelevantItem = array('impt_id','user_id');
			foreach ($irrelevantItem as $key => $keyname) {
				if(isset($value[$keyname])){
					unset($value[$keyname]);
				}
			}

			if( $value['cle_phone'] == "" )
			{
				$noImpt[] = array('task_num'=>$value['cle_phone'],'message'=>'号码异常!');
				continue;
			}
			//信息来源
			$t['data_source'] = $value['cle_info_source'];

			$t['relevant_cle_id'] = $value['cle_id'];
			$t['task_num'] = $value['cle_phone'];
			// $t['transfer_cle_id'] = $value['cle_id'];

			//规范字段
			foreach ($enable_fileds as $en_key=>$en_value) {
				$t[$en_key] = isset($value[$en_key])?$value[$en_key]:'';
			}

			$reClient[] = $t;
		}
		
		if( count($reClient)  <= 0   )
		{
			$this->db_write->trans_rollback();
			return array('error'=>'1','message'=>'没有足够的有效数据！');
		}
		// 插入数据
		if( ! empty($reClient) ){
			$this->db_write->insert_batch('est_project_client', $reClient); 
		}
		$count_rows = 0;
		if ($this->db_write->trans_status() === FALSE)
		{
		    $this->db_write->trans_rollback();
		    return array('error'=>'1','message'=>'数据库异常');
		}
		else
		{
			//插入的行数
			$count_rows = $this->db_write->affected_rows();
		    $this->db_write->trans_commit();
		}

		if( !empty( $noImpt )){
			//收尾
			$this->insertError($impt_id,$noImpt); 
		}

		$this->db_write->update('est_import_log',array('impt_success'=>$count_rows,'impt_fail'=>count($client)-$count_rows,'impt_state'=>1,'impt_type'=>3,'data_source'=>'','impt_way'=>'1'),array('impt_id'=>$impt_id));
		//将数据转存到task表中
		if( $count_rows > 0  ){
			$this->toProTask($impt_id); 
		}

		//完成 
		return array('error'=>'0','message'=>'OK','count'=>count($client),'success'=>$count_rows,'failure'=>count($client)-$count_rows,'impt_id'=>$impt_id);
	
	}

	/**
	  * 全部导入
	  */
	public function allImpt($pro_id,$condition,$random_count) 
	{
		//取得客户
		$this->load->model('client_model');
		$condition['gl_all_data'] = true;
		$where = $this->client_model->get_client_condition($condition);
		$where = $where->wheres;
		//去掉where的已经现存的客户id
		$removeCLient = $this->get_current_project_client($pro_id);

		if( !empty($removeCLient) ){
			$where[] = 'cle_id not in ('.join(',',$removeCLient).')';
		}

		//事务开始
		$this->db_write->trans_begin();

		//取得导入ID
		$impt_id = $this->getImptId($pro_id,$random_count);
		//插入时间
		$insertTime = date('Y-m-d H:i:s',time());
		//插入日期
		$insertDate = date('Y-m-d',time());
		//取得客户列表
		$client = $this->getClientList($where);

		//获得可用的字段
		$enable_fileds = $this->descTable('est_project_client');

		$base_array = array('pro_id'=>$pro_id,'impt_type'=>2,'relevant_type'=>1,'relevant_cle_id'=>0,'impt_id'=>$impt_id,'task_num'=>'','insert_time'=>$insertTime,'insert_date'=>$insertDate,'data_source'=>'');
		//过滤掉 enable_fileds 字段
		$enable_fileds_key = array_diff(array_keys($enable_fileds), array_keys($base_array));
		$enable_fileds     = array();
		foreach ($enable_fileds_key as $keyname) {
			$enable_fileds[$keyname] = 0;
		}
		// 
		$reClient = array();
		foreach ($client as $key => $value) {
			$t = $base_array;
			// 删除字段中的无关字段
			$irrelevantItem = array('impt_id','user_id');
			foreach ($irrelevantItem as $key => $keyname) {
				if(isset($value[$keyname])){
					unset($value[$keyname]);
				}
			}

			if( $value['cle_phone'] == "" )
			{
				continue;
			}
			//信息来源
			$t['data_source'] = $value['cle_info_source'];
			$t['relevant_cle_id'] = $value['cle_id'];
			$t['task_num'] = $value['cle_phone'];
			// $t['transfer_cle_id'] = $value['cle_id'];
			//规范字段
			foreach ($enable_fileds as $en_key=>$en_value) {
				$t[$en_key] = isset($value[$en_key])?$value[$en_key]:'';
			}
			$reClient[] = $t;
		}
		//取得随机客户
		shuffle($reClient);//打乱顺序


		if( count($reClient)  < $random_count )
		{
			$this->db_write->trans_rollback();
			return array('error'=>'1','message'=>'没有足够的有效数据！');
		}
		$reClient = array_slice($reClient,0,$random_count,TRUE);
		

		
		// 插入数据

		$count_rows = 0 ;
		
		$this->db_write->insert_batch('est_project_client', $reClient); 

		if ($this->db_write->trans_status() === FALSE)
		{
		    $this->db_write->trans_rollback();
		    return array('error'=>'1','message'=>'数据库异常');
		}
		else
		{
			//插入的行数
			$count_rows = $this->db_write->affected_rows();
		    $this->db_write->trans_commit();
		}

		$this->db_write->update('est_import_log',array('impt_success'=>$count_rows,'impt_fail'=>$random_count-$count_rows,'impt_state'=>1,'impt_type'=>3,'data_source'=>'','impt_way'=>'1'),array('impt_id'=>$impt_id));

		//将数据转存到task表中
		if( $count_rows>0 )
		{
			$this->toProTask($impt_id); 
		}
		//完成 
		return array('error'=>'0','message'=>'OK','count'=>$random_count,'success'=>$count_rows,'failure'=>$random_count-$count_rows,'impt_id'=>$impt_id);
	}

	public function fileImpt($pro_id,$token,$from,$map) 
	{
		set_time_limit(0);

		$data= file_get_contents(APPPATH.'token/'.$token.".token");

		$this->proId = $pro_id;
		$this->setSetting();
		$this->_progress_file = $token;

		$data = json_decode($data,true);
		if(json_last_error() !== JSON_ERROR_NONE)
		{
			return array('error'=>1,'message'=>'文件读取出错');
		}
		$title = isset($data[0])?$data[0]:"";
		$_map = array(); 
		foreach ($map as $key => $value) {
			$k = array_search($value['name'] ,$title); 
			if($k !== FALSE)
			{
				$_map[$value['value']] = $k ;
			}
		}

		$map = $_map;

		if( !isset($map['cle_phone']) )
		{
			return array('error'=>'1','message'=>"导入数据失败,数据中未含电话");
		}
		//更改map的排序
		asort($map);
		
		
		$impt_id = $this->getImptId($pro_id,count($data)-1);

		//插入时间
		$insertTime = date('Y-m-d H:i:s',time());
		$insertDate = date('Y-m-d',time());
		//fields 类型
		$fields = $this->getProClientFields();

		$base_array = array('pro_id'=>$pro_id,'impt_type'=>1,'relevant_type'=>0,'relevant_cle_id'=>0,'impt_id'=>$impt_id,'task_num'=>'','insert_time'=>$insertTime,'insert_date'=>$insertDate,'data_source'=>$from);

		//遍历数组
		$reData = array(); 
		$noImpt = array();
		$impt_success = 0 ;
		$COUNT = count($data) -1 ;
		$data_count = 1 ;
		foreach ($data as $key => $value) {
			$time1 = microtime(true);//第一个时间
			if( $key == 0 )
			{
				//如果是第一行数据 则继续
				continue;
			}
			else 
			{
				$t = $base_array ;
				$t['task_num'] = isset($value[$map['cle_phone']])?$value[$map['cle_phone']]:'';
				if( $t['task_num'] == '' || $this->phoneVerify($t['task_num']) )
				{
					$noImpt[] = array('task_num'=>$t['task_num'],'message'=>'号码异常!');
					continue;
				}
				//对数据进行格式化限制
				foreach ($fields as $key => $f) {
					if( ! isset($map[$key]) || !isset( $value[$map[$key]] ))
					{
						continue; 
					}
					$t[$key] = $value[$map[$key]];
					if($f['type'] == 'int')
					{
						$t[$key]   = intval($t[$key] );
					}
					else if( $f['type'] == 'str')
					{
						$t[$key]  =  substr(trim($t[$key] ), 0,$f['len']);
					}
					else if( $f['type'] == 'date')
					{
						$t[$key]  = date('Y-m-d',$t[$key] );
					}
					else if( $f['type'] == 'datetime')
					{
						$t[$key]  = date('Y-m-d H:i:s',$t[$key] );
					}
					else if( $f['type'] == 'text')
					{
						$t[$key]  = stripcslashes($t[$key]);
					}
				}
				$r =  $this->imptRule($t);
				if( is_array( $r ) )
				{ // true 导入失败
					$noImpt[] = $r; 
				}
				else 
				{
					$impt_success ++; 
				}
				$data_count ++;
				$time2 = microtime(true);//第二个时间
				//预计计时间
				$time = date("H:i:s",time()+($time2 - $time1 ) * ($COUNT-$data_count) );
				$this->_set_progress("预计于{$time}完成#$data_count#$COUNT");
			}
		}
		//收尾
		$this->insertError($impt_id,$noImpt);

		$impt_fail = $COUNT - $impt_success;
		$this->db_write->update('est_import_log',array('impt_success'=>$impt_success,'impt_fail'=>$impt_fail,'impt_state'=>1,'impt_type'=>3,'data_source'=>$from,'impt_way'=>'0'),array('impt_id'=>$impt_id));

		$this->_set_progress("导入结束#$impt_success#$COUNT#$impt_fail#$impt_id");

		if( $impt_success > 0 ){
			$this->toProTask($impt_id); //将数据转存到task表中
		}

		return array('error'=>'0','message'=>"导入成功");
	}

	/**
      * 将任务客户表中数据转存到task表中
      */
	private function toProTask($impt_id)
	{
		//转存信息
		$this->db = $this->load->database('local_phone',true); 
		//取出本地的区号
		$this->load->config('myconfig');
		$local_code = $this->config->item('local_code') ;

		// 取出当前批次导入的数据 
		$impt_data = $this->db_write->query(
			'select task_id,pro_id,task_num from est_project_client where impt_id = ?',
			array($impt_id)
			)->result_array(); 
		foreach ($impt_data as &$data) {
			$phone = $data['task_num'];
			/*
			 * 只处理手机号
			 * 座机号如不加区号则直接返回
			 */
			if( preg_match('/^(\+)?(86)?(0)?1[3-9]\d{9}$/', $phone) )
			{
				//处理号码
		        if (substr($phone, 0, 3) == '+86') {
		            $phone = substr($phone, 3);
		        }
		        if (substr($phone, 0, 2) == '86') {
		            $phone = substr($phone, 2);
		        }
		        if (substr($phone, 0, 1) == 0) {
		            $phone = substr($phone, 1);
		        }
		        //号段取前7位进行比较
		        $num = substr($phone, 0, 7);

		        //查询区号对应的城市信息
		        $info = $this->db->query(
		            "SELECT code FROM location WHERE num = '$num' AND  code = '$local_code' "
		        )->row_array();
		        //没查询到区号 或者 不是本地号
		        if( ! isset($info['code']) || $info['code'] != $local_code)
		    	{
		    		$phone = '0'.$phone;
		    	}
			}
			$data['task_num'] = $phone;
		}


		$this->db_write->insert_batch('est_project_task',$impt_data);

		return TRUE;
	}
	/**
	  * 设置设置
	  */
	private function setSetting()
	{
		$setting = $this->db_read->query('Select syncProject,checkClientDuplicate,relevanceClient,syncClient from est_project where pro_id = ?',array($this->proId))->row_array();
		
		$this->syncProject = $setting['syncProject'];
		$this->checkClientDuplicate = $setting['checkClientDuplicate'];
		$this->relevanceClient = $setting['relevanceClient'];
		$this->syncClient = $setting['syncClient'];
		// //设置设置	
		// $this->syncClient = 1 ;//同步修改CRM客户数据
		// $this->checkClientDuplicate = 1;//与CRM客户查重
		// $this->syncProject = 1;//同步修改客户数据 
		// $this->relevanceClient = 1 ;
		return TRUE;
	}
	/**
	  * 导入规则
	  */
	private function imptRule($t){
		//与 项目数据查重 
		if( $dupTask = $this->checkProjectDuplicate($t['task_num']) )
		{ //检查项目重复

			if( $this->syncClient)
			{ //同步修改Client 
				if( $dupTask['relevant_cle_id'] != 0 ) 
				{	//关联
					
					if( $this->syncProject ){
						$clientInfo = $this->getClientInfo( $dupTask['relevant_cle_id'] );
						//对比数据
						//丰富CRM数据 
						$data = $this->dumpDuplicateData($clientInfo,$t);
						$this->enrichData($data,$dupTask['relevant_cle_id'],'Client');
						//丰富项目数据
						$data = $this->dumpDuplicateData($dupTask,$t);
						$this->enrichData($data,$dupTask['task_id'],'ProjectClient');
					}
				}
				else 
				{
					if( $this->syncProject ){

						//丰富项目数据
						$data = $this->dumpDuplicateData($dupTask,$t);
						$this->enrichData($data,$dupTask['task_id'],'ProjectClient');
					}
					
				}
			}
			else 
			{
				if( $this->syncProject ){
					//丰富项目数据	
					$data = $this->dumpDuplicateData($dupTask,$t);
					$this->enrichData($data,$dupTask['task_id'],'ProjectClient');
				}
				
			}
			
			//不导入 加到不导入中
			return array('task_num'=>$t['task_num'],'message'=>"与项目数据重复");
		}
		else {
			if( $this->checkClientDuplicate )
			{ //是否需要查重
				if( $cle = $this->checkClientDuplicateFun($t['task_num']) )
				{

					//重复
					//不导入 加到不导入中
					return array('task_num'=>$t['task_num'],'message'=>"与客户数据重复"); 
				}
				else {
					//插入数据
					$this->insertData($t);
				}
			}
			else
			{
			 	if( $this->relevanceClient ) 
			 	{ //关联Client数据 
			 		if( $cle = $this->checkClientDuplicateFun($t['task_num']) )
					{//重复 
						if( $this->syncClient )
						{//同步数据
							//对比重复数据
							$dumpData = $this->dumpDuplicateData($cle,$t);
							if(  !empty($dumpData['collide']) ) //collide 冲突
							{
								//说明冲突项
								$column = $this->getClientColumn();
								$str = ""; 
								foreach ($dumpData['collide'] as $key => $value) {
									$str .= $column[$key] ."[".$value[0]."]"."[".$value[1]."]  ";
								}
								// 不导入
								return array('task_num'=>$t['task_num'],'message'=>"与客户数据冲突  ".$str); 
							}
							else 
							{
								//建立关系
								$t['relevant_type'] = 1; //导入时关联
								$t['relevant_cle_id'] = $cle['cle_id'];
								//插入数据
								$task_id = $this->insertData($t);
								//以CRM数据丰富项目数据
								$this->enrichData($dumpData,$task_id,"ProjectClient");
								//以项目数据丰富CRM数据
								$this->enrichData($dumpData,$cle['cle_id'],"Client");
							}
						}
						else{

							//建立关系
							$t['relevant_type'] = 1; //导入时关联
							$t['relevant_cle_id'] = $cle['cle_id'];
							//插入数据
							$task_id = $this->insertData($t);
							//以CRM数据丰富项目数据
							$this->enrichData($dumpData,$task_id,"ProjectClient");
							
						}
						
					}
					else {
						//
						$this->insertData($t);
					}
			 	}
			 	else 
			 	{
			 		// 插入数据
			 		$this->insertData($t);
			 	}
			}
		}
		return TRUE;
	}
	
	/**
	  * 项目数据查重
	  */
	private function checkProjectDuplicate($task_num)
	{
		// $this->
		$est_project_client = $this->db_read->query("Select * from est_project_client where pro_id = ? and task_num = ? ",array($this->proId,$task_num))->row_array();
		return !empty($est_project_client)?$est_project_client:FALSE;
	}
	/**
	  * 号码是否为空号错号
	  */ 
	private function phoneVerify($phone)
	{
		return is_numeric($phone) && !(  strlen($phone) == 7 || strlen($phone) == 11 || (strlen($phone) == 12 && substr($phone,0, 1) == "0") || (strlen($phone) == 13 && substr($phone,0, 2) == "86"));
	}
	/**
	  * 与客户查重
	  */
	private function checkClientDuplicateFun($task_num)
	{
		$client = $this->db_read->query("Select * from est_client where cle_phone = '{$task_num}' or cle_phone2 = '{$task_num}' or cle_phone3 = '{$task_num}' ")->row_array();
		return !empty($client)?$client:FALSE;
	}
	/**
	  * 对比重复数据
	  */
	public function dumpDuplicateData($t1,$t2)
	{
		// 删除两种数据的无关重复项
		$irrelevantItem = array('impt_id','insert_time','data_source','user_id');
		foreach ($irrelevantItem as $key => $value) {
			if(isset( $t1[$value] )){
				unset($t1[$value]);
			}
			if(isset( $t2[$value] )){
				unset($t2[$value]);
			}
		}
		$collide = array(); 
		$Client = array_diff_key($t2, $t1);
		$ProjectClient = array_diff_key($t1, $t2);

		//冲突项
		foreach ($t1 as $key => $value) {
			if( isset($t2[$key]) && $t2[$key] != $t1[$key] && $t2[$key] != '' && $t1[$key] != '' )
			{
				$collide[$key] = array($t1[$key],$t2[$key]);
			}
		}
		$t_est_client = $this->descTable('est_client');
		$t_est_project_client = $this->descTable('est_project_client');

		$ProjectClient = array_intersect_key($ProjectClient,$t_est_project_client);
		$Client = array_intersect_key($Client,$t_est_client);
		file_put_contents(APPPATH.'logs/collide.log',json_encode($collide),FILE_APPEND);
		return array('ProjectClient'=>$ProjectClient,'Client'=>$Client,'collide'=>$collide);
	}

	/**
	  * 查看表定义
	  */
	public function descTable($table)
	{
		$r = $this->db_read->query("desc {$table}")->result_array();
		return array_column($r,'Type','Field');
	}
	/**
	  * 插入数据
	  */
	private function insertData($data)
	{
		$this->db_write->insert('est_project_client',$data);
		return $this->db_write->insert_id();
	}
	/**
	  * 取得客户信息
	  */
	private function getClientInfo($cle_id)
	{
		return $this->db_read->query("Select * from est_client where cle_id = ?",array($cle_id))->row_array();
	}
	/**
	  * 取得客户列表
	  */
	private function getClientList($where)
	{
		$where = join(" AND ",$where);
		if(!empty($where)) {
			$this->db_read->where($where);
		}
		return  $this->db_read->get('est_client')->result_array();
	}
	/**
	  * 丰富数据
	  */
	private function enrichData($data,$id,$type)
	{
		if($type == 'Client')
		{
			if(!empty( $data['Client'] )){
				$this->db_write->where(array('cle_id'=>$id));
				$this->db_write->update('est_client',$data['Client']);
				$this->log($data,$id,$type);
			}
		}
		else
		{
			if(!empty( $data['ProjectClient'])){
				$this->db_write->where(array('task_id'=>$id));
				$this->db_write->update('est_project_client',$data['ProjectClient']);
				$this->log($data,$id,$type);	
			}
		}
	}
	/**
	  * log
	  */
	private function log($data,$id,$type)
	{
		file_put_contents(APPPATH."logs/enrichdata_".date('Y-m-d',time()).".log", '['.date('H:i:s',time()).']'." ".$type." "."  ".'ID='.$id." ".json_encode($data).PHP_EOL,FILE_APPEND);
		return TRUE;
	}

	private function getImptId($pro_id,$total){
		
		$now_int = time();
		$user_id = $this->userId;
		$dept_id = $this->deptId;
		$user_name = $this->userName;
		$impt_log_data = array(
		'pro_id' => $pro_id,
		'impt_total' => $total,
		'impt_state' => 0,
		'impt_time' => $now_int,
		'user_id' => $user_id,//操作人id
		'dept_id' => $dept_id,
		'user_name' => $user_name
		);
		$this->db_write->insert('est_import_log',$impt_log_data);

		$impt_id = $this->db_write->insert_id();
		return $impt_id;
	}

	/**
	  * 被过滤
	  */
	private function insertError($impt_id,$wrong_phones)
	{
		$insert_wrong_phones_sql = "Insert into est_clear_error_data(impt_id,name,phone,reson)VALUES";
		$values = array();
		foreach ($wrong_phones as $key => $value) {
			$values[] ="($impt_id,'','{$value['task_num']}','{$value['message']}')";
		}
		if( !empty($values) )
		{
			$str = join(',',$values) ;
			$insert_wrong_phones_sql.=$str; 
			$this->db_write->query($insert_wrong_phones_sql);
		}
	}
	/**
	  * 取得当前项目中已经变 为客户的 客户ID
	  */
	public function get_current_project_client($pro_id)
	{
		$client = $this->db_read->query('Select relevant_cle_id from est_project_client where relevant_cle_id != 0 and pro_id = ? ',array($pro_id))->result_array();
		return array_column($client,'relevant_cle_id');
	}

	public function getClientColumn()
	{
		$this->load->model('field_confirm_model');
		$fields_available = $this->field_confirm_model->get_available_fields(FIELD_TYPE_CLIENT);
		//去掉 data_type  2 4 7的项  // 1文本2下拉选择3文本域4级联框5日期框7关联多选框
		$fields_available = array_filter($fields_available,function($a){
			if( !in_array($a['data_type'],array(2,4,7)) )
			{
				return $a ; 
			}
		});

		$this->load->model('task_import_model');
		$enable_field = $this->task_import_model->getProClientFields(); 

		$fields_available = array_filter($fields_available,function($a) use($enable_field){
			if( isset($enable_field[$a['fields']]) )
			{
				return $a;
			}
		});

		$field = array_column($fields_available,'name','fields');
		return $field;
	}

}