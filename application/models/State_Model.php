<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('state',[
            'stateCode'=>strtoupper($this->input->post('code')),
            'stateName'=>ucwords($this->input->post('state')),
            'countryid'=>$this->input->post('country'),
            'active_status'=>1,
            'delete_status'=>0]);
    }

    var $table = "state";
    var $select_column = array("country.countryId","country.countryName","state.stateId","state.stateCode","state.stateName","state.active_status","state.delete_status");
    var $order_column = array("","stateName","countryName", "active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('country','country.countryId = state.countryId');
        $this->db->where('state.delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("state.stateCode", $_POST["search"]["value"]);
                $this->db->or_like("state.stateName", $_POST["search"]["value"]);
                $this->db->or_like("country.countryName", $_POST["search"]["value"]);
                $this->db->or_like("state.active_status", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('state.stateId', 'DESC');
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
        $this->db->where('stateId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('state',['active_status'=>1]);
        }
        else
        {
            $this->db->update('state',['active_status'=>0]);
        }
    }

    function get()
    {
        return $this->db->from('state')
                    ->where('state.stateId',$this->uri->segment(4))
                    ->join('country','country.countryId = state.countryId')
                    ->get()
                    ->row();
    }


    function getall()
    {
        return $this->db->from('state')
                    ->join('country','country.countryId = state.countryId')
                    ->where('state.active_status',0)
                    ->where('state.delete_status',0)
                    ->get()
                    ->result();
    }


    function getSpecific()
    {
        return $this->db->where('countryid',$this->input->post('countryId'))
                        ->where('active_status',0)
                        ->where('delete_status',0)
                        ->get('state')
                        ->result();
    }


    function update()
    {
        $this->db->where('stateId',$this->input->post('id'))
                ->update('state',[
                    'stateCode'=>strtoupper($this->input->post('code')),
                    'stateName'=>ucwords($this->input->post('state')),
                    'countryid'=>$this->input->post('country')
            ]);
    }


    function delete()
    {
        $this->db->where('stateId',$this->uri->segment(4))
                ->update('state',['delete_status'=>1
            ]);
    }


    function checkCode()
    {
        $status = $this->db->where('stateCode',$this->input->post('code'))
                        ->where('stateId!=',$this->input->post('id'))
                        ->get('state')
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