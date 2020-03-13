<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('city',[
            'cityCode'=>$this->input->post('code'),
            'cityName'=>$this->input->post('city'),
            'stateId'=>$this->input->post('state'),
            'countryId'=>$this->input->post('country'),
            'active_status'=>1,
            'delete_status'=>0]);
    }

    var $table = "city";
    var $select_column = array("country.countryId","country.countryName","state.stateId","state.stateName","city.cityId","city.cityCode","city.cityName","city.active_status","city.delete_status");
    var $order_column = array("","cityCode","cityName","stateName","countryName", "active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('country','country.countryId = city.countryId');
        $this->db->join('state','city.stateId = state.stateId');
        $this->db->where('city.delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("state.stateName", $_POST["search"]["value"]);
                $this->db->or_like("country.countryName", $_POST["search"]["value"]);
                $this->db->or_like("state.active_status", $_POST["search"]["value"]);
                $this->db->or_like("city.cityName", $_POST["search"]["value"]);
                $this->db->or_like("city.cityCode", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('city.cityId', 'DESC');
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
        $this->db->where('cityId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('city',['active_status'=>1]);
        }
        else
        {
            $this->db->update('city',['active_status'=>0]);
        }
    }

    function get()
    {
        return $this->db->from('city')
                    ->join('country','country.countryId = city.countryId')
                    ->join('state','state.stateId = city.stateId')
                    ->where('city.cityId',$this->uri->segment(4))
                    ->get()
                    ->row();
    }


    function update()
    {
        $this->db->where('cityId',$this->input->post('id'))
                ->update('city',[
                    'cityCode'=>$this->input->post('code'),
                    'cityName'=>$this->input->post('city'),
                    'stateId'=>$this->input->post('state'),
                    'countryId'=>$this->input->post('country')
            ]);
    }


    function delete()
    {
        $this->db->where('cityId',$this->uri->segment(4))
                ->update('city',['delete_status'=>1
            ]);
    }


    function checkCode()
    {
        $status = $this->db->where('cityCode',$this->input->post('code'))
                        ->where('cityId!=',$this->input->post('id'))
                        ->get('city')
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