<?php
require_once("../main_function.php");
require_once("class/membership.php");
$obj = new operation; 
$memObj = new Membership;

if (isset($_GET['id'])) {
    $result = $obj->detailsarchclientRequest($_GET['id']);
}
// if (isset($_GET['del'])) {
//     $obj->delete_arch_client_request($_GET['del']);
// }

$status = $obj->get_all_status();
$users = $obj->get_all_users();
$district = $obj->get_district();
// $comment=$obj->arch_last_five_comments($result->id);

if (isset($_POST['submit'])) {
    // echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit();
    // var_dump($_POST);exit();
   $memObj->set_arch_request_from_admin($_POST);
   
}

// if (isset($_POST['comment'])) {
//     $obj->set_arch_comments($_POST);
// }

include_once("header.php");
include_once("menu.php");
?>

<head>

</head>
<div class="main-panel">
		<div class="container">
			<div class="page-inner">			
				<h4 class="page-title">Membership Application Form</h4>
				<div class="row arch-demo-page">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card card-with-nav">
							<div class="card-header">
			
							</div>
						<div class="card-body">
							<form  method="POST" action="" >
								<div class="row">
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Organization Name (In English)</label>
											<input type="text" class="form-control" name="institute_name" placeholder="English Name" value="">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Organization Name (In Bangla)</label>
											<input type="text" class="form-control" name="institute_bname" placeholder="Bangla Name" value="">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Beds No</label>
											<input type="number" class="form-control" name="bed_qty" placeholder="Beds No" value="">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>General Member No</label>
											<input type="number" class="form-control" name="generalmember_no" placeholder="General Member No" value="">
										</div>
									</div>

									<!-- <div class="col-md-3">
									<div class="form-group form-group-default">	
										<div class="select2-input">
											<select name="req_type" class="form-control basic">
												<option value="">Organization Type</option>
												<option value="Price">Price</option>
												<option value="Demo">Demo</option>
												<option value="camp">Campaign</option>
												<option value="Refer">Refer</option>							
											</select>
										</div>	
									</div>	
								</div> -->

								    <div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Organization Type</label>
											<div class="select2-input">	
												<select name="institute_type" class="form-control basic">
												    <option value=""> Select Type</option>							
												    <?php foreach($obj->arch_type_list() AS $key => $value){ ?>
												    <option value="<?php echo $key;?>" <?php if(!empty($result->institute_type)){ if($key==$result->institute_type){echo "SELECTED"; }} ?>><?php echo $value;?></option>
												    <?php } ?>	
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>TIN No(Tax,Identification No)</label>
											<input type="number" class="form-control" name="tin_no" placeholder="Tin No" value="">
										</div>
									</div>

									<div class="col-md-3">
                                            <div class="form-group form-group-default">
                                            <label>REG No (Hospital/Clinic/Diagnostic/Nursing Home)</label>
                                            <input type="number" class="form-control" name="reg_no" placeholder="Reg No" value="">
                                            </div>
                                    </div>

									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>TRADE LICENCE NO</label>
											<input type="number" class="form-control" name="trade_no" placeholder="Trade Licence No" value="">
										</div>
									</div>
	
									
<div class="form-group form-group-default">
    <label>IF HOSPITAL/CLINIC/NURSING HOME</label><br>
    <label for="hospital_info">Enter Data:</label>
    <input type="text" class="form-control" id="hospital_info" name="hospital_info" placeholder="1.Number of Beds, 2.Number of Doctors, 3.Number of Nurses, 4.Total Employees, 5.Consultant Chambers, 6.Resident Doctors" value="">
    <small>Enter The Numbers Accordingly To The Serial Using Comma</small>
</div>
                                   

