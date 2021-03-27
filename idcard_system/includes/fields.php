<?php

	if(!defined('FIELD_NAME')) define('FIELD_NAME', 'name');
	if(!defined('FIELD_MOBILE')) define('FIELD_MOBILE', 'mobile');
	if(!defined('FIELD_EMERGENCY')) define('FIELD_EMERGENCY', 'emergency');
	if(!defined('FIELD_ADDRESS')) define('FIELD_ADDRESS', 'address');
	if(!defined('FIELD_EMAIL')) define('FIELD_EMAIL', 'email');
	if(!defined('FIELD_IMAGE')) define('FIELD_IMAGE', 'image');
	if(!defined('FIELD_DATE_OF_BIRTH')) define('FIELD_DATE_OF_BIRTH', 'date_of_birth');
	if(!defined('FIELD_BLOOD_GROUP')) define('FIELD_BLOOD_GROUP', 'blood_group');
	if(!defined('FIELD_EMP_ID')) define('FIELD_EMP_ID', 'emp_id');
	if(!defined('FIELD_DEPARTMENT')) define('FIELD_DEPARTMENT', 'department');
	if(!defined('FIELD_DESIGNATION')) define('FIELD_DESIGNATION', 'designation');
	if(!defined('FIELD_DATE_OF_ISSUE')) define('FIELD_DATE_OF_ISSUE', 'date_of_issue');
	if(!defined('FIELD_DATE_OF_EXPIRY')) define('FIELD_DATE_OF_EXPIRY', 'date_of_expiry');
	if(!defined('FIELD_QR')) define('FIELD_QR', 'qr');
	if(!defined('FIELD_SIGN')) define('FIELD_SIGN', 'sign');
	
	// function addEmployeeFormWithCustomFields(){
		
	// }

	

	function getFieldName($label){

		$excel_field_name_set = array(
			'Name',
			'NAME'
		);

		$excel_field_mobile_set = array(
			'Mobile',
			'mobile',
			'Mobile No',
			'MOBILE',
			'MOBILE NO'
		);

		$excel_field_emc_set = array(
			'EMERGENCY',
			'Emergency Contact No',
			'Emergency Mobile No',
			'emergency contact no',
			'Emergency',
			'emergency'
		);

		$excel_field_address_set = array(
			'Address',
			'ADDRESS'
		);

		$excel_field_email_set = array(
			'Email',
			'EMAIL'
		);

		$excel_field_image_set = array(
			'Image',
			'IMAGE'
		);

		$excel_field_dob_set = array(
			'Date of Birth',
			'Date of birth',
			'DATE OF BIRTH'
		);

		$excel_field_blood_set = array(
			'Blood group',
			'BLOOD GROUP',
			'Blood Group'
		);

		$excel_field_dept_set = array(
			'Department',
			'DEPARTMENT'
		);

		$excel_field_desig_set = array(
			'Designation',
			'DESIGNATION'
		);

		$excel_field_doi_set = array(
			'Date of issue',
			'DATE OF ISSUE',
			'Date of Issue'
		);

		$excel_field_doe_set = array(
			'Date of expiry',
			'DATE OF EXPIRY',
			'Date of Expiry'
		);
		$excel_field_empid_set = array(
			'Emp Id',
			'EMP ID',
			'Employee ID',
			'Employee Id',
			'EMPLOYEE ID',
			'Employee id'
		);

		$excel_field_sign_set = array(
			'Signature',
			'SIGNATURE',
			'Sign',
			'SIGN'
		);

		if(in_array($label,$excel_field_name_set)) return FIELD_NAME;

		if(in_array($label,$excel_field_mobile_set)) return FIELD_MOBILE;

		if(in_array($label,$excel_field_emc_set)) return FIELD_EMERGENCY;

		if(in_array($label,$excel_field_address_set)) return FIELD_ADDRESS;

		if(in_array($label,$excel_field_email_set)) return FIELD_EMAIL;

		if(in_array($label,$excel_field_image_set)) return FIELD_IMAGE;

		if(in_array($label,$excel_field_dob_set)) return FIELD_DATE_OF_BIRTH;

		if(in_array($label,$excel_field_blood_set)) return FIELD_BLOOD_GROUP;

		if(in_array($label,$excel_field_dept_set)) return FIELD_DEPARTMENT;

		if(in_array($label,$excel_field_desig_set)) return FIELD_DESIGNATION;

		if(in_array($label,$excel_field_empid_set)) return FIELD_EMP_ID;

		if(in_array($label,$excel_field_sign_set)) return FIELD_SIGN;

		if(in_array($label,$excel_field_doe_set)) return FIELD_DATE_OF_EXPIRY;

		if(in_array($label,$excel_field_doi_set)) return FIELD_DATE_OF_ISSUE;

		return 0;
	}

	function getFieldLabel($field_name){

		switch ($field_name) {
			case FIELD_NAME:
				return "Name";

			case FIELD_MOBILE:
				return "Mobile No";

			case FIELD_BLOOD_GROUP:
				return "Blood Group";	

			case FIELD_EMERGENCY:
				return "Emergency";

			
			case FIELD_DATE_OF_BIRTH:
				return "Date Of Birth";

			case FIELD_ADDRESS:
				return "Address";

			case FIELD_EMAIL:
				return "Email";	

			case FIELD_IMAGE:
				return "Image";

			case FIELD_EMP_ID:
				return "Emp ID";					

			case FIELD_DEPARTMENT:
				return "Department";

			case FIELD_DESIGNATION:
				return "Designation";		
			
			case FIELD_DATE_OF_ISSUE:
				return "Date of Issue";

			case FIELD_DATE_OF_EXPIRY:
				return "Date of Expiry";

			case FIELD_SIGN:
				return "Signature:";	
							
			default:
				return "";
		}
	}

	// echo getFieldName('Employee id');
	// getFieldLabel('date_of_issue');
?>