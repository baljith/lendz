<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Chat_model extends CI_Model
{
    public function save_message($data)
    {
        if ($this->db->insert('messages', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function all($User_one, $User_two, $limit, $last_id = "", $min_id = "", $thread_id = "", $read_chat = 'yes')
    {

        if(!empty($last_id)){
             $sql = "SELECT m.*,
                (IF(m.Sent_By = $User_one,'right','left')) AS class,u1.User_First_Name,u1.User_Last_Name
                FROM ci_messages m
                LEFT JOIN ci_users u1 ON u1.User_Id=m.Sent_By
                WHERE (m.Sent_By=$User_two AND m.Sent_To=$User_one)";
            if (!empty($thread_id)) {
                $sql .= " AND m.Thread='" . $thread_id . "'";
            } else {
                $sql .= " AND m.Thread='0'";
            }


                $sql .= " AND m.M_Id>'" . $last_id . "' ORDER BY m.M_Id ASC LIMIT " . $limit;
           

            $res = $this->db->query($sql)->result_array();
            if (!empty($res)) {
                if ($read_chat == 'no') {
                } else {
                    $this->mark_read($User_one, $User_two, $thread_id);
                }

                return $res;
            } else {
                return $res;
            }
        }else{
            $sql = "SELECT m.*,
                (IF(m.Sent_By = $User_one,'right','left')) AS class,u1.User_First_Name,u1.User_Last_Name
                FROM ci_messages m
                LEFT JOIN ci_users u1 ON u1.User_Id=m.Sent_By
                WHERE ((m.Sent_By=$User_one AND m.Sent_To=$User_two) || (m.Sent_By=$User_two AND m.Sent_To=$User_one))";
            if (!empty($thread_id)) {
                $sql .= " AND m.Thread='" . $thread_id . "'";
            } else {
                $sql .= " AND m.Thread='0'";
            }

            if (!empty($min_id)) {
                $sql .= " AND m.M_Id<'" . $min_id . "' ORDER BY m.M_Id DESC LIMIT " . $limit;
            } else
            if (!empty($last_id)) {
                $sql .= " AND m.M_Id>'" . $last_id . "' ORDER BY m.M_Id ASC LIMIT " . $limit;
            } else {
                $sql .= " ORDER BY m.M_Id DESC LIMIT " . $limit;
            }

            $res = $this->db->query($sql)->result_array();
            if (!empty($res)) {
                if ($read_chat == 'no') {
                } else {
                    $this->mark_read($User_one, $User_two, $thread_id);
                }

                return $res;
            } else {
                return $res;
            }
            
        }


    }

    // Mark read function goes here

    public function mark_read($user_from = "", $user_to = "", $thread = "")
    {
        if (!empty($user_from) && !empty($user_to)) {
            if (!empty($thread)) {
                $this->db->where('Sent_To=' . $user_from . ' AND Sent_By=' . $user_to . ' AND Is_Read="0"')->where('Thread', $thread)->update('ci_messages', array(
                    'Is_Read' => '1',
                ));
            } else {
                $this->db->where('Sent_To=' . $user_from . ' AND Sent_By=' . $user_to . ' AND Is_Read="0"')->where('Thread', '0')->update('ci_messages', array(
                    'Is_Read' => '1',
                ));
            }
        } else
        if (!empty($user_from) && empty($user_to)) {
        }
    }

    public function single($msg_id, $user_one)
    {
        $sql = "SELECT m.*,

            (IF(m.Sent_By = $user_one,'right','left')) AS class,u1.User_First_Name,u1.User_Last_Name

            FROM ci_messages m

            LEFT JOIN ci_users u1 ON u1.User_Id=m.Sent_By

            WHERE M_Id=$msg_id";
        return $this->db->query($sql)->row_array();
    }

    // Unread Messages List

    public function unread_list($user_id)
    {
        $sql = "SELECT m.*,u1.User_First_Name,u1.User_Last_Name,u1.User_Image

            FROM ci_messages m

            LEFT JOIN ci_users u1 ON u1.User_Id=m.Sent_By

            WHERE Sent_To=$user_id AND Is_Read='0' ORDER BY M_Id DESC  LIMIT 100";
        return $this->db->query($sql)->result_array();
    }

    // get Messages Function start here

    public function getMessages($params = array(), $filters = array())
    {
        $this->db->select('m.*,uf.User_First_Name AS From_User_First_Name,uf.User_Last_Name AS From_User_Last_Name,uf.User_Image AS From_User_Image, ut.User_First_Name AS To_User_First_Name,ut.User_Last_Name AS To_User_Last_Name,ut.User_Image AS To_User_Image,p.Product_Name');

        $this->db->from('messages m');
        $this->db->join('users uf', 'uf.User_Id=m.Sent_By', 'left');
        $this->db->join('users ut', 'ut.User_Id=m.Sent_To', 'left');
        $this->db->join('products p', 'p.Id=m.Thread', 'left');
        $this->db->where('(Sent_To=' . $filters['User_Id'] . ' OR Sent_By=' . $filters['User_Id'] . ') AND Last="1"');
        $this->db->order_by('M_Id', 'DESC');

        // if (!empty($filters['archive'])) {
        //     if ($filters['archive'] == '1') {
        //         $this->db->where('( (t.Archived = "1" AND t.User_Id="' . $filters['User_Id'] . '") OR (s.Archived = "1" AND s.Created_By="' . $filters['User_Id'] . '" ) )');
        //     } else {
        //         $this->db->where('( (t.Archived = "0" AND t.User_Id="' . $filters['User_Id'] . '") OR (s.Archived = "0" AND s.Created_By="' . $filters['User_Id'] . '" )  OR  ( t.User_Id!="' . $filters['User_Id'] . '") OR (s.Created_With="' . $filters['User_Id'] . '" ) )');
        //     }
        // } else {
        //     $this->db->where('( (t.Archived = "0" AND t.User_Id="' . $filters['User_Id'] . '") OR (s.Archived = "0" AND s.Created_By="' . $filters['User_Id'] . '" )  OR  ( t.User_Id!="' . $filters['User_Id'] . '") OR (s.Created_With="' . $filters['User_Id'] . '" ) )');
        // }

        // if (!empty($filters['search_message'])) {
        //     $this->db->where("( CONCAT(uf.User_First_Name, ' ', uf.User_Last_Name) LIKE '%" . $this->db->escape_str($filters['search_message']) . "%' OR CONCAT(ut.User_First_Name, ' ', ut.User_Last_Name) LIKE '%" . $this->db->escape_str($filters['search_message']) . "%' OR m.Message LIKE '%" . $this->db->escape_str($filters['search_message']) . "%')");
        // }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    } //get Messages Function start here
    public function getAllMessages($params = array(), $filters = array())
    {
        $this->db->select('m.*,uf.User_First_Name AS From_User_First_Name,uf.User_Last_Name AS From_User_Last_Name,uf.User_Image AS From_User_Image, ut.User_First_Name AS To_User_First_Name,ut.User_Last_Name AS To_User_Last_Name,ut.User_Image AS To_User_Image,t.Type as Tool_Type,s.Created_By,s.Subject_Id')->select('

               (case when (m.Thread_Type="tool")

             THEN

                  t.Description

             ELSE

                  s.Subject_Name

             END) as Description

                ')->select('

               (case when (m.Thread_Type="tool")

             THEN

                  t.Archived

             ELSE

                  s.Archived

             END) as Archived

                ');
        $this->db->from('messages m');
        $this->db->join('users uf', 'uf.User_Id=m.Sent_By', 'left');
        $this->db->join('users ut', 'ut.User_Id=m.Sent_To', 'left');
        $this->db->join('tools t', 't.Id=m.Thread AND m.Thread_Type="tool"', 'left');
        $this->db->join('subjects s', 's.Subject_Id=m.Thread AND m.Thread_Type="custom"', 'left');
        $this->db->where('(Sent_To=' . $filters['User_Id'] . ' OR Sent_By=' . $filters['User_Id'] . ') AND Last="1"');
        $this->db->order_by('M_Id', 'DESC');
        if (!empty($filters['search_message'])) {
            $this->db->where("( CONCAT(uf.User_First_Name, ' ', uf.User_Last_Name) LIKE '%" . $this->db->escape_str($filters['search_message']) . "%' OR CONCAT(ut.User_First_Name, ' ', ut.User_Last_Name) LIKE '%" . $this->db->escape_str($filters['search_message']) . "%' OR m.Message LIKE '%" . $this->db->escape_str($filters['search_message']) . "%')");
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    public function updatelastMessage($from = null, $to = null, $thread_id = null)
    {
        if (!empty($from) && !empty($to)) {
            $sql = "UPDATE ci_messages set Last='0' WHERE ( (Sent_By=$from AND Sent_To=$to) OR (Sent_By=$to AND Sent_To=$from) ) AND Last='1'";
            if (!empty($thread_id)) {
                $sql .= " AND Thread='" . $thread_id . "'";
            } else {
                $sql .= " AND Thread='0'";
            }

            return $this->db->query($sql);
        }
    }
}
