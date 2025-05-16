<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	if (isset($_REQUEST['del'])) {
		$delid = intval($_GET['del']);
		$sql = "delete from tblvehicles WHERE id=:delid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':delid', $delid, PDO::PARAM_STR);
		$query->execute();
		$msg = "Vehicle record deleted successfully";
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

		<title>Car Rental Portal | Admin Manage Vehicles</title>

		<!-- <link rel="stylesheet" href="css/styles.css"> -->
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
				--gray-50: #f8fafc;
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
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
					Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
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
			}

			.container {
				width: 100%;
				max-width: 1200px;
				margin: 0 auto;
			}

			/* Page Title */
			.page-title {
				font-size: 1.875rem;
				font-weight: 600;
				color: var(--gray-800);
				margin-bottom: 1.5rem;
			}

			/* Panel Styles */
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
				color: var(--gray-700);
			}

			.panel-body {
				padding: 1.5rem;
			}

			/* Alert Styles */
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

			.alert strong {
				margin-right: 0.5rem;
			}

			/* Table Styles */
			.table-responsive {
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
			}

			.table {
				width: 100%;
				border-collapse: collapse;
				font-size: 0.875rem;
			}

			.table th,
			.table td {
				padding: 1rem;
				text-align: left;
				border-bottom: 1px solid var(--gray-200);
			}

			.table th {
				background-color: var(--gray-50);
				font-weight: 600;
				color: var(--gray-700);
				white-space: nowrap;
			}

			.table tbody tr:hover {
				background-color: var(--gray-50);
			}

			.table td {
				color: var(--gray-600);
			}

			/* Action Buttons */
			.actions {
				display: flex;
				gap: 0.5rem;
			}

			.edit-btn,
			.delete-btn {
				padding: 0.375rem 0.75rem;
				border-radius: var(--border-radius);
				font-size: 0.875rem;
				text-decoration: none;
				transition: var(--transition);
				border: none;
				cursor: pointer;
			}

			.edit-btn {
				background-color: var(--primary-light);
				color: white;
			}

			.edit-btn:hover {
				background-color: var(--primary);
			}

			.delete-btn {
				background-color: var(--danger);
				color: white;
			}

			.delete-btn:hover {
				background-color: #dc2626;
			}

			/* Responsive Styles */
			@media (max-width: 1024px) {
				.content-wrapper {
					padding: 1rem;
				}

				.table th,
				.table td {
					padding: 0.75rem;
				}
			}

			@media (max-width: 768px) {
				.main-content {
					flex-direction: column;
				}

				.page-title {
					font-size: 1.5rem;
				}

				.panel-body {
					padding: 1rem;
				}

				.table {
					font-size: 0.8125rem;
				}

				.table th,
				.table td {
					padding: 0.625rem;
				}

				.actions {
					flex-direction: column;
					gap: 0.25rem;
				}

				.edit-btn,
				.delete-btn {
					text-align: center;
					padding: 0.25rem 0.5rem;
				}
			}

			@media (max-width: 480px) {
				.content-wrapper {
					padding: 0.75rem;
				}

				.panel {
					margin-bottom: 1rem;
				}

				.table-responsive {
					margin: 0 -1rem;
				}

				.table th,
				.table td {
					padding: 0.5rem;
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
					<h2 class="page-title">Manage Vehicles</h2>

					<?php if ($error) { ?>
						<div class="alert alert-error"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
					<?php } else if ($msg) { ?>
						<div class="alert alert-success"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
					<?php } ?>

					<div class="panel">
						<div class="panel-header">Vehicle Details</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Vehicle Title</th>
											<th>Brand</th>
											<th>Price Per day</th>
											<th>Fuel Type</th>
											<th>Model Year</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand";
										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;
										if ($query->rowCount() > 0) {
											foreach ($results as $result) {
										?>
												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><?php echo htmlentities($result->VehiclesTitle); ?></td>
													<td><?php echo htmlentities($result->BrandName); ?></td>
													<td><?php echo htmlentities($result->PricePerDay); ?></td>
													<td><?php echo htmlentities($result->FuelType); ?></td>
													<td><?php echo htmlentities($result->ModelYear); ?></td>
													<td class="actions">
														<a href="edit-vehicle.php?id=<?php echo $result->id; ?>" class="edit-btn">Edit</a>
														<a href="manage-vehicles.php?del=<?php echo $result->id; ?>"
															onclick="return confirm('Do you want to delete?')"
															class="delete-btn">Delete</a>
													</td>
												</tr>
										<?php $cnt = $cnt + 1;
											}
										} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- <script src="js/admin.js"></script> -->
		 <script>
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