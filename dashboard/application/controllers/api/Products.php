<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products extends CI_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        parent::__construct();
        // print_r($_POST);
        $this->load->library('Ajax_pagination');
        $this->load->library('Message');
        $this->load->model('Users_model', 'user');

        $this->load->library('Apiauth');
        $this->perPage = 10;
    }

    //Save Product here
    public function save_product()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST)) {
            $input = $this->input->post();
            $this->form_validation->set_rules('Product_Rent', 'Rent', 'required');
            $this->form_validation->set_rules('Product_Deposit', 'Deposit', 'required');
            $this->form_validation->set_rules('Product_Description', 'Description', 'required');
            $this->form_validation->set_rules('Product_Category', 'Product Category', 'required');
            $this->form_validation->set_rules('Latitude', 'Latitude', 'required');
            $this->form_validation->set_rules('Longitude', 'Longitude', 'required');
            $this->form_validation->set_rules('Location', 'Location', 'required');
            $this->form_validation->set_rules('User_Id', 'User_Id', 'required');
            if ($this->form_validation->run() == false) {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            } else {
                $Insert_Array = array(
                    'Product_Rent'        => $input['Product_Rent'],
                    'Product_Name'        => $input['Product_Name'],
                    'Product_Deposit'     => $input['Product_Deposit'],
                    'Product_Description' => $input['Product_Description'],
                    'Category_Id'         => $input['Product_Category'],
                    'Latitude'            => $input['Latitude'],
                    'Longitude'           => $input['Longitude'],
                    'Location'            => $input['Location'],
                    'User_Id'             => $input['User_Id'],
                    'Location'            => @$input['Location'],
                    'Created_Date'        => date('Y-m-d H:i:s'),
                    'Status'              => 'Pending',
                );
                if ($this->common_model->insert_data('products', $Insert_Array)) {
                    $insert_id                  = $this->db->insert_id();
                    $notification['Product_Id'] = $insert_id;
                    $notification['status']     = true;
                    $notification['msg']        = $this->lang->line('product_added_success');
                    $UserInfo                   = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                    //Mail to User
                    $data['message'] = $this->lang->line('product_added_mail_body');
                    $replaceto       = array("__USERNAME", "__ADMIN_EMAIL");
                    $replacewith     = array($UserInfo['Username'], FROM_EMAIL);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $data['subject'] = $this->lang->line('product_added_mail_subject');
                    $view_content    = $this->load->view('email/simple_content', $data, true);
                    send_email($UserInfo['User_Email'], $data['subject'], $view_content);

                    //Mail to user End

                    //Mail to Admin
                    $data['message'] = $this->lang->line('product_added_mail_body_to_admin');
                    $replaceto       = array("__USERNAME");
                    $replacewith     = array($UserInfo['Username']);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $data['subject'] = $this->lang->line('product_added_mail_subject_to_admin');
                    $view_content    = $this->load->view('email/simple_content', $data, true);
                    send_email(ADMIN_MAIL, $data['subject'], $view_content);
                    //Mail to Admin End
                } else {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('common_error');
                }
            }
        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //get Category List here
    public function getCategoryList()
    {
        $data['status'] = false;
        $data['data']   = $this->common_model->get_data('categories', array('Status' => 'Active'));
        if (!empty($data['data'])) {
            $data['status'] = true;
        } else {
            $data['msg'] = "No categories found";
        }
        exit(json_encode($data));
    }

    //Upload Product Images here one by one
    public function upload_productimage()
    {
        if (!empty($_FILES['file']['name']) && !empty($_POST)) {
            $filename                = $_FILES['file']['name'];
            $ext                     = pathinfo($filename, PATHINFO_EXTENSION);
            $config['upload_path']   = './assets/upload/product_img/';
            $config['allowed_types'] = 'gif|jpg|png';
            $new_name                = 'product_img' . time() . '.' . $ext;
            $_POST['User_Image']     = $new_name;
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);
            $this->load->library('image_lib');

            if ($this->upload->do_upload('file')) {
                $data = $this->upload->data();

                $configSize2['image_library']  = 'gd2';
                $configSize2['source_image']   = $data['full_path'];
                $configSize2['create_thumb']   = false;
                $configSize2['maintain_ratio'] = false;
                $configSize2['width']          = 350;
                $configSize2['height']         = 350;
                $configSize2['overwrite']      = true;
                $configSize2['new_image']      = $data['file_name'];
                if ($_POST['rotation'] == 'true') {
                    $configSize2['rotation_angle'] = 270;
                }
                $this->image_lib->initialize($configSize2);
                $this->image_lib->resize();

                if ($_POST['rotation'] == 'true') {

                    $this->image_lib->rotate();
                }
                $this->image_lib->clear();

                $chec = $this->db->insert('product_images', array('Product_Id' => $_POST['Product_Id'], 'Product_Image' => $_POST['User_Image'], 'Created_Date' => date('Y-m-d H:i:s')));
                unset($_POST['rotation']);
                unset($_POST['rotation']);

                if ($chec) {
                    $notification['status'] = true;
                    $notification['msg']    = "Profile successfully updated.";
                }

            } else {

                $notification['status'] = false;
                $notification['msg']    = strip_tags($this->upload->display_errors());
            }
        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //List Here
    public function product_list()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST)) {
            $input     = $this->input->post();
            $where     = "";
            $textQuery = 'SELECT p.*,c.Name,
            ( 3959 * acos ( cos ( radians("' . $_POST['selected_lat'] . '") ) * cos( radians( `p`.`Latitude` ) ) * cos( radians( `p`.`Longitude` ) - radians("' . $_POST['selected_lng'] . '") ) + sin ( radians("' . $_POST['selected_lat'] . '") ) * sin( radians( `p`.`Latitude` ) ) ) ) AS distance
            FROM ci_products p LEFT JOIN ci_categories c ON c.Id=p.Category_Id
            WHERE Booking_Status="Available" AND c.Status = "Active" ';

            if (!empty($input['priceStart'])) {
                $where .= ' AND Product_Rent >= ' . $input['priceStart'];
            }
            if (!empty($input['PriceEnd'])) {
                $where .= ' AND Product_Rent <= ' . $input['PriceEnd'];
            }
            if (!empty($input['search_key'])) {
                $where .= ' AND ( p.Product_Name LIKE "%' . $input['search_key'] . '%" OR c.Name LIKE "%' . $input['search_key'] . '%")';
            }
            if ($input['offset'] == 1 || empty($input['offset'])) {
                $start = 0;
            } else if ($input['offset'] > 1) {
                $start = ($input['offset'] - 1) * $this->perPage;
            }
            if ($input['type'] == 'lends') {
                if (!empty($_POST['User_Id'])) {
                    $where .= ' AND User_Id="' . $input['User_Id'] . '" ';
                }
            } else {
                if (!empty($_POST['User_Id'])) {
                    $where .= ' AND User_Id!="' . $input['User_Id'] . '" AND p.Booking_Status="Available" AND p.Status="Approved"';
                }
            }

            if (!empty($input['category'])) {
                $where .=' AND p.Category_Id="'.$input['category'].'"';
            }

            //Posted Within filter start
            if (!empty($input['postedWithin'])) {
                //If 24 Hours Selected
                if ($input['postedWithin'] == 'last_24') {
                    $NewDate = Date('Y-m-d', strtotime("-1 days"));
                    $where .= '  AND CAST(`p`.`Created_Date` AS DATE)>="' . $NewDate . '"';
                }
                //If 7 days Selected
                else if ($input['postedWithin'] == 'last_7') {
                    $NewDate = Date('Y-m-d', strtotime("-7 days"));
                    $where .= '  AND CAST(`p`.`Created_Date` AS DATE)>="' . $NewDate . '"';
                }
                //If last_30 days Selected
                else if ($input['postedWithin'] == 'last_30') {
                    $NewDate = Date('Y-m-d', strtotime("-30 days"));
                    $where .= '  AND CAST(`p`.`Created_Date` AS DATE)>="' . $NewDate . '"';
                }
            }

            $query = $textQuery . " " . $where;

            if (!empty($input['kms'])) {
                $query .= ' HAVING distance < "' . $input['kms'] . '" ';
            }

            //Sort BY Filter Work here
            if (!empty($input['sortBy'])) {
                //IF Closest first
                if ($input['sortBy'] == 'closest') {
                    $query .= ' ORDER BY distance asc';
                }
                //If High to Lo Selected
                else if ($input['sortBy'] == 'high_to_low') {
                    $query .= ' ORDER BY Product_Rent desc';
                }
                //If low to high selected
                else if ($input['sortBy'] == 'low_to_high') {
                    $query .= ' ORDER BY Product_Rent asc';
                } else {
                    $query .= ' ORDER BY Created_Date desc';
                }
            } else {
                $query .= ' ORDER BY Created_Date desc';
            }

            if (!empty($start)) {
                $query .= ' LIMIT ' . $this->perPage . ',' . $start;
            } else {
                $query .= ' LIMIT ' . $this->perPage;
            }
            // echo $query;
            $data = $this->db->query($query)->result_array();
            if (!empty($data)) {
                foreach ($data as $key => $dat) {
                    $data[$key]                  = $dat;
                    $image                       = $this->db->select('Product_Image')->from('product_images')->where('Product_Id', $dat['Id'])->limit(1)->get()->row_array();
                    $data[$key]['Product_Image'] = $image['Product_Image'];
                    $rating = $this->db->select('COUNT(*) as total,SUM(r.Rat_Amount) as overall')->from('ratings r')->where(array('Rat_On'=>$dat['Id'],'Approved'=>'Approved'))->get()->row_array();
                    if(!empty($rating['overall']) && !empty($rating['total'])) {
                        $data[$key]['Rat_Amount'] = $rating['overall']/$rating['total']; 
                        $data[$key]['Rat_Total'] = $rating['total']; 
                    } else {
                        $data[$key]['Rat_Amount'] = 0;
                        $data[$key]['Rat_Total'] = 0;
                    }
                }
                $notification['status'] = true;
                $notification['data']   = $data;
            } else {
                $notification['status'] = false;
                $notification['msg']    = "No Lends found yet";
            }
        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //Get Single PRoduct Info here
    public function productInfo()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('Product_Id', 'Product Id', 'required');
            $this->form_validation->set_rules('User_Id', 'User', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                if($input['type']=='lends'){
                    $ProductInfo = $this->common_model->get_data('products', array('Id' => $input['Product_Id'], 'User_Id' => $input['User_Id']), 'single');
                } else{
                    $ProductInfo = $this->common_model->get_data('products', array('Id' => $input['Product_Id'], 'User_Id!=' => $input['User_Id']), 'single');
                }
                if (!empty($ProductInfo)) {
                    $Images = $this->common_model->get_data('product_images', array('Product_Id' => $input['Product_Id']));

                    $History                 = $this->db->select('b.*,u.User_First_Name,u.User_Last_Name,u.User_Image')->from('borrow b')->join('users u', 'u.User_Id=b.User_Id', 'left')->where(array('Product_Id' => $input['Product_Id']))->get()->result_array();
                    $notification['status']  = true;
                    $notification['data']    = $ProductInfo;
                    $notification['images']  = $Images;
                    $notification['history'] = $History;
                    
                    $notification['other'] = $this->db->select('COUNT(*) as total,SUM(r.Rat_Amount) as overall')->from('ratings r')->where(array('Rat_On'=>$input['Product_Id'],'Approved'=>'Approved'))->get()->row_array();

                } else {
                    $notification['status'] = false;
                    $notification['msg']    = 'Product Info not found';
                }
            }
        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function sendpush($id)
    {
        if ($this->common_model->send_push($id)) {
            echo "Demo Push sent successfully";
        } else {
            echo "Something went wrong please check the code.";
        }
    }


    //get Reviews List here
    public function getReviews($limit = null)
    {
        $notification['status'] = false;
        $notification['msg'] = 'no records found';
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST['Product_Id']) && !empty($_POST['Product_Id']))
        {
            if(!empty($limit)){
                $notification['data']   = $this->db->select('r.*,u.User_First_Name,u.User_Last_Name')->from('ratings r')->join('users u','u.User_Id=r.Rat_By','left')->where(array('Rat_On'=>$_POST['Product_Id'],'Approved'=>'Approved'))->limit($limit)->order_by('Rat_Id','Desc')->get()->result_array();
                $notification['other'] = $this->db->select('COUNT(*) as total,SUM(r.Rat_Amount) as overall')->from('ratings r')->where(array('Rat_On'=>$_POST['Product_Id'],'Approved'=>'Approved'))->get()->row_array();
            } else{
                $notification['data']   = $this->db->select('r.*,u.User_First_Name,u.User_Last_Name')->from('ratings r')->join('users u','u.User_Id=r.Rat_By','left')->where(array('Rat_On'=>$_POST['Product_Id'],'Approved'=>'Approved'))->order_by('Rat_Id','Desc')->get()->result_array();
                $notification['other'] = $this->db->select('COUNT(*) as total,SUM(r.Rat_Amount) as overall')->from('ratings r')->where(array('Rat_On'=>$_POST['Product_Id'],'Approved'=>'Approved'))->get()->row_array();
            }
            if (!empty($notification['data']))
            {
                $notification['status'] = true;
            } else {
                $notification['msg'] = "no records found";
            }
        }
        exit(json_encode($notification));
    }

    //Save review page
    public function save_review(){
        $notification['status'] = false;
        $notification['msg'] = 'no records found';
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('Product_Id', 'Product Id', 'required');
            $this->form_validation->set_rules('User_Id', 'User', 'required');
            $this->form_validation->set_rules('Rat_Amount', 'Rat_Amount', 'required');
            $this->form_validation->set_rules('Rat_Desc', 'Rat_Desc', 'required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $insertData = array(
                    'Rat_Amount' => $input['Rat_Amount'],
                    'Rat_Desc' => $input['Rat_Desc'],
                    'Rat_On' => $input['Product_Id'],
                    'Rat_By' => $input['User_Id'],
                    'Created_Date' => date('Y-m-d H:i:s')
                );
                if ($this->common_model->insert_data('ratings',$insertData)) {
                    $notification['status'] = true;
                    $notification['msg']    = 'Rating submitted successfully';
                } else {
                    $notification['msg']    = 'dRating submitted successfully';
                }
            }
        }
        exit(json_encode($notification));
    }

    public  function reviews_Pagination()
    {
        $notification['status'] = false;
        $notification['msg'] = 'no records found';
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST['Product_Id']) && !empty($_POST['Product_Id']))
        {
            if ($_POST['offset'] == 1 || empty($_POST['offset'])) {
                $start = 0;
            } else if ($_POST['offset'] > 1) {
                $start = ($_POST['offset'] - 1) * $this->perPage;
            }

            if(!empty($start)){
                $notification['data']   = $this->db->select('r.*,u.User_First_Name,u.User_Last_Name')->from('ratings r')->join('users u','u.User_Id=r.Rat_By','left')->where(array('Rat_On'=>$_POST['Product_Id'],'Approved'=>'Approved'))->limit(20,$start)->order_by('r.Rat_Id','Desc')->get()->result_array();
            } else{
                $notification['data']   = $this->db->select('r.*,u.User_First_Name,u.User_Last_Name')->from('ratings r')->join('users u','u.User_Id=r.Rat_By','left')->where(array('Rat_On'=>$_POST['Product_Id'],'Approved'=>'Approved'))->order_by('r.Rat_Id','Desc')->limit(20)->get()->result_array();
            }
            if (!empty($notification['data']))
            {
                $notification['status'] = true;
            } else {
                $notification['msg'] = "no records found";
            }
        }
        exit(json_encode($notification));
    }

}
