<?php
class Wechat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_wechat_info_list($page = 1, $limit = 10, $sort = null, $order = null, $where = null)
    {
    	        if (!empty($where)) {
            $this->db_read->start_cache();
            $this->db_read->where($where);
            $this->db_read->stop_cache();
        }

        $this->db_read->select('count(*) as total', false);
        $total_query     = $this->db_read->get('wechat_public_number');
        $total           = $total_query->row()->total;
        $total_pages     = ceil($total / $limit);
        $responce        = new stdClass();
        $responce->total = $total;

        $page  = $page > $total_pages ? $total_pages : $page;
        $start = $limit * $page - $limit;
        $start = $start > 0 ? $start : 0;
        if (!empty($sort)) {
            $this->db_read->order_by($sort, $order);
        }

        $_data          = $this->db_read->get('wechat_public_number', $limit, $start);
        $responce->rows = array();
        foreach ($_data->result_array() as $i => $task) {
            $responce->rows[$i] = $task;
        }
        $this->db_read->flush_cache();
        return $responce;
    }
}