<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
    }
    //List of packages
    public function index()
    {

        $this->db->select('products.Id, products.Product_Name,products.Product_Rent, products.Status,users.Username, categories.Name');
        $this->db->from('products');
        $this->db->join('users', 'users.User_Id = products.User_Id','left');
        $this->db->join('categories', 'categories.Id = products.Category_Id','left');
        $query = $this->db->get();
        $data['product_list'] = $query->result_array();
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/product_list', $data);
        $this->load->view('includes/footer');
    }

    //add Page of packages
    public function add($product_id = "")
    {
        
        $data['product_id'] = "";
        if (!empty($product_id))
        {
            $data['product_detail'] = $this->common_model->get_data('products', array('Id' => $product_id), 'single');
            if (!empty($data['product_detail']))
            {
                $data['product_id'] = $product_id;
            }
        }
        $data['category_list'] = $this->common_model->get_data('categories', array('Status' => 'Active'));
        $data['user_list'] = $this->common_model->get_data('users', array('Verified' => '1','Role' => '1'));
       
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/product_add', $data);
        $this->load->view('includes/footer');
    }

    //Insert functionality done here
    public function insert()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                echo"<pre>"; print_r($input); die;
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('Product_Name', 'Product Name', 'trim|required');
                $this->form_validation->set_rules('Product_Price', 'Product Price', 'trim|required');
                $this->form_validation->set_rules('User_Id', 'Username', 'trim|required');
                $this->form_validation->set_rules('Category_Id', 'Product Category', 'trim|required');
                $this->form_validation->set_rules('Product_Description', 'Product Description', 'trim|required');

                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    
                    if (empty($this->input->post('id')))
                    {
                        $input['created']  = date('Y-m-d H:i:s');
                        if (!empty($_FILES['profile_pic']['name']))
                        {
                            $filename                = $_FILES['profile_pic']['name'];
                            $ext                     = pathinfo($filename, PATHINFO_EXTENSION);
                            $config['upload_path']   = './assets/upload/category_img/';
                            $config['allowed_types'] = 'gif|jpg|png';
                            $new_name                = 'category_image_' . time() . '.' . $ext;
                            $input['image']     = $new_name;
                            $config['file_name']     = $new_name;
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('profile_pic'))
                            {
                                $notification['status'] = false;
                                $notification['msg']    = strip_tags($this->upload->display_errors());
                                exit(json_encode($notification));
                            }
                        }
                        if ($this->common_model->insert_data('categories', $input))
                        {
                            $plan_id = $this->db->insert_id();
                            $notification['status'] = true;
                            $notification['msg']    = $this->lang->line('add_category_success');
                        }
                    }
                    else
                    {
                        $category_id = $input['id'];
                        if ($this->common_model->update_data('categories', $input, array('id' => $category_id)))
                        {
                            $notification['status'] = true;
                            $notification['msg']    = $this->lang->line('edit_category_success');
                        }
                    }
                }
            }
        }
        exit(json_encode($notification));
    }


    public function changestatus($info = "")
    {
        $input = $this->input->post();
        $data['category_id'] = "";
        if (!empty($input))
        {   
            $this->common_model->update_data('products', $input, array('Id' => $input['id']));
            $notification['status'] = true;
            $notification['msg']    = $this->lang->line('product_status_update');
        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }

    public function productApprovel($info = "")
    {
        $input = $this->input->post();
        if (!empty($input))
        {   
            $this->common_model->update_data('products', $input, array('Id' => $input['id']));
            if($input['Status']=='Approved'){
                
                $data['product_info'] = $this->common_model->get_data('products', array('Id' => $input['id']), 'single');
                $data['user_info'] = $this->common_model->get_data('users', array('User_Id' => $data['product_info']['User_Id']), 'single');
                $price = '$'.$data['product_info']['Product_Price'];

                $data['message'] = $this->lang->line('approved_product_email_by_admin');
                $replaceto       = array("__USERNAME", "__PRODUCT", "__PRICE", "__ADMIN_EMAIL");
                $replacewith     = array($data['user_info']['Username'], $data['product_info']['Product_Name'], $price , FROM_EMAIL);
                $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                $data['subject'] = $this->lang->line('approved_product_subject_admin');
                $view_content    = $this->load->view('email/simple_content', $data, true);
                send_email($data['user_info']['User_Email'], $data['subject'], $view_content);

                $push_message    = $this->lang->line('product_approved_push');
                $replaceto       = array("_PRODUCT_NAME");
                $replacewith     = array($data['product_info']['Product_Name']);
                $message         = str_replace($replaceto, $replacewith, $push_message);
               
                $push_data       = array(
                    'type'    => 'notification',
                    'data'    => $data['product_info']
                );

                $this->common_model->send_push($data['product_info']['User_Id'], $push_data, $message);
               
                $notification['status'] = true;
                $notification['msg']    = $this->lang->line('product_approved');

            } else {

                $data['product_info'] = $this->common_model->get_data('products', array('Id' => $input['id']), 'single');
                $data['user_info'] = $this->common_model->get_data('users', array('User_Id' => $data['product_info']['User_Id']), 'single');
                $price = '$'.$data['product_info']['Product_Rent'];

                $data['message'] = $this->lang->line('unapproved_product_email_by_admin');
                $replaceto       = array("__USERNAME", "__PRODUCT", "__PRICE", "__ADMIN_EMAIL");
                $replacewith     = array($data['user_info']['Username'], $data['product_info']['Product_Name'], $price , FROM_EMAIL);
                $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                $data['subject'] = $this->lang->line('unapproved_product_subject_admin');
                $view_content    = $this->load->view('email/simple_content', $data, true);
                send_email($data['user_info']['User_Email'], $data['subject'], $view_content);
                
                $push_message    = $this->lang->line('product_unapproved_push');
                $replaceto       = array("_PRODUCT_NAME");
                $replacewith     = array($data['product_info']['Product_Name']);
                $message          = str_replace($replaceto, $replacewith, $push_message);
                
                $push_data       = array(
                    'type'    => 'notification',
                    'data'    => $data['product_info']
                );

                $this->common_model->send_push($data['product_info']['User_Id'], $push_data,  $message );

                $notification['status'] = true;
                $notification['msg']    = $this->lang->line('product_unapproved');

            }
            
        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }


    public function view($product_id = "")
    {
        $this->db->select('products.Id, products.Product_Name,products.Product_Rent, products.Product_Description, products.Status,users.Username, users.User_Email, categories.Name');
        $this->db->from('products');
        $this->db->where('products.Id ='.$product_id);
        $this->db->join('users', 'users.User_Id = products.User_Id','left');
        $this->db->join('categories', 'categories.Id = products.Category_Id','left');
        $query = $this->db->get();
        $data['product_list'] = $query->first_row();

        $data['product_images'] = $this->common_model->get_data('product_images', array('Product_Id' => $product_id));
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/product_view', $data);
        $this->load->view('includes/footer');
    }
}
