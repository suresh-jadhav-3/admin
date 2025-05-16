<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		$sql = "delete from tblsubscribers WHERE id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$msg = "Subscriber info deleted";
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

		<title>Car Rental Portal | Admin Manage Subscribers</title>
		<!-- <link rel="stylesheet" href="css/manage-subscribers.css"> -->
		<style>
			/* Base Styles */
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
				background-color: #f3f4f6;
				color: #1e293b;
				line-height: 1.5;
			}

			.main-content {
				display: flex;
				min-height: calc(100vh - 64px);
			}

			.content-wrapper {
				flex: 1;
				padding: 2rem;
				overflow-x: hidden;
			}

			.container {
				max-width: 1200px;
				margin: 0 auto;
			}

			/* Page Title */
			.page-title {
				font-size: 1.5rem;
				font-weight: 600;
				color: #1e293b;
				margin-bottom: 1.5rem;
				padding-bottom: 0.5rem;
				border-bottom: 1px solid #e2e8f0;
			}

			/* Panel Styles */
			.panel {
				background-color: white;
				border-radius: 0.5rem;
				box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
				overflow: hidden;
				margin-bottom: 2rem;
			}

			.panel-heading {
				background-color: #f8fafc;
				padding: 1rem 1.5rem;
				border-bottom: 1px solid #e2e8f0;
				font-weight: 600;
				color: #1e293b;
			}

			.panel-body {
				padding: 1.5rem;
			}


			/* Table Controls */
			.table-controls {
				display: flex;
				justify-content: flex-end;
				margin-bottom: 1rem;
			}

			.search-box {
				position: relative;
				width: 240px;
			}

			.search-box input {
				width: 100%;
				padding: 0.5rem 1rem 0.5rem 2.25rem;
				border: 1px solid #e2e8f0;
				border-radius: 0.375rem;
				font-size: 0.875rem;
				transition: all 0.2s;
			}

			.search-box input:focus {
				outline: none;
				border-color: #1e40af;
				box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.2);
			}

			.search-icon {
				position: absolute;
				left: 0.75rem;
				top: 50%;
				transform: translateY(-50%);
				color: #94a3b8;
				font-size: 0.875rem;
			}

			/* Data Table */
			.table-responsive {
				overflow-x: auto;
				margin-bottom: 1rem;
			}

			.data-table {
				width: 100%;
				border-collapse: collapse;
				text-align: left;
				font-size: 0.875rem;
			}

			.data-table th {
				background-color: #f8fafc;
				color: #475569;
				font-weight: 600;
				padding: 0.75rem 1rem;
				border-bottom: 2px solid #e2e8f0;
				cursor: pointer;
				transition: all 0.2s;
				white-space: nowrap;
			}

			.data-table th:hover {
				background-color: #f1f5f9;
				color: #1e40af;
			}

			.data-table th::after {
				content: "";
				margin-left: 0.5rem;
				font-size: 0.75rem;
			}

			.data-table th.asc::after {
				content: "↑";
			}

			.data-table th.desc::after {
				content: "↓";
			}

			.data-table td {
				padding: 0.75rem 1rem;
				border-bottom: 1px solid #e2e8f0;
				vertical-align: middle;
			}

			.data-table tbody tr:hover {
				background-color: #f8fafc;
			}

			/* Action Buttons */
			.delete-btn {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				width: 32px;
				height: 32px;
				border-radius: 0.25rem;
				background-color: #fee2e2;
				color: #ef4444;
				text-decoration: none;
				transition: all 0.2s;
			}

			.delete-btn:hover {
				background-color: #fecaca;
			}

			.delete-icon {
				font-size: 1rem;
			}

			/* Pagination */
			.pagination-container {
				display: flex;
				justify-content: space-between;
				align-items: center;
				font-size: 0.875rem;
				color: #475569;
			}

			.pagination {
				display: flex;
				gap: 0.25rem;
			}

			.pagination-btn {
				padding: 0.25rem 0.5rem;
				border: 1px solid #e2e8f0;
				border-radius: 0.25rem;
				background-color: white;
				color: #475569;
				cursor: pointer;
				transition: all 0.2s;
			}

			.pagination-btn.active {
				background-color: #1e40af;
				color: white;
				border-color: #1e40af;
			}

			.pagination-btn:hover:not(.active):not(:disabled) {
				background-color: #f1f5f9;
				border-color: #cbd5e1;
			}

			.pagination-btn:disabled {
				opacity: 0.5;
				cursor: not-allowed;
			}

			/* Responsive */
			@media (max-width: 992px) {
				.content-wrapper {
					padding: 1.5rem;
				}
			}

			@media (max-width: 768px) {
				.main-content {
					flex-direction: column;
				}

				.content-wrapper {
					padding: 1rem;
				}

				.panel-body {
					padding: 1rem;
				}

				.pagination-container {
					flex-direction: column;
					gap: 1rem;
					align-items: flex-start;
				}

				.data-table td,
				.data-table th {
					padding: 0.5rem;
				}

				.table-controls {
					justify-content: center;
				}

				.search-box {
					width: 100%;
				}
			}

			@media (max-width: 576px) {
				.page-title {
					font-size: 1.25rem;
				}

				.panel-heading {
					padding: 0.75rem 1rem;
				}

				.data-table {
					font-size: 0.75rem;
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
					<h2 class="page-title">Manage Subscribers</h2>

					<div class="panel">
						<div class="panel-heading">Subscribers Details</div>
						<div class="panel-body">
							<?php if ($error) { ?>
								<div class="error-wrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
							<?php } else if ($msg) { ?>
								<div class="success-wrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
							<?php } ?>

							<div class="table-controls">
								<div class="search-box">
									<input type="text" id="searchInput" placeholder="Search...">
									<span class="search-icon">🔍</span>
								</div>
							</div>

							<div class="table-responsive">
								<table id="subscribersTable" class="data-table">
									<thead>
										<tr>
											<th data-sort="number">#</th>
											<th data-sort="string">Email Id</th>
											<th data-sort="date">Subscription Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT * from tblsubscribers";
										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;
										if ($query->rowCount() > 0) {
											foreach ($results as $result) {
										?>
												<tr>
													<td><?php echo htmlentities($cnt); ?></td>
													<td><?php echo htmlentities($result->SubscriberEmail); ?></td>
													<td><?php echo htmlentities($result->PostingDate); ?></td>
													<td>
														<a href="manage-subscribers.php?del=<?php echo $result->id; ?>"
															class="delete-btn"
															onclick="return confirm('Do you want to delete?')">
															<span class="delete-icon">🗑️</span>
														</a>
													</td>
												</tr>
										<?php $cnt++;
											}
										} ?>
									</tbody>
								</table>
							</div>

							<div class="pagination-container">
								<div class="pagination-info">Showing <span id="startRow">1</span> to <span id="endRow">10</span> of <span id="totalRows">0</span> entries</div>
								<div class="pagination" id="pagination"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- <script src="js/manage-subscribers.js"></script> -->
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				// Table functionality
				const table = document.getElementById('subscribersTable');
				const tbody = table.querySelector('tbody');
				const headers = table.querySelectorAll('th[data-sort]');
				const searchInput = document.getElementById('searchInput');

				// Pagination variables
				const rowsPerPage = 10;
				let currentPage = 1;
				let filteredRows = [];

				// Get all rows and store them
				const allRows = Array.from(tbody.querySelectorAll('tr'));
				filteredRows = [...allRows];

				// Initialize table
				updateTable();

				// Add event listeners to headers for sorting
				headers.forEach(header => {
					header.addEventListener('click', () => {
						// Remove sort classes from all headers
						headers.forEach(h => {
							h.classList.remove('asc', 'desc');
						});

						// Get the sort direction
						let sortDirection = 'asc';
						if (header.classList.contains('asc')) {
							sortDirection = 'desc';
							header.classList.remove('asc');
							header.classList.add('desc');
						} else {
							header.classList.add('asc');
						}

						// Sort the rows
						const sortType = header.getAttribute('data-sort');
						const columnIndex = Array.from(header.parentNode.children).indexOf(header);

						sortRows(columnIndex, sortType, sortDirection);
						currentPage = 1;
						updateTable();
					});
				});

				// Search functionality
				searchInput.addEventListener('input', function() {
					const searchTerm = this.value.toLowerCase();

					// Filter rows
					filteredRows = allRows.filter(row => {
						return Array.from(row.cells).some(cell =>
							cell.textContent.toLowerCase().includes(searchTerm)
						);
					});

					currentPage = 1;
					updateTable();
				});

				// Function to sort rows
				function sortRows(columnIndex, sortType, direction) {
					filteredRows.sort((a, b) => {
						let valueA = a.cells[columnIndex].textContent.trim();
						let valueB = b.cells[columnIndex].textContent.trim();

						if (sortType === 'number') {
							return direction === 'asc' ?
								parseInt(valueA) - parseInt(valueB) :
								parseInt(valueB) - parseInt(valueA);
						} else if (sortType === 'date') {
							const dateA = new Date(valueA);
							const dateB = new Date(valueB);
							return direction === 'asc' ?
								dateA - dateB :
								dateB - dateA;
						} else {
							return direction === 'asc' ?
								valueA.localeCompare(valueB) :
								valueB.localeCompare(valueA);
						}
					});
				}

				// Update table display
				function updateTable() {
					// Clear the table body
					tbody.innerHTML = '';

					// Calculate pagination
					const startIndex = (currentPage - 1) * rowsPerPage;
					const endIndex = Math.min(startIndex + rowsPerPage, filteredRows.length);
					const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

					// Update pagination info
					document.getElementById('startRow').textContent = filteredRows.length > 0 ? startIndex + 1 : 0;
					document.getElementById('endRow').textContent = endIndex;
					document.getElementById('totalRows').textContent = filteredRows.length;

					// Display visible rows
					for (let i = startIndex; i < endIndex; i++) {
						tbody.appendChild(filteredRows[i].cloneNode(true));
					}

					// Update pagination controls
					createPagination(totalPages);
				}

				// Create pagination controls
				function createPagination(totalPages) {
					const paginationContainer = document.getElementById('pagination');
					paginationContainer.innerHTML = '';

					// Previous button
					const prevButton = document.createElement('button');
					prevButton.classList.add('pagination-btn');
					prevButton.innerHTML = '&laquo;';
					prevButton.disabled = currentPage === 1;
					prevButton.addEventListener('click', () => {
						if (currentPage > 1) {
							currentPage--;
							updateTable();
						}
					});
					paginationContainer.appendChild(prevButton);

					// Page buttons
					const maxPagesToShow = 5;
					let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
					let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

					if (endPage - startPage + 1 < maxPagesToShow && startPage > 1) {
						startPage = Math.max(1, endPage - maxPagesToShow + 1);
					}

					for (let i = startPage; i <= endPage; i++) {
						const pageButton = document.createElement('button');
						pageButton.classList.add('pagination-btn');
						if (i === currentPage) {
							pageButton.classList.add('active');
						}
						pageButton.textContent = i;
						pageButton.addEventListener('click', () => {
							currentPage = i;
							updateTable();
						});
						paginationContainer.appendChild(pageButton);
					}

					// Next button
					const nextButton = document.createElement('button');
					nextButton.classList.add('pagination-btn');
					nextButton.innerHTML = '&raquo;';
					nextButton.disabled = currentPage === totalPages || totalPages === 0;
					nextButton.addEventListener('click', () => {
						if (currentPage < totalPages) {
							currentPage++;
							updateTable();
						}
					});
					paginationContainer.appendChild(nextButton);
				}

				// Mobile navigation toggle
				const menuToggle = document.querySelector('.menu-toggle');
				if (menuToggle) {
					menuToggle.addEventListener('click', function() {
						const sidebar = document.querySelector('.sidebar');
						sidebar.classList.toggle('active');
					});
				}
			});
		</script>
	</body>

	</html>
<?php } ?>