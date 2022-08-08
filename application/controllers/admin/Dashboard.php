<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends Admin_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('DashboardModel');
        $this->add_js_theme('Chart.min.js');
        $this->add_js_theme('dashboard.js');
    }
    /**
     * Dashboard
     */
    function index() {
        
        $api_url = "https://projects.ishalabs.com/updates/api/"; 
        $update_info_value  = get_setting_value_by_name('update_info');
        $update_info_json = $update_info_value ? $update_info_value : json_encode(array());
        $update_info_obj = json_decode($update_info_json);
        $update_info_array = json_decode(json_encode($update_info_obj), true);

        if ($update_info_obj->purchase_code_updated) 
        {
            $up_info_site_update_token = $update_info_array['purchase_code'];
            $update_version_url = $api_url."verify_purchase_code.php?purchase_token=$up_info_site_update_token&project_slug=quiz";
            $api_response = array();
            $api_response_json = get_web_page($update_version_url);
            $api_response = json_decode($api_response_json);

            if($api_response && is_object($api_response))
            {
                $update_info_array['purchase_code_updated'] = FALSE;
                $update_info_array['last_updated'] = date("Y-m-d H:i:s");
                $update_info_array['is_verified'] = $api_response->is_verify;
                $update_info_array['message'] = $api_response->message;
            } else
            {
                $update_info_array['purchase_code_updated'] = FALSE;
                $update_info_array['last_updated'] = date("Y-m-d H:i:s");
                $update_info_array['is_verified'] = FALSE;
                $update_info_array['message'] = lang("Purchase code not verified!");
            }

            $setting_update_info['value'] = json_encode($update_info_array);
            $this->db->where('name','update_info')->update('settings',$setting_update_info);
        }

        // setup page header data
        $this->set_title(lang('admin_dashboard'));
        $data = $this->includes;
        $data['products'] = 400;
        $data['market'] = 30;
        $data['brands'] = 20;
        $data['category'] = $this->DashboardModel->categories_count();
        $data['users'] = $this->DashboardModel->user_count();
        $data['pages'] = $this->DashboardModel->pages_count();
        $data['quiz'] = $this->DashboardModel->quiz_count();
        $data['study_material'] = $this->DashboardModel->study_material_count();
        $data['blog_post'] = $this->DashboardModel->blog_count();
        $data['payment_total'] = $this->DashboardModel->payment_count();
        $data['langues_count'] = $this->DashboardModel->langues_count();




        $months = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');

        $month_wise_tutors = array();
        $month_wise_users = array();
        $month_wise_payments = array();
        $month_wise_quizess = array();
        $month_wise_materials = array();
        $currency = get_admin_setting('paid_currency');
        $m = 0;
        for ($i = 0; $i < 12; $i++) 
        {
            $m ++;
            $current_month = sprintf("%02d", $m);

            $first_day_of_month = date("Y")."-".$current_month."-"."01 00:00:00";

            $last_day_of_month = date("Y")."-".$current_month."-".date("t", strtotime($first_day_of_month))." 00:00:00";

           


            $this->db->select('count(id) as total_users');
            $this->db->where('created >=' , $first_day_of_month);
            $this->db->where('created <=' , $last_day_of_month);
            $this->db->where('role','user');
            $total_users = $this->db->get('users')->row('total_users');
            $total_users > 0 ? array_push($month_wise_users, $total_users) : array_push($month_wise_users, 0);

            // ***************************************************

            $this->db->select('count(id) as total_tutor');
            $this->db->where('created >=' , $first_day_of_month);
            $this->db->where('created <=' , $last_day_of_month);
            $this->db->where('role','tutor');
            $total_tutor = $this->db->get('users')->row('total_tutor');
            $total_tutor > 0 ? array_push($month_wise_tutors, $total_tutor) : array_push($month_wise_tutors, 0);


            // ***************************************************

            $this->db->select('SUM(item_price) as total');
            $this->db->where('created >=' , $first_day_of_month);
            $this->db->where('created <=' , $last_day_of_month);
            $pay_data_by_month = $this->db->get('payments')->row('total');
            $pay_data_by_month > 0 ? array_push($month_wise_payments, $pay_data_by_month) : array_push($month_wise_payments, 0);

            // ***************************************************

            $this->db->select('count(id) as total_quiz');
            $this->db->where('added >=' , $first_day_of_month);
            $this->db->where('added <=' , $last_day_of_month);
            $total_quiz = $this->db->get('quizes')->row('total_quiz');
            
            $total_quiz > 0 ? array_push($month_wise_quizess, $total_quiz) : array_push($month_wise_quizess, 0);

            //**************************************************************

            $this->db->select('count(id) as total_materials');
            $this->db->where('added >=' , $first_day_of_month);
            $this->db->where('added <=' , $last_day_of_month);
            $total_materials = $this->db->get('study_material')->row('total_materials');
            
            $total_materials > 0 ? array_push($month_wise_materials, $total_materials) : array_push($month_wise_materials, 0);

            //**************************************************************




        }
        $data['currency'] = get_admin_setting('paid_currency');
        $data['month_wise_tutors'] = $month_wise_tutors;
        $data['month_wise_materials'] = $month_wise_materials;
        $data['month_wise_quizess'] = $month_wise_quizess;
        $data['month_wise_payments'] = $month_wise_payments;
        $data['month_wise_users'] = $month_wise_users;
        $data['months'] = $months;
        // load views
        $data['content'] = $this->load->view('admin/dashboard', $data, TRUE);
        $this->load->view($this->template, $data);
        
    }
}
