<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
?>
	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="Car Rental Portal Admin Dashboard">
		<meta name="author" content="">

		<title>Car Rental Portal | Admin Dashboard</title>

		<!-- <link rel="stylesheet" href="css/dashboard.css"> -->
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

			.page-title {
				font-size: 1.75rem;
				font-weight: 600;
				margin-bottom: 1.5rem;
				color: #1e293b;
			}

			/* Stats Grid */
			.stats-grid {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
				gap: 1.5rem;
			}

			/* Stat Cards */
			.stat-card {
				background-color: white;
				border-radius: 0.5rem;
				overflow: hidden;
				box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
				display: flex;
				flex-direction: column;
				transition: transform 0.2s, box-shadow 0.2s;
			}

			.stat-card:hover {
				transform: translateY(-3px);
				box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
			}

			.stat-content {
				padding: 1.5rem;
				text-align: center;
			}

			.stat-number {
				font-size: 2.5rem;
				font-weight: 700;
				margin-bottom: 0.5rem;
			}

			.stat-title {
				font-size: 1rem;
				text-transform: uppercase;
				letter-spacing: 0.05em;
				font-weight: 600;
			}

			.stat-footer {
				display: flex;
				align-items: center;
				justify-content: space-between;
				padding: 0.75rem 1.5rem;
				text-decoration: none;
				font-size: 0.875rem;
				border-top: 1px solid #e2e8f0;
				font-weight: 500;
				transition: background-color 0.2s;
			}

			.arrow-icon {
				transition: transform 0.2s;
			}

			.stat-footer:hover .arrow-icon {
				transform: translateX(3px);
			}

			/* Card Colors */
			.stat-card.primary {
				border-top: 4px solid #1e40af;
			}

			.stat-card.primary .stat-number {
				color: #1e40af;
			}

			.stat-card.primary .stat-footer {
				color: #1e40af;
			}

			.stat-card.success {
				border-top: 4px solid #15803d;
			}

			.stat-card.success .stat-number {
				color: #15803d;
			}

			.stat-card.success .stat-footer {
				color: #15803d;
			}

			.stat-card.info {
				border-top: 4px solid #0369a1;
			}

			.stat-card.info .stat-number {
				color: #0369a1;
			}

			.stat-card.info .stat-footer {
				color: #0369a1;
			}

			.stat-card.warning {
				border-top: 4px solid #b45309;
			}

			.stat-card.warning .stat-number {
				color: #b45309;
			}

			.stat-card.warning .stat-footer {
				color: #b45309;
			}

			/* Responsive Adjustments */
			@media (max-width: 1024px) {
				.stats-grid {
					grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
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

				.stat-number {
					font-size: 2rem;
				}
			}

			@media (max-width: 480px) {
				.stats-grid {
					grid-template-columns: 1fr;
				}

				.content {
					padding: 0.75rem;
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
					<h2 class="page-title">Dashboard</h2>

					<div class="stats-grid">
						<div class="stat-card primary">
							<?php
							$sql = "SELECT id from tblusers";
							$query = $dbh->prepare($sql);
							$query->execute();
							$regusers = $query->rowCount();
							?>
							<div class="stat-content">
								<div class="stat-number"><?php echo htmlentities($regusers); ?></div>
								<div class="stat-title">Registered Users</div>
							</div>
							<a href="reg-users.php" class="stat-footer">
								<span>Full Detail</span>
								<span class="arrow-icon">→</span>
							</a>
						</div>

						<div class="stat-card success">
							<?php
							$sql1 = "SELECT id from tblvehicles";
							$query1 = $dbh->prepare($sql1);
							$query1->execute();
							$totalvehicle = $query1->rowCount();
							?>
							<div class="stat-content">
								<div class="stat-number"><?php echo htmlentities($totalvehicle); ?></div>
								<div class="stat-title">Listed Vehicles</div>
							</div>
							<a href="manage-vehicles.php" class="stat-footer">
								<span>Full Detail</span>
								<span class="arrow-icon">→</span>
							</a>
						</div>

						<div class="stat-card info">
							<?php
							$sql2 = "SELECT id from tblbooking";
							$query2 = $dbh->prepare($sql2);
							$query2->execute();
							$bookings = $query2->rowCount();
							?>
							<div class="stat-content">
								<div class="stat-number"><?php echo htmlentities($bookings); ?></div>
								<div class="stat-title">Total Bookings</div>
							</div>
							<a href="manage-bookings.php" class="stat-footer">
								<span>Full Detail</span>
								<span class="arrow-icon">→</span>
							</a>
						</div>

						<div class="stat-card warning">
							<?php
							$sql3 = "SELECT id from tblbrands";
							$query3 = $dbh->prepare($sql3);
							$query3->execute();
							$brands = $query3->rowCount();
							?>
							<div class="stat-content">
								<div class="stat-number"><?php echo htmlentities($brands); ?></div>
								<div class="stat-title">Listed Brands</div>
							</div>
							<a href="manage-brands.php" class="stat-footer">
								<span>Full Detail</span>
								<span class="arrow-icon">→</span>
							</a>
						</div>

						<div class="stat-card primary">
							<?php
							$sql4 = "SELECT id from tblsubscribers";
							$query4 = $dbh->prepare($sql4);
							$query4->execute();
							$subscribers = $query4->rowCount();
							?>
							<div class="stat-content">
								<div class="stat-number"><?php echo htmlentities($subscribers); ?></div>
								<div class="stat-title">Subscribers</div>
							</div>
							<a href="manage-subscribers.php" class="stat-footer">
								<span>Full Detail</span>
								<span class="arrow-icon">→</span>
							</a>
						</div>

						<div class="stat-card success">
							<?php
							$sql6 = "SELECT id from tblcontactusquery";
							$query6 = $dbh->prepare($sql6);
							$query6->execute();
							$query = $query6->rowCount();
							?>
							<div class="stat-content">
								<div class="stat-number"><?php echo htmlentities($query); ?></div>
								<div class="stat-title">Queries</div>
							</div>
							<a href="manage-conactusquery.php" class="stat-footer">
								<span>Full Detail</span>
								<span class="arrow-icon">→</span>
							</a>
						</div>

						<div class="stat-card info">
							<?php
							$sql5 = "SELECT id from tbltestimonial";
							$query5 = $dbh->prepare($sql5);
							$query5->execute();
							$testimonials = $query5->rowCount();
							?>
							<div class="stat-content">
								<div class="stat-number"><?php echo htmlentities($testimonials); ?></div>
								<div class="stat-title">Testimonials</div>
							</div>
							<a href="testimonials.php" class="stat-footer">
								<span>Full Detail</span>
								<span class="arrow-icon">→</span>
							</a>
						</div>
					</div>
				</div>
			</main>
		</div>

		<!-- <script src="js/dashboard.js"></script> -->
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