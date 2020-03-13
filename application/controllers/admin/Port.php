<?php
class Port extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('State_Model','Country_Model','Port_Model'));

		$this->load->library(array('Layouts'));

		$this->page = $this->config->item("base_url")."/admin/port";
	
	}


	function index()
	{
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/port/table','','admin');
	}

	function fetch()
	{
		$fetch_data = $this->Port_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->portCode;
			$sub_array[] = $row->portName;
			$sub_array[] = $row->stateName;
			$sub_array[] = $row->countryName;

			if($row->active_status == 1)
			{
				$sub_array[] = '<span class="badge badge-danger">In-Active</span>';
				$status = '<a href ="'.base_url('admin/port').'/status/activate/'.$row->portId.'" type="submit" name="delete" id="'.$row->portId.'" class="update" ><i class="fa fa-check-square"></i></a>';
			}
			else
			{
				$sub_array[] = '<span class="badge badge-success">Active</span>'; 
				$status = '<a href ="'.base_url('admin/port').'/status/deactivate/'.$row->portId.'" type="submit" name="delete" id="'.$row->portId.'" class="update" ><i class="fa fa-check"></i></a>';
			}


			$sub_array[] = '<div align="center">
			'.$status.'&nbsp&nbsp
			<a href ="'.base_url('admin/port').'/edit/'.$row->portId.'" type="submit" name="edit" id="'.$row->portId.'" class="edit" ><i class="fa fa-edit"></i></a>
			&nbsp&nbsp
			<a href ="'.base_url('admin/port').'/delete/'.$row->portId.'" type="submit" name="edit" id="'.$row->portId.'" class="edit" ><i class="fa fa-trash"></i></a>
			</div>';   
			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->Port_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->Port_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['country'] = $this->Country_Model->getall();
		$data['state'] = $this->State_Model->getall();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/port/form',$data,'admin');
	}

	function save()
	{
		$this->Port_Model->save();
		header("Location:".$this->page);
	}


	function status()
	{
		$this->Port_Model->status();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['port'] = $this->Port_Model->get();
		$data['states'] = $this->State_Model->getall();
		$data['countries'] = $this->Country_Model->getall();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/port/form',$data,'admin');
	}

	function update()
	{
		$this->Port_Model->update();
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->Port_Model->delete();
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
		$data = $this->Port_Model->checkCode();

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