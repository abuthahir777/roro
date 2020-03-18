<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function countryInsert($countryCode,$countryName)
    {
        $this->db->insert('country',[
            'countryCode'=>ucfirst($countryCode),
            'countryName'=>ucfirst($countryName),
            'active_status'=>0,
            'delete_status'=>0]);
    }

    function countryCheck($countryCode,$countryName)
    {
        $status = $this->db->where('countryCode',$countryCode)
                        ->get('country')
                        ->num_rows();

        if($status >=1)
        {
            return $this->countryGet($countryCode);
        }

    }

    function countryGet($countryCode)
    {
        return $this->db->where('countryCode',$countryCode)
                    ->get('country')
                    ->row();
    }

    function stateInsert($countryId,$stateCode,$stateName)
    {
        $this->db->insert('state',[
            'stateCode'=>ucfirst($stateCode),
            'stateName'=>ucfirst($stateName),
            'countryId'=>ucfirst($countryId),
            'active_status'=>0,
            'delete_status'=>0]);
    }


    function stateCheck($countryId,$stateCode,$stateName)
    {
        $status = $this->db->where('countryId',$countryId)
                        ->or_group_start()
                            ->where('stateCode',$stateName)
                            ->where('stateName',$stateCode)
                        ->group_end()
                        ->get('state')
                        ->num_rows();

        if($status >=1)
        {
            return $this->stateGet($countryId,$stateCode);
        }
        else
        {
            return false;
        }
    }


    function stateGet($countryId,$stateCode)
    {
        return $this->db->where('stateCode',$stateCode)
                    ->where('countryId',$countryId)
                    ->get('state')
                    ->row();
    }





    function cityInsert($countryId,$stateId,$cityCode,$cityName)
    {
        $this->db->insert('city',[
            'cityCode'=>ucfirst($cityCode),
            'cityName'=>ucfirst($cityName),
            'stateId'=>ucfirst($stateId),
            'countryId'=>ucfirst($countryId),
            'active_status'=>0,
            'delete_status'=>0]);
    }

    function cityCheck($countryId,$stateId,$cityCode)
    {
        $status = $this->db->where('cityCode',$cityCode)
                        ->where('countryId',$countryId)
                        ->where('stateId',$stateId)
                        ->get('city')
                        ->num_rows();

        if($status >=1)
        {
            return $this->cityGet($countryId,$stateId,$cityCode);
        }
        else
        {
            return false;
        }
    }

    function cityGet($countryId,$stateId,$cityCode)
    {
        return $this->db->where('cityCode',$cityCode)
                    ->where('countryId',$countryId)
                    ->where('stateId',$stateId)
                    ->get('city')
                    ->row();
    }


}

?>