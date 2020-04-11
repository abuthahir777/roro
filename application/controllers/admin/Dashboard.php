<?php
class Dashboard extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('State_Model','Country_Model','Airport_Model'));

		$this->page = $this->config->item("base_url_admin")."/airport";

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

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),4);
	
	}


	function index()
	{
		$this->layouts->title('Dashboard');
		$this->layouts->view('pages/admin/dashboard/dashboard','','admin');
	}

	function fetch()
	{
		$fetch_data = $this->Airport_Model->fetch_data();  
		

		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->airportCode;
			$sub_array[] = $row->airportName;
			$sub_array[] = $row->stateName;
			$sub_array[] = $row->countryName;

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
						$status = '<a href ="'.base_url('admin/airport').'/status/activate/'.$row->airportId.'" type="submit" name="delete" id="'.$row->airportId.'" class="update" ><i class="fa fa-toggle-off"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/airport').'/status/deactivate/'.$row->airportId.'" type="submit" name="delete" id="'.$row->airportId.'" class="update" ><i class="fa fa-toggle-on"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a type="submit" name="edit" id="'.$row->airportId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/airport').'/delete/'.$row->airportId.'" type="submit" name="edit" id="'.$row->airportId.'" class="edit" ><i class="fa fa-trash"></i></a>';
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
			"recordsTotal"          =>     $this->Airport_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->Airport_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function action()
	{
		if($this->input->post('action')=="save")
		{
			$this->Airport_Model->save();
			$this->session->set_flashdata('save','Saved');
		}
		else
		{
			$this->Airport_Model->update();
			$this->session->set_flashdata('update','Updated');
		}
		
		header("Location:".$this->page);
	}

	function status()
	{
		$this->Airport_Model->status();
		header("Location:".$this->page);

	}

	function delete()
	{
		$this->Airport_Model->delete();
		$this->session->set_flashdata('delete','Deleted');
		header("Location:".$this->page);
	}

	function getsingle()
	{
		$data = $this->Airport_Model->get($this->input->post("id"));

		$output['country'] = $data->countryId;
		$output['state'] = $data->stateId;
		$output['code'] = $data->airportCode;
		$output['airport'] = $data->airportName;
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