<div class="form-group form-group-default">
        <label>IF DIAGNOSTIC CENTER, THEN CHOOSE</label><br>
        <div class="checkbox-group">
            <!-- Options for selection -->
            <div class="option-item" data-value="ecg_machine">ECG MACHINE</div>
            <div class="option-item" data-value="endoscopy_machine">ENDOSCOPY MACHINE</div>
            <div class="option-item" data-value="ultrasonogram_machine">ULTRASONOGRAM MACHINE</div>
            <div class="option-item" data-value="alyza_machine">ALYZA MACHINE</div>
            <div class="option-item" data-value="chemistry_enalyzer_machine">CHEMISTRY ENALYZER MACHINE</div>
            <div class="option-item" data-value="eco_machine">ECO MACHINE</div>
            <div class="option-item" data-value="electrolyte_machine">ELECTROLYTE MACHINE</div>
            <div class="option-item" data-value="microscop_machine">MICROSCOPE</div>
            <div class="option-item" data-value="incubator">INCUBATOR</div>
            <div class="option-item" data-value="autoclave_machine">AUTOCLAVE MACHINE</div>
            <div class="option-item" data-value="ctscan_machine">CT SCAN MACHINE</div>
            <div class="option-item" data-value="xray_machine">X-RAY MACHINE</div>
            <div class="option-item" data-value="mri_machine">MRI MACHINE</div>
            <div class="option-item" data-value="dentalxray_machine">DENTAL X-RAY MACHINE</div>
        </div>
        
        <!-- Display selected options -->
        <div id="selected-options"></div>

        <!-- Hidden input field for storing the selected values -->
        <input type="hidden" id="diagnostic_selected" name="diagnostic_selected">
    </div>


<style>
.checkbox-group {
    display: flex;
    justify-content: space-between; /* Distribute the space between the left and right columns */
}

.left-checkboxes {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Space between checkboxes */
    width: 48%; /* Adjust width to control the space */
}

.right-checkboxes {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Space between checkboxes */
    width: 48%; /* Adjust width to control the space */
}

.custom-checkbox {
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 30px;
    font-size: 16px;
}

