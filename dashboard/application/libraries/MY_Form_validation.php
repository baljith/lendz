<?php if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class MY_Form_validation extends CI_Form_validation
{
    protected $CI;
    public function __construct()
    {
        parent::__construct();
        // reference to the CodeIgniter super object
        $this->CI = &get_instance();
    }
    public function single_error()
    {
        if (count($this->_error_array) === 0)
        {
            return false;
        }
        else
        {
            return array_values($this->_error_array)[0];
        }

    }
    public function is_exist($User_Email)
    {
        $this->CI->form_validation->set_message('check_email', $this->CI->lang->line('check_email_error_msg'));
        if ($this->CI->db->where("User_Email = '$User_Email' OR Username = '$User_Email'")->get('users')->num_rows() > 0)
        {
            if ($this->CI->db->where("( User_Email = '$User_Email' OR Username = '$User_Email' ) AND Is_Deleted='0'")->get('users')->num_rows() > 0)
            {
                return true;
            }
            else
            {
                $this->CI->form_validation->set_message('is_exist', $this->CI->lang->line('account_is_deactivated_error_msg'));
                return false;
            }
        }
        else
        {
            $this->CI->form_validation->set_message('is_exist', $this->CI->lang->line('check_email_error_msg'));
            return false;
        }
    }
    public function check_password($password)
    {
        $this->CI->form_validation->set_message('check_password', $this->CI->lang->line('check_password_error_msg'));
        $User_Email    = $this->CI->input->post('User_Email');
        $User_Password = md5($password);
        $where         = '(User_Email="' . $User_Email . '" || Username="' . $User_Email . '") && User_Password="' . $User_Password . '"';
        if ($this->CI->common_model->check_data('users', $where) == false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function is_unique_update($value, $arguments)
    {
        $cons       = explode('.', $arguments);
        $table_name = $cons[0];
        $col_name   = $cons[1];
        $current_id = $cons[2];
        $current_col_name = $cons[3];
        $this->CI->form_validation->set_message('is_unique_update','The %s field should be unique');
        $where = array(
            $current_col_name . '!=' => $current_id,
            $col_name . '=' => $value,
        );
        if ($this->CI->common_model->check_data($table_name, $where))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
