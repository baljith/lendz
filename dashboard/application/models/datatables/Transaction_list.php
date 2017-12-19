<?php
class Transaction_list extends CI_Model
{
    public $table = "subscriptions sb";
    public $select_column = array(
        "sb.Created_Date",
        "CONCAT(u.User_First_Name,' ',u.User_Last_Name) As User_Full_Name",
        "p.Package_Name",
        "p.Package_Price",
        "sb.Status",
        "sb.End_At",
        "sb.Subs_Id"
    );
    public $order_column = array(
        "User_Full_Name",
        "p.Package_Name",
        "sb.Status",
        "sb.End_At",
        null
    );

    public $search_column = array(
        "CONCAT(u.User_First_Name,' ',u.User_Last_Name) ",
        "p.Package_Name",
    );
    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table)->join('packages p','p.Package_Id=sb.Plan_Id','LEFT')->join('users u','u.User_Id=sb.User_Id','inner');
        if (isset($_POST["search"]["value"]))
        {
            $wh = " (";
            foreach ($this->search_column as $column)
            {
                if (!empty($column))
                {
                    $wh .= " " . $column . " LIKE '%" . $_POST["search"]["value"] . "%' OR";
                }
            }

            $wh = rtrim($wh, "OR");
            $wh .= " )";
            $this->db->where($wh);
        }
		
		if (isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by($this->select_column[0], 'DESC');
        }
    }

    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table)->join('packages p','p.Package_Id=sb.Plan_Id','LEFT')->join('users u','u.User_Id=sb.User_Id','inner');
        return $this->db->count_all_results();
    }
}
