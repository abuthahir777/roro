<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('country',[
            'countryCode'=>strtoupper($this->input->post('code')),
            'countryName'=>ucwords($this->input->post('country')),
            'active_status'=>1,
            'delete_status'=>0]);
    }

    var $table = "country";
    var $select_column = array("*");
    var $order_column = array("","countryCode","countryName", "active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("countryCode", $_POST["search"]["value"]);
                $this->db->or_like("countryName", $_POST["search"]["value"]);
                $this->db->or_like("active_status", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('countryId', 'DESC');
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
        $this->db->where('countryId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('country',['active_status'=>1]);
        }
        else
        {
            $this->db->update('country',['active_status'=>0]);
        }
    }

    function getall()
    {
        return $this->db->where('active_status',0)
                    ->where('delete_status',0)
                    ->get('country')
                    ->result();
    }

    function get()
    {
        return $this->db->where('countryId',$this->uri->segment(4))
                    ->get('country')
                    ->row();
    }


    function update()
    {
        $this->db->where('countryId',$this->input->post('id'))
                ->update('country',[
                    'countryCode'=>strtoupper($this->input->post('code')),
                    'countryName'=>ucwords($this->input->post('country'))
            ]);
    }


    function delete()
    {
        $this->db->where('countryId',$this->uri->segment(4))
                ->update('country',['delete_status'=>1
            ]);
    }


    function checkCode()
    {
        $status = $this->db->where('countryCode',$this->input->post('code'))
                        ->where('countryId!=',$this->input->post('id'))
                        ->get('country')
                        ->num_rows();

        if($status >=1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	
}




?>