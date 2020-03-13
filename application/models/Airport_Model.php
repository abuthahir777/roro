<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airport_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('airport',[
            'airportCode'=>$this->input->post('code'),
            'airportName'=>$this->input->post('airport'),
            'stateId'=>$this->input->post('state'),
            'countryId'=>$this->input->post('country'),
            'active_status'=>1,
            'delete_status'=>0]);
    }

    var $table = "airport";
    var $select_column = array("country.countryId","country.countryName","state.stateId","state.stateName","airport.airportId","airport.airportCode","airport.airportName","airport.active_status","airport.delete_status");
    var $order_column = array("","airport.airportCode","airport.airportName","state.stateName","country.countryName", "airport.active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('country','country.countryId = airport.countryId');
        $this->db->join('state','airport.stateId = state.stateId');
        $this->db->where('airport.delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("state.stateName", $_POST["search"]["value"]);
                $this->db->or_like("country.countryName", $_POST["search"]["value"]);
                $this->db->or_like("state.active_status", $_POST["search"]["value"]);
                $this->db->or_like("airport.airportName", $_POST["search"]["value"]);
                $this->db->or_like("airport.airportCode", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('airport.airportId', 'DESC');
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
        $this->db->where('airportId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('airport',['active_status'=>1]);
        }
        else
        {
            $this->db->update('airport',['active_status'=>0]);
        }
    }

    function get()
    {
        return $this->db->from('airport')
                    ->join('country','country.countryId = airport.countryId')
                    ->join('state','state.stateId = airport.stateId')
                    ->where('airport.airportId',$this->uri->segment(4))
                    ->get()
                    ->row();
    }


    function update()
    {
        $this->db->where('airportId',$this->input->post('id'))
                ->update('airport',[
                    'airportCode'=>$this->input->post('code'),
                    'airportName'=>$this->input->post('airport'),
                    'stateId'=>$this->input->post('state'),
                    'countryId'=>$this->input->post('country')
            ]);
    }


    function delete()
    {
        $this->db->where('airportId',$this->uri->segment(4))
                ->update('airport',['delete_status'=>1
            ]);
    }


    function checkCode()
    {
        $status = $this->db->where('airportCode',$this->input->post('code'))
                        ->where('airportId!=',$this->input->post('id'))
                        ->get('airport')
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