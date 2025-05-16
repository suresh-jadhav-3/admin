<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	if (isset($_POST['submit'])) {
		$vehicletitle = $_POST['vehicletitle'];
		$brand = $_POST['brandname'];
		$vehicleoverview = $_POST['vehicalorcview'];
		$priceperday = $_POST['priceperday'];
		$fueltype = $_POST['fueltype'];
		$modelyear = $_POST['modelyear'];
		$seatingcapacity = $_POST['seatingcapacity'];
		$vimage1 = $_FILES["img1"]["name"];
		$vimage2 = $_FILES["img2"]["name"];
		$vimage3 = $_FILES["img3"]["name"];
		$vimage4 = $_FILES["img4"]["name"];
		$vimage5 = $_FILES["img5"]["name"];
		$airconditioner = $_POST['airconditioner'];
		$powerdoorlocks = $_POST['powerdoorlocks'];
		$antilockbrakingsys = $_POST['antilockbrakingsys'];
		$brakeassist = $_POST['brakeassist'];
		$powersteering = $_POST['powersteering'];
		$driverairbag = $_POST['driverairbag'];
		$passengerairbag = $_POST['passengerairbag'];
		$powerwindow = $_POST['powerwindow'];
		$cdplayer = $_POST['cdplayer'];
		$centrallocking = $_POST['centrallocking'];
		$crashcensor = $_POST['crashcensor'];
		$leatherseats = $_POST['leatherseats'];
		move_uploaded_file($_FILES["img1"]["tmp_name"], "img/vehicleimages/" . $_FILES["img1"]["name"]);
		move_uploaded_file($_FILES["img2"]["tmp_name"], "img/vehicleimages/" . $_FILES["img2"]["name"]);
		move_uploaded_file($_FILES["img3"]["tmp_name"], "img/vehicleimages/" . $_FILES["img3"]["name"]);
		move_uploaded_file($_FILES["img4"]["tmp_name"], "img/vehicleimages/" . $_FILES["img4"]["name"]);
		move_uploaded_file($_FILES["img5"]["tmp_name"], "img/vehicleimages/" . $_FILES["img5"]["name"]);

		$sql = "INSERT INTO tblvehicles(VehiclesTitle,VehiclesBrand,VehiclesOverview,PricePerDay,FuelType,ModelYear,SeatingCapacity,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5,AirConditioner,PowerDoorLocks,AntiLockBrakingSystem,BrakeAssist,PowerSteering,DriverAirbag,PassengerAirbag,PowerWindows,CDPlayer,CentralLocking,CrashSensor,LeatherSeats) VALUES(:vehicletitle,:brand,:vehicleoverview,:priceperday,:fueltype,:modelyear,:seatingcapacity,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5,:airconditioner,:powerdoorlocks,:antilockbrakingsys,:brakeassist,:powersteering,:driverairbag,:passengerairbag,:powerwindow,:cdplayer,:centrallocking,:crashcensor,:leatherseats)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
		$query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
		$query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
		$query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
		$query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
		$query->bindParam(':vimage1', $vimage1, PDO::PARAM_STR);
		$query->bindParam(':vimage2', $vimage2, PDO::PARAM_STR);
		$query->bindParam(':vimage3', $vimage3, PDO::PARAM_STR);
		$query->bindParam(':vimage4', $vimage4, PDO::PARAM_STR);
		$query->bindParam(':vimage5', $vimage5, PDO::PARAM_STR);
		$query->bindParam(':airconditioner', $airconditioner, PDO::PARAM_STR);
		$query->bindParam(':powerdoorlocks', $powerdoorlocks, PDO::PARAM_STR);
		$query->bindParam(':antilockbrakingsys', $antilockbrakingsys, PDO::PARAM_STR);
		$query->bindParam(':brakeassist', $brakeassist, PDO::PARAM_STR);
		$query->bindParam(':powersteering', $powersteering, PDO::PARAM_STR);
		$query->bindParam(':driverairbag', $driverairbag, PDO::PARAM_STR);
		$query->bindParam(':passengerairbag', $passengerairbag, PDO::PARAM_STR);
		$query->bindParam(':powerwindow', $powerwindow, PDO::PARAM_STR);
		$query->bindParam(':cdplayer', $cdplayer, PDO::PARAM_STR);
		$query->bindParam(':centrallocking', $centrallocking, PDO::PARAM_STR);
		$query->bindParam(':crashcensor', $crashcensor, PDO::PARAM_STR);
		$query->bindParam(':leatherseats', $leatherseats, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			$msg = "Vehicle posted successfully";
		} else {
			$error = "Something went wrong. Please try again";
		}
	}