.custom-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.custom-checkbox .checkmark {
    position: absolute;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.custom-checkbox input:checked ~ .checkmark {
    background-color: #007bff;
    border-color: #007bff;
}

.custom-checkbox .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.custom-checkbox input:checked ~ .checkmark:after {
    display: block;
}


.form-group {
            margin-bottom: 20px;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .option-item {
            cursor: pointer;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: background-color 0.3s, color 0.3s;
        }

        .option-item.selected {
            background-color: #007bff;
            color: white;
            border-color: #0056b3;
        }

        #selected-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .selected-option {
            padding: 10px 15px;
            background-color: #ffc107;
            color: black;
            border: 1px solid #ffa000;
            border-radius: 5px;
            cursor: pointer;
        }

        .selected-option:hover {
            background-color: #ffa000;
        }

</style>




<script>
        const options = document.querySelectorAll('.option-item');
        const selectedOptionsContainer = document.getElementById('selected-options');
        const hiddenInput = document.getElementById('diagnostic_selected');
        let selectedValues = [];

        // Add click event to each option
        options.forEach(option => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value');

                if (selectedValues.includes(value)) {
                    // Remove if already selected
                    selectedValues = selectedValues.filter(item => item !== value);
                    option.classList.remove('selected');
                    removeSelectedOption(value);
                } else {
                    // Add new selection
                    selectedValues.push(value);
                    option.classList.add('selected');
                    addSelectedOption(value, option.textContent);
                }

                // Update hidden input with the selected values
                hiddenInput.value = selectedValues.join(', ');

                // Automatically save data to the server
                saveDataToServer(selectedValues);
            });
        });

        // Add a new selected option to the display
        function addSelectedOption(value, text) {
            const optionDiv = document.createElement('div');
            optionDiv.classList.add('selected-option');
            optionDiv.setAttribute('data-value', value);
            optionDiv.textContent = text;
            optionDiv.addEventListener('click', () => {
                // Trigger the same click event on the corresponding option-item
                document.querySelector(`.option-item[data-value="${value}"]`).click();
            });
            selectedOptionsContainer.appendChild(optionDiv);
        }

        // Remove a selected option from the display
        function removeSelectedOption(value) {
            const optionToRemove = selectedOptionsContainer.querySelector(`.selected-option[data-value="${value}"]`);
            if (optionToRemove) {
                selectedOptionsContainer.removeChild(optionToRemove);
            }
        }

        // Function to save data to the server using Fetch API
        function saveDataToServer(selectedValues) {
            fetch('/save-diagnostic-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ diagnostic_services: selectedValues }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Data successfully saved:', data);
            })
            .catch(error => {
                console.error('Error saving data:', error);
            });
        }
    </script>


									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Status</label>
											<div class="select2-input">	
												<select name="status" class="form-control basic3">
												    <option value="" >Select Status</option>							
												    <?php foreach($status as $sts){ ?>
												    <option value="<?php echo $sts->id;?>" <?php if(!empty($result->status)){ if($sts->id==$result->status){echo "SELECTED"; }} ?>><?php echo $sts->name;?></option>
												    <?php } ?>	
												</select>
											</div>
										</div>
									</div>
								<!-- <div class="col-md-3">
									<div class="form-group form-group-default">	
										<div class="select2-input">
											<select name="req_type" class="form-control basic">
												<option value="">Query Type</option>
												<option value="Price">Price</option>
												<option value="Demo">Demo</option>
												<option value="camp">Campaign</option>
												<option value="Refer">Refer</option>							
											</select>
										</div>	
									</div>	
								</div> -->

								<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>PAY-ORDER/BANK DRAFT NO</label>
											<input type="number" class="form-control" name="payorder_no" placeholder="Reg No" value="">
										</div>
									</div>																   																

									<div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Applicant Name <sup style="color: red; ">*</sup></label>
											<input type="text" class="form-control" name="name" placeholder="Name" value="">
									
										</div>
									</div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                        <label>Application Date</label>
                                        <input type="date" class="form-control" id="application_date" name="application_date" placeholder="YYYY-MM-DD">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Proposer Company <sup style="color: red; ">*</sup></label>
											<input type="text" class="form-control" name="proposer_company" placeholder="Name" value="">				
										</div>
									</div>

                                    <div class="col-md-3">
										<div class="form-group form-group-default">
											<label>Proposer Name <sup style="color: red; ">*</sup></label>
											<input type="text" class="form-control" name="proposer_name" placeholder="Name" value="">				
										</div>
									</div>

					         	</div>
								<div class="text-right mt-3 mb-3">
						        	<button type="submit" name="submit" class="btn btn-success btn-rounded btn-login">Save </button>						
									<a href="arch-request.php" class="btn btn-warning btn-rounded">Back</a>
								</div>
							</form>
						</div>
						</div>
					</div>
				
				</div>
			</div>
		</div>
    <?php include_once("footer.php"); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            /* Populate data to state dropdown */
            $('#addDistricts').on('change', function () {
                var countryID = $(this).val();
                if (countryID) {
                    $.ajax({
                        type: 'GET',
                        url: '../witty/ajaxdata.php',
                        data: 'district_id=' + countryID,
                        success: function (data) {
                            $('#addThanas').html('<option value="">Select Thana</option>');
                            var dataObj = jQuery.parseJSON(data);
                            if (dataObj) {
                                $(dataObj).each(function () {
                                    var option = $('<option />');
                                    option.attr('value', this.id).text(this.name);
                                    $('#addThanas').append(option);
                                });

                            } else {

                                $('#addThanas').html('<option value="">State not available</option>');
                            }
                        }
                    });
                } else {
                    $('#addThanas').html('<option value="">Select country first</option>');
                }
            });
        });
    </script>



    <script>
        // Ensure the entered value follows the YYYY-MM-DD format
        document.getElementById('application_date').addEventListener('input', function (e) {
            const value = e.target.value;
            const regex = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;

            if (!regex.test(value)) {
                e.target.setCustomValidity("Please enter a date in the format YYYY-MM-DD");
            } else {
                e.target.setCustomValidity("");
            }
        });
    </script>