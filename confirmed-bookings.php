<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Car Rental Portal | Confirmed Bookings</title>
		<!-- <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/dark-mode.css"> -->
		<style>
			/* Admin Dashboard Styles */
			:root {
				--primary: #1e40af;
				--primary-light: #3b82f6;
				--primary-dark: #1e3a8a;
				--secondary: #64748b;
				--success: #10b981;
				--warning: #f59e0b;
				--danger: #ef4444;
				--light: #f1f5f9;
				--dark: #1e293b;
				--white: #ffffff;
				--border: #e2e8f0;
				--text-primary: #1e293b;
				--text-secondary: #64748b;
				--shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
				--radius: 0.375rem;
				--transition: all 0.3s ease;
			}

			/* Reset and Base Styles */
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
				color: var(--text-primary);
				background-color: #f8fafc;
				line-height: 1.5;
			}

			a {
				color: var(--primary);
				text-decoration: none;
				transition: var(--transition);
			}

			a:hover {
				color: var(--primary-light);
			}

			/* Main Content Layout */
			.main-content {
				display: flex;
				min-height: calc(100vh - 64px);
				width: 100%;
			}

			.content-wrapper {
				flex: 1;
				padding: 2rem;
				overflow-x: hidden;
			}

			.container {
				max-width: 1400px;
				margin: 0 auto;
			}

			/* Page Header */
			.page-header {
				margin-bottom: 2rem;
			}

			.page-title {
				font-size: 1.75rem;
				font-weight: 600;
				color: var(--text-primary);
			}

			/* Card Styles */
			.card {
				background-color: var(--white);
				border-radius: var(--radius);
				box-shadow: var(--shadow);
				margin-bottom: 2rem;
				overflow: hidden;
			}

			.card-header {
				padding: 1.25rem 1.5rem;
				border-bottom: 1px solid var(--border);
				display: flex;
				align-items: center;
				justify-content: space-between;
				flex-wrap: wrap;
				gap: 1rem;
			}

			.card-title {
				font-size: 1.25rem;
				font-weight: 500;
				color: var(--text-primary);
				margin: 0;
			}

			.card-body {
				padding: 1.5rem;
			}

			.card-actions {
				display: flex;
				align-items: center;
				gap: 1rem;
			}

			/* Search Container */
			.search-container {
				display: flex;
				align-items: center;
			}

			.search-container input {
				padding: 0.5rem 1rem;
				border: 1px solid var(--border);
				border-radius: var(--radius) 0 0 var(--radius);
				outline: none;
				font-size: 0.875rem;
			}

			.search-container button {
				background-color: var(--primary);
				color: var(--white);
				border: none;
				padding: 0.5rem 1rem;
				border-radius: 0 var(--radius) var(--radius) 0;
				cursor: pointer;
				font-size: 0.875rem;
				transition: var(--transition);
			}

			.search-container button:hover {
				background-color: var(--primary-dark);
			}

			/* Table Styles */
			.table-responsive {
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
			}

			.data-table {
				width: 100%;
				border-collapse: collapse;
				text-align: left;
				white-space: nowrap;
			}

			.data-table th {
				background-color: var(--light);
				color: var(--text-primary);
				font-weight: 500;
				padding: 0.75rem 1rem;
				border-bottom: 2px solid var(--border);
				position: relative;
				cursor: pointer;
			}

			.data-table th:after {
				content: "↕";
				position: absolute;
				right: 0.5rem;
				color: var(--text-secondary);
				opacity: 0.5;
			}

			.data-table th.sort-asc:after {
				content: "↑";
				opacity: 1;
			}

			.data-table th.sort-desc:after {
				content: "↓";
				opacity: 1;
			}

			.data-table td {
				padding: 0.75rem 1rem;
				border-bottom: 1px solid var(--border);
				color: var(--text-primary);
			}

			.data-table tr:last-child td {
				border-bottom: none;
			}

			.data-table tr:hover td {
				background-color: rgba(241, 245, 249, 0.5);
			}

			/* Status Badges */
			.status-badge {
				display: inline-block;
				padding: 0.25rem 0.75rem;
				border-radius: 9999px;
				font-size: 0.75rem;
				font-weight: 500;
			}

			.status-pending {
				background-color: #fef3c7;
				color: #92400e;
			}

			.status-confirmed {
				background-color: #d1fae5;
				color: #065f46;
			}

			.status-cancelled {
				background-color: #fee2e2;
				color: #b91c1c;
			}

			/* Button Styles */
			.btn-view {
				display: inline-block;
				padding: 0.375rem 0.75rem;
				background-color: var(--primary);
				color: var(--white);
				border-radius: var(--radius);
				font-size: 0.875rem;
				font-weight: 500;
				transition: var(--transition);
			}

			.btn-view:hover {
				background-color: var(--primary-dark);
				color: var(--white);
			}

			/* Pagination */
			.pagination-container {
				display: flex;
				flex-wrap: wrap;
				justify-content: space-between;
				align-items: center;
				margin-top: 1.5rem;
				gap: 1rem;
			}

			.pagination-info {
				color: var(--text-secondary);
				font-size: 0.875rem;
			}

			.pagination {
				display: flex;
				align-items: center;
				gap: 0.5rem;
			}

			.pagination-btn {
				padding: 0.375rem 0.75rem;
				background-color: var(--white);
				border: 1px solid var(--border);
				border-radius: var(--radius);
				color: var(--text-primary);
				cursor: pointer;
				transition: var(--transition);
			}

			.pagination-btn:hover:not(:disabled) {
				background-color: var(--primary);
				color: var(--white);
				border-color: var(--primary);
			}

			.pagination-btn:disabled {
				opacity: 0.5;
				cursor: not-allowed;
			}

			.pagination-numbers {
				display: flex;
				gap: 0.25rem;
			}

			.page-number {
				display: flex;
				align-items: center;
				justify-content: center;
				width: 2rem;
				height: 2rem;
				border-radius: var(--radius);
				border: 1px solid var(--border);
				background-color: var(--white);
				cursor: pointer;
				transition: var(--transition);
			}

			.page-number:hover {
				background-color: var(--light);
			}

			.page-number.active {
				background-color: var(--primary);
				color: var(--white);
				border-color: var(--primary);
			}

			.no-records {
				text-align: center;
				padding: 2rem;
				color: var(--text-secondary);
			}

			/* Responsive Styles */
			@media (max-width: 768px) {
				.content-wrapper {
					padding: 1rem;
				}

				.card-header {
					flex-direction: column;
					align-items: flex-start;
				}

				.search-container {
					width: 100%;
				}

				.search-container input {
					flex: 1;
				}

				/* Table responsive for mobile */
				.data-table thead {
					display: none;
				}

				.data-table,
				.data-table tbody,
				.data-table tr,
				.data-table td {
					display: block;
					width: 100%;
				}

				.data-table tr {
					margin-bottom: 1rem;
					border: 1px solid var(--border);
					border-radius: var(--radius);
					padding: 0.5rem;
				}

				.data-table td {
					display: flex;
					justify-content: space-between;
					padding: 0.5rem;
					text-align: right;
					border-bottom: 1px solid var(--border);
				}

				.data-table td:last-child {
					border-bottom: none;
				}

				.data-table td:before {
					content: attr(data-label);
					font-weight: 500;
					text-align: left;
				}

				.pagination-container {
					flex-direction: column;
					align-items: flex-start;
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
					<div class="page-header">
						<h1 class="page-title">Confirmed Bookings</h1>
					</div>

					<div class="card">
						<div class="card-header">
							<h2 class="card-title">Bookings Info</h2>
							<div class="card-actions">
								<div class="search-container">
									<input type="text" id="searchInput" placeholder="Search bookings...">
									<button id="searchBtn">Search</button>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="bookingsTable" class="data-table">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Booking No.</th>
											<th>Vehicle</th>
											<th>From Date</th>
											<th>To Date</th>
											<th>Status</th>
											<th>Posting date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$status = 1;
										$sql = "SELECT tblusers.FullName,tblbrands.BrandName,tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id,tblbooking.BookingNumber FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id WHERE tblbooking.Status=:status";
										$query = $dbh->prepare($sql);
										$query->bindParam(':status', $status, PDO::PARAM_STR);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;
										if ($query->rowCount() > 0) {
											foreach ($results as $result) {
										?>
												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><?php echo htmlentities($result->FullName); ?></td>
													<td><?php echo htmlentities($result->BookingNumber); ?></td>
													<td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"><?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?></a></td>
													<td><?php echo htmlentities($result->FromDate); ?></td>
													<td><?php echo htmlentities($result->ToDate); ?></td>
													<td>
														<span class="status-badge status-confirmed">
															<?php echo htmlentities('Confirmed'); ?>
														</span>
													</td>
													<td><?php echo htmlentities($result->PostingDate); ?></td>
													<td>
														<a href="bookig-details.php?bid=<?php echo htmlentities($result->id); ?>" class="btn-view">View</a>
													</td>
												</tr>
											<?php
												$cnt++;
											}
										} else {
											?>
											<tr>
												<td colspan="9" class="no-records">No confirmed bookings found</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>

							<div class="pagination-container">
								<div class="pagination-info">Showing <span id="startRecord">1</span> to <span id="endRecord">10</span> of <span id="totalRecords"><?php echo $query->rowCount(); ?></span> entries</div>
								<div class="pagination" id="pagination">
									<button class="pagination-btn" id="prevPage" disabled>Previous</button>
									<div class="pagination-numbers" id="paginationNumbers"></div>
									<button class="pagination-btn" id="nextPage">Next</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- <script src="js/admin.js"></script> -->
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				// Initialize sidebar toggle
				const menuToggle = document.querySelector('.menu-toggle');
				const sidebar = document.querySelector('.sidebar');

				if (menuToggle && sidebar) {
					menuToggle.addEventListener('click', function() {
						sidebar.classList.toggle('active');
					});
				}


				// Add data-label attributes to table cells for mobile view
				const table = document.getElementById('bookingsTable');
				if (table) {
					const headerCells = table.querySelectorAll('thead th');
					const headerTexts = Array.from(headerCells).map(cell => cell.textContent.trim());

					const bodyRows = table.querySelectorAll('tbody tr');
					bodyRows.forEach(row => {
						const cells = row.querySelectorAll('td');
						cells.forEach((cell, index) => {
							if (index < headerTexts.length) {
								cell.setAttribute('data-label', headerTexts[index]);
							}
						});
					});
				}

				// Table sorting
				const tableHeaders = document.querySelectorAll('#bookingsTable th');

				tableHeaders.forEach((header, index) => {
					if (index > 0) { // Skip the # column
						header.addEventListener('click', function() {
							sortTable(index);
						});
					}
				});

				function sortTable(columnIndex) {
					const table = document.getElementById('bookingsTable');
					const tbody = table.querySelector('tbody');
					const rows = Array.from(tbody.querySelectorAll('tr'));
					const headers = table.querySelectorAll('th');

					// Check if we're sorting in ascending or descending order
					const isAscending = !headers[columnIndex].classList.contains('sort-asc');

					// Remove sorting classes from all headers
					headers.forEach(header => {
						header.classList.remove('sort-asc', 'sort-desc');
					});

					// Add appropriate sorting class
					headers[columnIndex].classList.add(isAscending ? 'sort-asc' : 'sort-desc');

					// Sort the rows
					rows.sort((a, b) => {
						const aValue = a.querySelectorAll('td')[columnIndex].textContent.trim();
						const bValue = b.querySelectorAll('td')[columnIndex].textContent.trim();

						if (isAscending) {
							return aValue.localeCompare(bValue, undefined, {
								numeric: true
							});
						} else {
							return bValue.localeCompare(aValue, undefined, {
								numeric: true
							});
						}
					});

					// Re-append rows in new order
					rows.forEach(row => tbody.appendChild(row));

					// Update pagination after sorting
					updatePagination();
				}

				// Pagination
				const rowsPerPage = 10;
				let currentPage = 1;

				function updatePagination() {
					const table = document.getElementById('bookingsTable');
					const rows = table.querySelectorAll('tbody tr');
					const totalRows = rows.length;
					const totalPages = Math.ceil(totalRows / rowsPerPage);

					// Update pagination info
					document.getElementById('startRecord').textContent = totalRows === 0 ? 0 : (currentPage - 1) * rowsPerPage + 1;
					document.getElementById('endRecord').textContent = Math.min(currentPage * rowsPerPage, totalRows);
					document.getElementById('totalRecords').textContent = totalRows;

					// Hide all rows
					rows.forEach(row => {
						row.style.display = 'none';
					});

					// Show rows for current page
					for (let i = (currentPage - 1) * rowsPerPage; i < currentPage * rowsPerPage && i < totalRows; i++) {
						rows[i].style.display = '';
					}

					// Update pagination buttons
					const prevBtn = document.getElementById('prevPage');
					const nextBtn = document.getElementById('nextPage');

					prevBtn.disabled = currentPage === 1;
					nextBtn.disabled = currentPage === totalPages || totalRows === 0;

					// Update page numbers
					const paginationNumbers = document.getElementById('paginationNumbers');
					paginationNumbers.innerHTML = '';

					const maxVisiblePages = 5;
					let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
					let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

					if (endPage - startPage + 1 < maxVisiblePages) {
						startPage = Math.max(1, endPage - maxVisiblePages + 1);
					}

					for (let i = startPage; i <= endPage; i++) {
						const pageNumber = document.createElement('div');
						pageNumber.classList.add('page-number');
						if (i === currentPage) {
							pageNumber.classList.add('active');
						}
						pageNumber.textContent = i;
						pageNumber.addEventListener('click', function() {
							currentPage = i;
							updatePagination();
						});
						paginationNumbers.appendChild(pageNumber);
					}
				}

				// Initialize pagination
				updatePagination();

				// Pagination event listeners
				document.getElementById('prevPage').addEventListener('click', function() {
					if (currentPage > 1) {
						currentPage--;
						updatePagination();
					}
				});

				document.getElementById('nextPage').addEventListener('click', function() {
					const table = document.getElementById('bookingsTable');
					const rows = table.querySelectorAll('tbody tr');
					const totalPages = Math.ceil(rows.length / rowsPerPage);

					if (currentPage < totalPages) {
						currentPage++;
						updatePagination();
					}
				});

				// Search functionality
				const searchInput = document.getElementById('searchInput');
				const searchBtn = document.getElementById('searchBtn');

				function performSearch() {
					const searchText = searchInput.value.toLowerCase();
					const table = document.getElementById('bookingsTable');
					const rows = table.querySelectorAll('tbody tr');

					rows.forEach(row => {
						const text = row.textContent.toLowerCase();
						row.dataset.visible = text.includes(searchText) ? 'true' : 'false';
						row.style.display = text.includes(searchText) ? '' : 'none';
					});

					// Reset pagination after search
					currentPage = 1;
					updatePagination();
				}

				if (searchBtn) {
					searchBtn.addEventListener('click', performSearch);
				}

				if (searchInput) {
					searchInput.addEventListener('keyup', function(event) {
						if (event.key === 'Enter') {
							performSearch();
						}
					});
				}

				
			});
		</script>
	</body>

	</html>
<?php } ?>