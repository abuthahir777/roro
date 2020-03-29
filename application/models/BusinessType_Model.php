<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BusinessType_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('businesstype',[
            'businessName'=>ucwords($this->input->post('businesstype')),
            'active_status'=>0,
            'delete_status'=>0]);
    }

    var $table = "businesstype";
    var $select_column = array("*");
    var $order_column = array("","businessName", "active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("businessName", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('businessName', 'ASC');
        }
    }

    function fetch_data()
    {
        $this->make_query();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    function status()
    {
        $this->db->where('businessId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('businesstype',['active_status'=>1]);
        }
        else
        {
            $this->db->update('businesstype',['active_status'=>0]);
        }
    }

    function getall()
    {
        return $this->db->where('active_status',0)
                    ->where('delete_status',0)
                    ->get('businesstype')
                    ->result();
    }

    function get($id)
    {
        return $this->db->where('businessId',$id)
                    ->get('businesstype')
                    ->row();
    }


    function update()
    {
        $this->db->where('businessId',$this->input->post('businessId'))
                ->update('businesstype',[
                    'businessName'=>ucwords($this->input->post('businesstype'))
            ]);
    }


    function delete()
    {
        $this->db->where('businessId',$this->uri->segment(4))
                ->update('businesstype',['delete_status'=>1
            ]);
    }
	
}




?>