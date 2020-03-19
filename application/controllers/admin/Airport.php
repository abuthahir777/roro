<?php
class Airport extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('State_Model','Country_Model','Airport_Model'));

		$this->page = $this->config->item("base_url_admin")."airport";

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

		if(isset($permission['create']))
		{
			$data['create'] = "Create";
		}
		else
		{
			$data = "";
		}
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/airport/table',$data,'admin');
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
						$status = '<a href ="'.base_url('admin/airport').'/status/activate/'.$row->airportId.'" type="submit" name="delete" id="'.$row->airportId.'" class="update" ><i class="fa fa-check"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/airport').'/status/deactivate/'.$row->airportId.'" type="submit" name="delete" id="'.$row->airportId.'" class="update" ><i class="fa fa-check"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a href ="'.base_url('admin/airport').'/edit/'.$row->airportId.'" type="submit" name="edit" id="'.$row->airportId.'" class="edit" ><i class="fa fa-edit"></i></a>';
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

	function add()
	{
		$data['country'] = $this->Country_Model->getall();
		$data['state'] = $this->State_Model->getall();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/airport/form',$data,'admin');
	}

	function save()
	{
		$this->Airport_Model->save();
		header("Location:".$this->page);
	}


	function status()
	{
		$this->Airport_Model->status();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['airport'] = $this->Airport_Model->get();
		$data['states'] = $this->State_Model->getall();
		$data['countries'] = $this->Country_Model->getall();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/airport/form',$data,'admin');
	}

	function update()
	{
		$this->Airport_Model->update();
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->Airport_Model->delete();
		header("Location:".$this->page);
	}


	function fetchState()
	{
		$states = $this->State_Model->getSpecific();

		if($states)
		{
			echo '<option value="">Select State</option>';
			foreach($states as $row)
			{
				echo '<option value="'.$row->stateId.'">'.$row->stateName.'</option>';
			}
		}
		else
		{
			echo '<option value="">No States Entered</option>';
		}
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