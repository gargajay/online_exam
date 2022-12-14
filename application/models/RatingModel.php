<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RatingModel extends CI_Model 
{
	var $table = 'quiz_reviews';
	var $column_order = array(null,'users.first_name', 'review_content', 'rating', 'quiz_reviews.status');
    var $column_search = array('users.first_name','review_content', 'rating', 'quiz_reviews.status');
    
    var $order = array('quiz_reviews.id' => 'DESC');

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($rating_for, $rating_relation_id) 
    {
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = quiz_reviews.user_id', 'left');
        $this->db->where('rel_id',$rating_relation_id);
        $this->db->where('rel_type',$rating_for);

        $logged_in_user = $this->session->userdata('logged_in');
        if($logged_in_user['role'] == "tutor")
        {
            $this->db->where('quiz_reviews.user_id', $logged_in_user['id']);
        }
        
        $i = 0;
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($_POST['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
        // here order processing
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order) ]);
        }
    }

    function count_filtered($rating_for, $rating_relation_id) {
        $this->_get_datatables_query($rating_for, $rating_relation_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function count_all($rating_for, $rating_relation_id) 
    {
        $this->db->from($this->table)->where('rel_id',$rating_relation_id)->where('rel_type',$rating_for);
        $logged_in_user = $this->session->userdata('logged_in');
        if($logged_in_user['role'] == "tutor")
        {
            $this->db->where('quiz_reviews.user_id', $logged_in_user['id']);
        }
        return $this->db->count_all_results();
    }

    function get_rating($rating_for, $rating_relation_id) 
    { 
        $this->_get_datatables_query($rating_for, $rating_relation_id);
        if ($_POST['length'] != - 1) 
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->select('quiz_reviews.*,first_name,last_name')
        ->where('quiz_reviews.rel_id',$rating_relation_id)
        ->where('quiz_reviews.rel_type',$rating_for)
        ->order_by('quiz_reviews.id', 'desc')
        ->get();
        return $query->result();
    }

    function update_status($id,$status)
    {
    	$this->db->set('status', $status)->where('id', $id)->update('quiz_reviews');
    }
}