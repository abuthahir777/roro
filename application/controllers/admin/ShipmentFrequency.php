<?php
class ShipmentFrequency extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('ShipmentFrequency_Model'));

		$this->page = $this->config->item("base_url_admin")."frequency-of-shipment";

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),7);
		

		if(!$this->session->userdata('fname') && 
			!$this->session->userdata('lname') &&
			!$this->session->userdata('userId') && 
			!$this->session->userdata('email') &&
			!$this->session->userdata('mobile') && 
			!$this->session->userdata('roleId') &&
			!$this->session->userdata('loggedin'))
		{
			header("Location:".$this->config->item("base_url_admin"));
		}
	
	}


	function index()
	{
		if(isset($this->permission['create']))
		{
			$data['create'] = "Create";			
		}else{$data['NULL'] = "";}

		$this->layouts->title('Shipment Frequency');
		$this->layouts->view('pages/admin/shipmentfrequency/table',$data,'admin');
	}

	function fetch()
	{

		$fetch_data = $this->ShipmentFrequency_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->freqShipmentName;


			if($row->active_status == 1)
			{
				$sub_array[] = '<span class="badge badge-danger">In-Active</span>';								
			}
			else
			{
				$sub_array[] = '<span class="badge badge-success">Active</span>'; 				
			}

			if(isset($this->permission))
			{
				if(isset($this->permission['view']))
				{
					$view = '';
				}
				else
				{
					$view = '';
				}

				if(isset($this->permission['status']))
				{
					if($row->active_status == 1)
					{
						$status = '<a href ="'.base_url('admin/shipmentfrequency').'/status/activate/'.$row->freqShipmentId.'" type="submit" name="delete" id="'.$row->freqShipmentId.'" class="update" ><i class="fa fa-toggle-off"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/shipmentfrequency').'/status/deactivate/'.$row->freqShipmentId.'" type="submit" name="delete" id="'.$row->freqShipmentId.'" class="update" ><i class="fa fa-toggle-on"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a type="submit" name="edit" id="'.$row->freqShipmentId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/shipmentfrequency').'/delete/'.$row->freqShipmentId.'" type="submit" name="edit" id="'.$row->freqShipmentId.'" class="edit" ><i class="fa fa-trash"></i></a>';
				}
				else
				{
					$delete = '';
				}

				$sub_array[] = '<div align="center">'.$status.'&nbsp&nbsp'.$update.'&nbsp&nbsp'.$delete.'</div>';
			}
			else
			{
				$sub_array[] = '<div align="center">NO ACTIONS ALLOWED</div>';
			}

			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->ShipmentFrequency_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->ShipmentFrequency_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function action()
	{
		if($this->input->post('action')=="save")
		{
			$this->ShipmentFrequency_Model->save();
		}
		else
		{
			$this->ShipmentFrequency_Model->update();
		}
		
		header("Location:".$this->page);
	}


	function status()
	{
		$this->ShipmentFrequency_Model->status();
		header("Location:".$this->page);

	}

	function delete()
	{
		$this->ShipmentFrequency_Model->delete();
		header("Location:".$this->page);
	}


	function getsingle()
	{
		$data = $this->ShipmentFrequency_Model->get($this->input->post("id"));

		$output['freqShipmentName'] = $data->freqShipmentName;
		echo json_encode($output);
	}


	function checkCode()
	{
		$data = $this->Airport_Model->checkCode();

		if($data)
		{
			echo "Already Exists";
		}
		else
		{
			echo "";
		}

	}

} ?>