?>
	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">

		<title>Car Rental Portal | Admin Post Vehicle</title>

		<!-- Custom CSS
  <link rel="stylesheet" href="css/admin-styles.css">
  <link rel="stylesheet" href="css/form-styles.css"> -->
		<style>
			/* Root Variables */
			:root {
				--primary: #1e40af;
				--primary-light: #3b82f6;
				--primary-dark: #1e3a8a;
				--secondary: #64748b;
				--success: #10b981;
				--warning: #f59e0b;
				--danger: #ef4444;
				--light: #f8fafc;
				--dark: #1e293b;
				--gray-100: #f1f5f9;
				--gray-200: #e2e8f0;
				--gray-300: #cbd5e1;
				--gray-400: #94a3b8;
				--gray-500: #64748b;
				--gray-600: #475569;
				--gray-700: #334155;
				--gray-800: #1e293b;
				--gray-900: #0f172a;
				--border-radius: 0.375rem;
				--box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
				--transition: all 0.2s ease-in-out;
			}

			/* Reset & Base Styles */
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
				color: var(--gray-800);
				background-color: var(--gray-100);
				line-height: 1.5;
			}

			/* Layout */
			.main-content {
				display: flex;
				min-height: calc(100vh - 64px);
			}

			.content-wrapper {
				flex: 1;
				padding: 1.5rem;
				max-width: 100%;
			}

			.container {
				width: 100%;
				max-width: 1200px;
				margin: 0 auto;
			}

		


			/* Form Styles */
			.form-group {
				margin-bottom: 1.5rem;
			}

			.form-label {
				display: block;
				margin-bottom: 0.5rem;
				font-weight: 500;
				color: var(--gray-700);
			}

			.form-label .required {
				color: var(--danger);
				margin-left: 0.25rem;
			}

			.form-control {
				display: block;
				width: 100%;
				padding: 0.625rem 0.75rem;
				font-size: 0.875rem;
				line-height: 1.5;
				color: var(--gray-800);
				background-color: white;
				border: 1px solid var(--gray-300);
				border-radius: var(--border-radius);
				transition: var(--transition);
			}

			.form-control:focus {
				border-color: var(--primary-light);
				outline: 0;
				box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
			}

			/* File Upload */
			.file-upload {
				position: relative;
				display: inline-block;
				width: 100%;
			}

			.file-upload-label {
				display: block;
				padding: 0.625rem 0.75rem;
				background-color: white;
				color: var(--gray-600);
				border: 1px solid var(--gray-300);
				border-radius: var(--border-radius);
				text-align: center;
				cursor: pointer;
			}

			.file-upload input[type="file"] {
				position: absolute;
				left: 0;
				top: 0;
				opacity: 0;
				width: 100%;
				height: 100%;
				cursor: pointer;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				font-weight: 500;
				text-align: center;
				padding: 0.625rem 1.25rem;
				font-size: 0.875rem;
				line-height: 1.5;
				border-radius: var(--border-radius);
				transition: var(--transition);
				border: 1px solid transparent;
				cursor: pointer;
			}

			.btn-primary {
				color: white;
				background-color: var(--primary);
				border-color: var(--primary);
			}

			.btn-primary:hover {
				background-color: var(--primary-dark);
				border-color: var(--primary-dark);
			}

			.btn-default {
				color: var(--gray-700);
				background-color: white;
				border-color: var(--gray-300);
			}

			.btn-default:hover {
				background-color: var(--gray-100);
				border-color: var(--gray-400);
			}

			/* Panels */
			.panel {
				background-color: white;
				border-radius: var(--border-radius);
				box-shadow: var(--box-shadow);
				margin-bottom: 1.5rem;
			}

			.panel-header {
				padding: 1rem 1.5rem;
				border-bottom: 1px solid var(--gray-200);
				font-weight: 600;
			}

			.panel-body {
				padding: 1.5rem;
			}

			/* Alerts */
			.alert {
				padding: 0.75rem 1.25rem;
				margin-bottom: 1rem;
				border-radius: var(--border-radius);
				display: flex;
				align-items: center;
			}

			.alert-success {
				background-color: rgba(16, 185, 129, 0.1);
				border-left: 4px solid var(--success);
				color: #065f46;
			}

			.alert-error {
				background-color: rgba(239, 68, 68, 0.1);
				border-left: 4px solid var(--danger);
				color: #b91c1c;
			}

			/* Grid System */
			.row {
				display: flex;
				flex-wrap: wrap;
				margin: 0 -0.75rem;
			}

			.col {
				flex: 1;
				padding: 0 0.75rem;
			}

			[class*="col-"] {
				padding: 0 0.75rem;
			}

			.col-12 {
				flex: 0 0 100%;
				max-width: 100%;
			}

			.col-6 {
				flex: 0 0 50%;
				max-width: 50%;
			}

			.col-4 {
				flex: 0 0 33.333333%;
				max-width: 33.333333%;
			}

			.col-3 {
				flex: 0 0 25%;
				max-width: 25%;
			}

			/* Responsive */
			@media (max-width: 992px) {
				.col-lg-6 {
					flex: 0 0 50%;
					max-width: 50%;
				}

				.col-lg-12 {
					flex: 0 0 100%;
					max-width: 100%;
				}
			}

			@media (max-width: 768px) {
				.menu-toggle {
					display: flex;
				}

				.brand-logo {
					font-size: 1.25rem;
				}

				.header-container {
					padding: 0.75rem 1rem;
				}

				.sidebar {
					position: fixed;
					left: -280px;
					transition: left 0.3s ease;
					z-index: 99;
				}

				.sidebar.active {
					left: 0;
				}

				.col-md-6 {
					flex: 0 0 50%;
					max-width: 50%;
				}

				.col-md-12 {
					flex: 0 0 100%;
					max-width: 100%;
				}

				.content-wrapper {
					padding: 1rem;
				}
			}

			@media (max-width: 576px) {
				.col-sm-12 {
					flex: 0 0 100%;
					max-width: 100%;
				}

				.row {
					margin: 0 -0.5rem;
				}

				[class*="col-"] {
					padding: 0 0.5rem;
				}
			}
		</style>
	</head>

	<body>
		<?php include('includes/header.php'); ?>
		<div class="main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container">
					<h2 class="page-title">Post A Vehicle</h2>

					<?php if ($error) { ?>
						<div class="alert alert-error"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
					<?php } else if ($msg) { ?>
						<div class="alert alert-success"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
					<?php } ?>

					<div class="panel">
						<div class="panel-header">Basic Info</div>
						<div class="panel-body">
							<form method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label class="form-label">Vehicle Title<span class="required">*</span></label>
											<input type="text" name="vehicletitle" class="form-control" required>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label class="form-label">Select Brand<span class="required">*</span></label>
											<select class="form-control" name="brandname" required>
												<option value=""> Select </option>
												<?php
												$ret = "select id,BrandName from tblbrands";
												$query = $dbh->prepare($ret);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												if ($query->rowCount() > 0) {
													foreach ($results as $result) { ?>
														<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?></option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="form-label">Vehicle Overview<span class="required">*</span></label>
									<textarea class="form-control" name="vehicalorcview" rows="3" required></textarea>
								</div>

								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label class="form-label">Price Per Day (in USD)<span class="required">*</span></label>
											<input type="text" name="priceperday" class="form-control" required>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label class="form-label">Select Fuel Type<span class="required">*</span></label>
											<select class="form-control" name="fueltype" required>
												<option value=""> Select </option>
												<option value="Petrol">Petrol</option>
												<option value="Diesel">Diesel</option>
												<option value="CNG">CNG</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label class="form-label">Model Year<span class="required">*</span></label>
											<input type="text" name="modelyear" class="form-control" required>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="form-group">
											<label class="form-label">Seating Capacity<span class="required">*</span></label>
											<input type="text" name="seatingcapacity" class="form-control" required>
										</div>
									</div>
								</div>

								<hr class="hr-divider">

								<h3 class="section-heading">Upload Images</h3>

								<div class="row">
									<div class="col-md-4 col-sm-6 col-12 mb-4">
										<div class="form-group">
											<label class="form-label">Image 1<span class="required">*</span></label>
											<div class="file-upload">
												<label class="file-upload-label">Choose File</label>
												<input type="file" name="img1" required>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-6 col-12 mb-4">
										<div class="form-group">
											<label class="form-label">Image 2<span class="required">*</span></label>
											<div class="file-upload">
												<label class="file-upload-label">Choose File</label>
												<input type="file" name="img2" required>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-6 col-12 mb-4">
										<div class="form-group">
											<label class="form-label">Image 3<span class="required">*</span></label>
											<div class="file-upload">
												<label class="file-upload-label">Choose File</label>
												<input type="file" name="img3" required>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 col-sm-6 col-12 mb-4">
										<div class="form-group">
											<label class="form-label">Image 4<span class="required">*</span></label>
											<div class="file-upload">
												<label class="file-upload-label">Choose File</label>
												<input type="file" name="img4" required>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-6 col-12 mb-4">
										<div class="form-group">
											<label class="form-label">Image 5</label>
											<div class="file-upload">
												<label class="file-upload-label">Choose File</label>
												<input type="file" name="img5">
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>

					<div class="panel">
						<div class="panel-header">Accessories</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="airconditioner" name="airconditioner" value="1">
										<label class="form-check-label" for="airconditioner">Air Conditioner</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="powerdoorlocks" name="powerdoorlocks" value="1">
										<label class="form-check-label" for="powerdoorlocks">Power Door Locks</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="antilockbrakingsys" name="antilockbrakingsys" value="1">
										<label class="form-check-label" for="antilockbrakingsys">AntiLock Braking System</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="brakeassist" name="brakeassist" value="1">
										<label class="form-check-label" for="brakeassist">Brake Assist</label>
									</div>
								</div>
							</div>

							<div class="row mt-4">
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="powersteering" name="powersteering" value="1">
										<label class="form-check-label" for="powersteering">Power Steering</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="driverairbag" name="driverairbag" value="1">
										<label class="form-check-label" for="driverairbag">Driver Airbag</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="passengerairbag" name="passengerairbag" value="1">
										<label class="form-check-label" for="passengerairbag">Passenger Airbag</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="powerwindow" name="powerwindow" value="1">
										<label class="form-check-label" for="powerwindow">Power Windows</label>
									</div>
								</div>
							</div>

							<div class="row mt-4">
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="cdplayer" name="cdplayer" value="1">
										<label class="form-check-label" for="cdplayer">CD Player</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="centrallocking" name="centrallocking" value="1">
										<label class="form-check-label" for="centrallocking">Central Locking</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="crashcensor" name="crashcensor" value="1">
										<label class="form-check-label" for="crashcensor">Crash Sensor</label>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="leatherseats" name="leatherseats" value="1">
										<label class="form-check-label" for="leatherseats">Leather Seats</label>
									</div>
								</div>
							</div>

							<div class="btn-container">
								<button class="btn btn-default" type="reset">Cancel</button>
								<button class="btn btn-primary" name="submit" type="submit">Save changes</button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- JavaScript -->
		<!-- <script src="js/admin.js"></script> -->
		<script>
			/**
			 * Admin Panel JavaScript Functions
			 */

			// Initialize the page when the DOM content is loaded
			document.addEventListener('DOMContentLoaded', function() {
				initSidebar();
				initFormValidation();
				initFileUploads();
			});

			// Sidebar functionality
			function initSidebar() {
				// Get menu toggle button and sidebar
				const menuToggle = document.querySelector('.menu-toggle');
				const sidebar = document.querySelector('.sidebar');

				// Add click event to toggle sidebar
				if (menuToggle && sidebar) {
					menuToggle.addEventListener('click', function() {
						sidebar.classList.toggle('active');
					});

					// Close sidebar when clicking outside on mobile
					document.addEventListener('click', function(event) {
						if (window.innerWidth <= 768 &&
							!sidebar.contains(event.target) &&
							!menuToggle.contains(event.target) &&
							sidebar.classList.contains('active')) {
							sidebar.classList.remove('active');
						}
					});
				}

				
			}

			// Form validation
			function initFormValidation() {
				const form = document.querySelector('form');

				if (form) {
					form.addEventListener('submit', function(event) {
						let isValid = true;

						// Get all required inputs
						const requiredInputs = form.querySelectorAll('[required]');

						// Check each required field
						requiredInputs.forEach(input => {
							if (!input.value.trim()) {
								isValid = false;
								highlightInvalidField(input);
							} else {
								removeInvalidHighlight(input);
							}
						});

						// Prevent form submission if validation fails
						if (!isValid) {
							event.preventDefault();
							showAlert('Please fill in all required fields', 'error');
						}
					});

					// Add validation on input change
					const inputs = form.querySelectorAll('input, select, textarea');
					inputs.forEach(input => {
						input.addEventListener('change', function() {
							if (this.hasAttribute('required') && !this.value.trim()) {
								highlightInvalidField(this);
							} else {
								removeInvalidHighlight(this);
							}
						});
					});
				}
			}

			// Highlight invalid fields
			function highlightInvalidField(field) {
				field.classList.add('invalid');
				field.style.borderColor = 'var(--danger)';

				// Add error message if not exists
				const parent = field.parentElement;
				if (!parent.querySelector('.error-message')) {
					const errorMessage = document.createElement('div');
					errorMessage.className = 'error-message';
					errorMessage.textContent = 'This field is required';
					errorMessage.style.color = 'var(--danger)';
					errorMessage.style.fontSize = '0.75rem';
					errorMessage.style.marginTop = '0.25rem';
					parent.appendChild(errorMessage);
				}
			}

			// Remove invalid highlight
			function removeInvalidHighlight(field) {
				field.classList.remove('invalid');
				field.style.borderColor = '';

				// Remove error message if exists
				const parent = field.parentElement;
				const errorMessage = parent.querySelector('.error-message');
				if (errorMessage) {
					parent.removeChild(errorMessage);
				}
			}

			// File upload preview
			function initFileUploads() {
				const fileInputs = document.querySelectorAll('input[type="file"]');

				fileInputs.forEach(input => {
					input.addEventListener('change', function(e) {
						// Get the file name display element
						const fileNameDisplay = this.parentElement.querySelector('.file-name');

						if (this.files && this.files.length > 0) {
							if (fileNameDisplay) {
								fileNameDisplay.textContent = this.files[0].name;
							} else {
								// Create file name display if not exists
								const fileNameElement = document.createElement('div');
								fileNameElement.className = 'file-name';
								fileNameElement.textContent = this.files[0].name;
								this.parentElement.appendChild(fileNameElement);
							}
						}
					});
				});
			}

			// Show alert message
			function showAlert(message, type = 'success') {
				// Remove existing alerts
				const existingAlerts = document.querySelectorAll('.alert');
				existingAlerts.forEach(alert => alert.remove());

				// Create new alert
				const alertElement = document.createElement('div');
				alertElement.className = `alert alert-${type}`;

				const strongElement = document.createElement('strong');
				strongElement.textContent = type === 'success' ? 'SUCCESS' : 'ERROR';

				alertElement.appendChild(strongElement);
				alertElement.appendChild(document.createTextNode(`: ${message}`));

				// Find the panel to insert before
				const panelElement = document.querySelector('.panel');
				if (panelElement) {
					panelElement.parentNode.insertBefore(alertElement, panelElement);
				}

				// Auto remove after 5 seconds
				setTimeout(() => {
					alertElement.remove();
				}, 5000);
			}
		</script>
	</body>

	</html>
<?php } ?>