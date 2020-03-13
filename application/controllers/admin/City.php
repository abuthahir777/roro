<?php
class City extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('State_Model','Country_Model','City_Model'));

		$this->load->library(array('Layouts'));

		$this->page = $this->config->item("base_url")."/admin/city";
	
	}


	function index()
	{
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/city/table','','admin');
	}

	function fetch()
	{
		$fetch_data = $this->City_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->cityCode;
			$sub_array[] = $row->cityName;
			$sub_array[] = $row->stateName;
			$sub_array[] = $row->countryName;

			if($row->active_status == 1)
			{
				$sub_array[] = '<span class="badge badge-danger">In-Active</span>';
				$status = '<a href ="'.base_url('admin/city').'/status/activate/'.$row->cityId.'" type="submit" name="delete" id="'.$row->cityId.'" class="update" ><i class="fa fa-check-square"></i></a>';
			}
			else
			{
				$sub_array[] = '<span class="badge badge-success">Active</span>'; 
				$status = '<a href ="'.base_url('admin/city').'/status/deactivate/'.$row->cityId.'" type="submit" name="delete" id="'.$row->cityId.'" class="update" ><i class="fa fa-check"></i></a>';
			}


			$sub_array[] = '<div align="center">
			'.$status.'&nbsp&nbsp
			<a href ="'.base_url('admin/city').'/edit/'.$row->cityId.'" type="submit" name="edit" id="'.$row->cityId.'" class="edit" ><i class="fa fa-edit"></i></a>
			&nbsp&nbsp
			<a href ="'.base_url('admin/city').'/delete/'.$row->cityId.'" type="submit" name="edit" id="'.$row->cityId.'" class="edit" ><i class="fa fa-trash"></i></a>
			</div>';   
			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->City_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->City_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['country'] = $this->Country_Model->getall();
		$data['state'] = $this->State_Model->getall();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/city/form',$data,'admin');
	}

	function save()
	{
		$this->City_Model->save();
		header("Location:".$this->page);
	}


	function status()
	{
		$this->City_Model->status();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['city'] = $this->City_Model->get();
		$data['states'] = $this->State_Model->getall();
		$data['countries'] = $this->Country_Model->getall();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/city/form',$data,'admin');
	}

	function update()
	{
		$this->City_Model->update();
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->City_Model->delete();
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
		$data = $this->City_Model->checkCode();

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