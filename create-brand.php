<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	// Code for change password	
	if (isset($_POST['submit'])) {
		$brand = $_POST['brand'];
		$sql = "INSERT INTO  tblbrands(BrandName) VALUES(:brand)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			$msg = "Brand Created successfully";
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
		<meta name="description" content="Car Rental Portal Admin Create Brand">
		<meta name="author" content="">

		<title>Car Rental Portal | Admin Create Brand</title>

		<!-- <link rel="stylesheet" href="css/create-brand.css"> -->
		<style>
			/* Base Styles */
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
				background-color: #f8fafc;
				color: #1e293b;
				line-height: 1.5;
			}

			/* Layout */
			.main-container {
				display: flex;
				min-height: calc(100vh - 64px);
			}

			.content {
				flex: 1;
				padding: 1.5rem;
			}

			.content-container {
				max-width: 1400px;
				margin: 0 auto;
			}

			/* Page Title */
			.page-title {
				font-size: 1.75rem;
				font-weight: 600;
				margin-bottom: 1.5rem;
				color: #1e293b;
			}

			/* Card Container */
			.card {
				background: white;
				border-radius: 0.5rem;
				box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
				margin: 1.5rem 0;
				max-width: 800px;
			}

			.card-header {
				padding: 1.5rem;
				border-bottom: 1px solid #e2e8f0;
			}

			.card-header h3 {
				margin: 0;
				font-size: 1.25rem;
				color: #1e293b;
			}

			.card-body {
				padding: 1.5rem;
			}

			/* Form Elements */
			.form {
				display: flex;
				flex-direction: column;
				gap: 1.5rem;
			}

			.form-group {
				display: flex;
				flex-direction: column;
				gap: 0.5rem;
			}

			.form-group label {
				font-size: 0.875rem;
				font-weight: 500;
				color: #475569;
			}

			.form-control {
				padding: 0.75rem;
				border: 1px solid #e2e8f0;
				border-radius: 0.375rem;
				font-size: 1rem;
				width: 100%;
				transition: all 0.2s;
			}

			.form-control:focus {
				outline: none;
				border-color: #1e40af;
				box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
			}

			.form-control::placeholder {
				color: #94a3b8;
			}

			/* Buttons */
			.btn {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				padding: 0.75rem 1.5rem;
				border: none;
				border-radius: 0.375rem;
				font-weight: 500;
				cursor: pointer;
				transition: all 0.2s;
			}

			.btn.primary {
				background-color: #1e40af;
				color: white;
			}

			.btn.primary:hover {
				background-color: #1e3a8a;
			}

			.btn.primary:active {
				transform: translateY(1px);
			}

			/* Form Actions */
			.form-actions {
				display: flex;
				justify-content: flex-start;
				gap: 1rem;
				margin-top: 1rem;
			}

			/* Alerts */
			.alert {
				padding: 1rem;
				border-radius: 0.375rem;
				margin-bottom: 1.5rem;
				display: flex;
				align-items: center;
				gap: 0.5rem;
			}

			.alert strong {
				font-weight: 600;
			}

			.alert.error {
				background-color: #fee2e2;
				border: 1px solid #fecaca;
				color: #991b1b;
			}

			.alert.success {
				background-color: #dcfce7;
				border: 1px solid #bbf7d0;
				color: #166534;
			}

			/* Animation */
			@keyframes fadeIn {
				from {
					opacity: 0;
					transform: translateY(-10px);
				}

				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.alert {
				animation: fadeIn 0.3s ease-out;
			}

			/* Responsive Adjustments */
			@media (max-width: 1024px) {
				.content {
					padding: 1.25rem;
				}

				.card {
					margin: 1.25rem 0;
				}
			}

			@media (max-width: 768px) {
				.content {
					padding: 1rem;
				}

				.page-title {
					font-size: 1.5rem;
					margin-bottom: 1rem;
				}

				.card-header,
				.card-body {
					padding: 1.25rem;
				}

				.form {
					gap: 1.25rem;
				}
			}

			@media (max-width: 480px) {
				.content {
					padding: 0.75rem;
				}

				.card-header,
				.card-body {
					padding: 1rem;
				}

				.btn {
					width: 100%;
				}

				.form-actions {
					flex-direction: column;
				}

				.form-group label {
					font-size: 0.8125rem;
				}
			}
		</style>
	</head>

	<body>
		<?php include('includes/header.php'); ?>

		<div class="main-container">
			<?php include('includes/leftbar.php'); ?>

			<main class="content">
				<div class="content-container">
					<h2 class="page-title">Create Brand</h2>

					<div class="card">
						<div class="card-header">
							<h3>Create New Brand</h3>
						</div>
						<div class="card-body">
							<?php if ($error) { ?>
								<div class="alert error">
									<strong>Error:</strong> <?php echo htmlentities($error); ?>
								</div>
							<?php } else if ($msg) { ?>
								<div class="alert success">
									<strong>Success:</strong> <?php echo htmlentities($msg); ?>
								</div>
							<?php } ?>

							<form method="post" name="createBrand" class="form" onSubmit="return validateForm()">
								<div class="form-group">
									<label for="brand">Brand Name</label>
									<input type="text" class="form-control" name="brand" id="brand" placeholder="Enter brand name" required>
								</div>

								<div class="form-actions">
									<button class="btn primary" name="submit" type="submit">Create Brand</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</main>
		</div>

		<script>
			function validateForm() {
				const brandInput = document.getElementById('brand');
				const brandValue = brandInput.value.trim();

				if (brandValue === '') {
					alert('Please enter a brand name');
					brandInput.focus();
					return false;
				}

				if (brandValue.length < 2) {
					alert('Brand name must be at least 2 characters long');
					brandInput.focus();
					return false;
				}

				return true;
			}

			// Add input validation and formatting
			document.addEventListener('DOMContentLoaded', function() {
				const brandInput = document.getElementById('brand');

				brandInput.addEventListener('input', function() {
					// Capitalize first letter of each word
					this.value = this.value
						.split(' ')
						.map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
						.join(' ');
				});
			});

			document.addEventListener('DOMContentLoaded', function() {
				// Toggle mobile menu
				const menuToggle = document.querySelector('.menu-toggle');
				const sidebar = document.querySelector('.sidebar');

				if (menuToggle && sidebar) {
					menuToggle.addEventListener('click', function() {
						sidebar.classList.toggle('active');
					});

					// Close sidebar when clicking outside on mobile
					document.addEventListener('click', function(event) {
						const isClickInside = sidebar.contains(event.target) ||
							menuToggle.contains(event.target);

						if (!isClickInside && sidebar.classList.contains('active') &&
							window.innerWidth <= 768) {
							sidebar.classList.remove('active');
						}
					});
				}

				// Handle window resize for sidebar
				window.addEventListener('resize', function() {
					if (window.innerWidth > 768 && sidebar) {
						sidebar.classList.remove('active');
					}
				});

				// Initialize any data visualization here if needed
				// This would replace the Chart.js initialization from the original code
			});
		</script>
	</body>

	</html>
<?php } ?>