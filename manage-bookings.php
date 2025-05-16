<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Handle status updates
    if (isset($_REQUEST['eid'])) {
        $eid = intval($_GET['eid']);
        $status = "Confirmed";
        $sql = "UPDATE tblbooking SET Status=:status WHERE  id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Booking Successfully Confirmed";
    }

    if (isset($_REQUEST['aeid'])) {
        $aeid = intval($_GET['aeid']);
        $status = "Cancelled";
        $sql = "UPDATE tblbooking SET Status=:status WHERE  id=:aeid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Booking Successfully Cancelled";
    }
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="Car Rental Portal Admin Manage Bookings">
        <meta name="author" content="">

        <title>Car Rental Portal | Manage Bookings</title>

        <link rel="stylesheet" href="css/manage-bookings.css">
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
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .page-subtitle {
                font-size: 1rem;
                color: #64748b;
                margin-bottom: 1.5rem;
            }

            /* Alert Messages */
            .success-message {
                background-color: #dcfce7;
                color: #166534;
                border-left: 4px solid #16a34a;
                padding: 1rem;
                margin-bottom: 1.5rem;
                border-radius: 0.25rem;
                animation: fadeOut 5s forwards;
                display: flex;
                align-items: center;
            }

            .success-message:before {
                content: '✓';
                display: inline-block;
                margin-right: 0.75rem;
                font-weight: bold;
            }

            @keyframes fadeOut {
                0% {
                    opacity: 1;
                }
                80% {
                    opacity: 1;
                }
                100% {
                    opacity: 0;
                }
            }

            /* Actions Row */
            .actions-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .search-container {
                position: relative;
                flex: 1;
                max-width: 360px;
            }

            .search-input {
                width: 100%;
                padding: 0.75rem 1rem 0.75rem 2.5rem;
                border: 1px solid #e2e8f0;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                transition: all 0.2s;
            }

            .search-input:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            }

            .search-icon {
                position: absolute;
                left: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
            }

            .filter-container {
                display: flex;
                gap: 0.5rem;
                align-items: center;
            }

            .filter-select {
                padding: 0.625rem 2rem 0.625rem 1rem;
                border: 1px solid #e2e8f0;
                border-radius: 0.375rem;
                background-color: white;
                font-size: 0.875rem;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M8 10.5l4-4H4l4 4z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
            }

            .filter-select:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            }

            /* Table Styles */
            .bookings-table-container {
                overflow-x: auto;
                background-color: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            }

            .bookings-table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
                font-size: 0.875rem;
            }

            .bookings-table th {
                background-color: #f8fafc;
                padding: 1rem;
                font-weight: 600;
                color: #1e293b;
                border-bottom: 1px solid #e2e8f0;
                position: sticky;
                top: 0;
            }

            .bookings-table td {
                padding: 1rem;
                border-bottom: 1px solid #e2e8f0;
                color: #334155;
            }

            .bookings-table tr:last-child td {
                border-bottom: none;
            }

            .bookings-table tr:hover {
                background-color: #f8fafc;
            }

            /* Status Badges */
            .status-badge {
                display: inline-block;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 500;
                text-transform: uppercase;
            }

            .status-pending {
                background-color: #fef9c3;
                color: #854d0e;
            }

            .status-confirmed {
                background-color: #dcfce7;
                color: #166534;
            }

            .status-cancelled {
                background-color: #fee2e2;
                color: #b91c1c;
            }

            /* Action Buttons */
            .action-buttons {
                display: flex;
                gap: 0.5rem;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s;
                cursor: pointer;
                border: none;
            }

            .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }

            .btn-primary {
                background-color: #1e40af;
                color: white;
            }

            .btn-primary:hover {
                background-color: #1e3a8a;
            }

            .btn-success {
                background-color: #15803d;
                color: white;
            }

            .btn-success:hover {
                background-color: #166534;
            }

            .btn-danger {
                background-color: #b91c1c;
                color: white;
            }

            .btn-danger:hover {
                background-color: #991b1b;
            }

            .btn-outline {
                background-color: transparent;
                border: 1px solid #e2e8f0;
                color: #64748b;
            }

            .btn-outline:hover {
                background-color: #f8fafc;
                color: #334155;
            }

            .btn-icon {
                margin-right: 0.5rem;
                font-size: 0.875rem;
            }

            /* Pagination */
            .pagination {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 1.5rem;
                padding: 1rem;
                background-color: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            }

            .page-info {
                font-size: 0.875rem;
                color: #64748b;
            }

            .page-numbers {
                display: flex;
                gap: 0.25rem;
            }

            .page-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.25rem;
                height: 2.25rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                color: #1e293b;
                text-decoration: none;
                transition: all 0.2s;
                border: 1px solid #e2e8f0;
            }

            .page-link:hover {
                background-color: #f8fafc;
            }

            .page-link.active {
                background-color: #1e40af;
                color: white;
                border-color: #1e40af;
            }

            .page-ellipsis {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.25rem;
                height: 2.25rem;
                font-size: 0.875rem;
                color: #64748b;
            }

            /* Modal Styles */
            .modal-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 100;
                animation: fadeIn 0.2s;
            }

            .modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                border-radius: 0.5rem;
                width: 100%;
                max-width: 500px;
                z-index: 101;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                animation: slideIn 0.3s;
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.25rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .modal-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #1e293b;
            }

            .modal-close {
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #64748b;
                cursor: pointer;
                line-height: 1;
            }

            .modal-body {
                padding: 1.25rem;
            }

            .modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 0.75rem;
                padding: 1.25rem;
                border-top: 1px solid #e2e8f0;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translate(-50%, -60%);
                }
                to {
                    opacity: 1;
                    transform: translate(-50%, -50%);
                }
            }

            /* No results state */
            .no-results {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 3rem 1.5rem;
                text-align: center;
                background-color: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            }

            .no-results-icon {
                font-size: 3rem;
                color: #94a3b8;
                margin-bottom: 1.5rem;
            }

            .no-results-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 0.5rem;
            }

            .no-results-text {
                color: #64748b;
                max-width: 400px;
                margin-bottom: 1.5rem;
            }

            /* Responsive Adjustments */
            @media (max-width: 1024px) {
                .page-title {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }

                .actions-row {
                    flex-direction: column;
                    align-items: stretch;
                }

                .search-container {
                    max-width: none;
                }

                .filter-container {
                    justify-content: space-between;
                }
            }

            @media (max-width: 768px) {
                .content {
                    padding: 1rem;
                }

                .page-numbers {
                    display: none;
                }

                .page-info {
                    margin-right: auto;
                }

                .bookings-table th:nth-child(4),
                .bookings-table td:nth-child(4) {
                    display: none;
                }
            }

            @media (max-width: 640px) {
                .bookings-table th:nth-child(3),
                .bookings-table td:nth-child(3) {
                    display: none;
                }

                .action-buttons {
                    flex-direction: column;
                }
            }

            @media (max-width: 480px) {
                .bookings-table th:nth-child(5),
                .bookings-table td:nth-child(5) {
                    display: none;
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
                    <div class="page-title">
                        <h2>Manage Bookings</h2>
                    </div>
                    <p class="page-subtitle">View and manage all car rental bookings in the system</p>

                    <?php if ($msg) { ?>
                        <div class="success-message"><?php echo htmlentities($msg); ?></div>
                    <?php } ?>

                    <div class="actions-row">
                        <div class="search-container">
                            <span class="search-icon">🔍</span>
                            <input type="text" id="searchBooking" class="search-input" placeholder="Search bookings...">
                        </div>

                        <div class="filter-container">
                            <select class="filter-select" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>

                            <select class="filter-select" id="dateFilter">
                                <option value="">All Dates</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>
                        </div>
                    </div>

                    <div class="bookings-table-container">
                        <table class="bookings-table" id="bookingsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Vehicle</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Posting Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Pagination settings
                                $recordsPerPage = 10;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                $offset = ($page - 1) * $recordsPerPage;

                                // Get bookings with pagination
                                $sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.Status, tblbooking.PostingDate, tblbooking.id FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand=tblbrands.id ORDER BY tblbooking.id DESC LIMIT :offset, :recordsPerPage";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':offset', $offset, PDO::PARAM_INT);
                                $query->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                // Get total count for pagination
                                $countSql = "SELECT COUNT(id) as total FROM tblbooking";
                                $countQuery = $dbh->prepare($countSql);
                                $countQuery->execute();
                                $totalRecords = $countQuery->fetch(PDO::FETCH_OBJ)->total;
                                $totalPages = ceil($totalRecords / $recordsPerPage);

                                $cnt = $offset + 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($result->FullName); ?></td>
                                            <td>
                                                <span title="<?php echo htmlentities($result->VehiclesTitle); ?>">
                                                    <?php echo htmlentities($result->BrandName); ?> - 
                                                    <?php echo htmlentities(substr($result->VehiclesTitle, 0, 15)) . (strlen($result->VehiclesTitle) > 15 ? '...' : ''); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlentities(date('d/m/Y', strtotime($result->FromDate))); ?></td>
                                            <td><?php echo htmlentities(date('d/m/Y', strtotime($result->ToDate))); ?></td>
                                            <td><?php echo htmlentities(substr($result->message, 0, 20) . (strlen($result->message) > 20 ? '...' : '')); ?></td>
                                            <td>
                                                <?php
                                                if ($result->Status == "Pending") {
                                                    echo '<span class="status-badge status-pending">Pending</span>';
                                                } else if ($result->Status == "Confirmed") {
                                                    echo '<span class="status-badge status-confirmed">Confirmed</span>';
                                                } else {
                                                    echo '<span class="status-badge status-cancelled">Cancelled</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo htmlentities(date('d/m/Y g:i A', strtotime($result->PostingDate))); ?></td>
                                            <td class="action-buttons">
                                                <?php if ($result->Status == "Pending") { ?>
                                                    <a href="manage-bookings.php?eid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you really want to confirm this booking?')" class="btn btn-sm btn-success">Confirm</a>
                                                <?php } ?>

                                                <?php if ($result->Status == "Pending" || $result->Status == "Confirmed") { ?>
                                                    <a href="manage-bookings.php?aeid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you really want to cancel this booking?')" class="btn btn-sm btn-danger">Cancel</a>
                                                <?php } ?>

                                                <a href="javascript:void(0);" onclick="viewBookingDetails(<?php echo htmlentities($result->id); ?>)" class="btn btn-sm btn-outline">View</a>
                                            </td>
                                        </tr>
                                <?php
                                        $cnt = $cnt + 1;
                                    }
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="9">
                                            <div class="no-results">
                                                <div class="no-results-icon">📅</div>
                                                <h3 class="no-results-title">No bookings found</h3>
                                                <p class="no-results-text">There are no bookings in the system yet. Check back later or try adjusting your filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($totalPages > 1) { ?>
                        <div class="pagination">
                            <div class="page-info">
                                Showing <strong><?php echo min(($page - 1) * $recordsPerPage + 1, $totalRecords); ?></strong> to 
                                <strong><?php echo min($page * $recordsPerPage, $totalRecords); ?></strong> of 
                                <strong><?php echo $totalRecords; ?></strong> bookings
                            </div>

                            <div class="page-navigation">
                                <?php if ($page > 1) { ?>
                                    <a href="?page=<?php echo $page - 1; ?>" class="btn btn-sm btn-outline">&larr; Previous</a>
                                <?php } ?>

                                <div class="page-numbers">
                                    <?php
                                    $startPage = max(1, min($page - 2, $totalPages - 4));
                                    $endPage = min($startPage + 4, $totalPages);

                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        if ($i == $page) {
                                            echo '<a class="page-link active">' . $i . '</a>';
                                        } else {
                                            echo '<a href="?page=' . $i . '" class="page-link">' . $i . '</a>';
                                        }
                                    }
                                    ?>
                                </div>

                                <?php if ($page < $totalPages) { ?>
                                    <a href="?page=<?php echo $page + 1; ?>" class="btn btn-sm btn-outline">Next &rarr;</a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </main>
        </div>

        <!-- Booking Detail Modal -->
        <div class="modal-overlay" id="bookingDetailModal">
            <div class="modal">
                <div class="modal-header">
                    <h3 class="modal-title">Booking Details</h3>
                    <button class="modal-close" id="closeModal">&times;</button>
                </div>
                <div class="modal-body" id="bookingDetailContent">
                    <!-- Booking details will be loaded here via AJAX -->
                    <div style="text-align: center; padding: 2rem;">
                        <p>Loading booking details...</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                const searchInput = document.getElementById('searchBooking');
                const statusFilter = document.getElementById('statusFilter');
                const dateFilter = document.getElementById('dateFilter');
                const table = document.getElementById('bookingsTable');
                const rows = table.querySelectorAll('tbody tr');

                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase();
                    const statusValue = statusFilter.value;
                    const dateValue = dateFilter.value;
                    
                    rows.forEach(row => {
                        const rowContent = row.textContent.toLowerCase();
                        const statusCell = row.querySelector('td:nth-child(7)');
                        const statusText = statusCell ? statusCell.textContent.trim() : '';
                        const dateCell = row.querySelector('td:nth-child(8)');
                        const dateText = dateCell ? dateCell.textContent : '';
                        
                        // Check if row matches search text
                        const matchesSearch = searchTerm === '' || rowContent.includes(searchTerm);
                        
                        // Check if row matches status filter
                        const matchesStatus = statusValue === '' || statusText.includes(statusValue);
                        
                        // Check if row matches date filter
                        let matchesDate = true;
                        if (dateValue !== '') {
                            const bookingDate = new Date(dateText.split('/').reverse().join('-'));
                            const today = new Date();
                            today.setHours(0, 0, 0, 0);
                            
                            if (dateValue === 'today') {
                                const todayEnd = new Date(today);
                                todayEnd.setHours(23, 59, 59, 999);
                                matchesDate = bookingDate >= today && bookingDate <= todayEnd;
                            } else if (dateValue === 'week') {
                                const weekStart = new Date(today);
                                weekStart.setDate(today.getDate() - today.getDay());
                                const weekEnd = new Date(weekStart);
                                weekEnd.setDate(weekStart.getDate() + 6);
                                weekEnd.setHours(23, 59, 59, 999);
                                matchesDate = bookingDate >= weekStart && bookingDate <= weekEnd;
                            } else if (dateValue === 'month') {
                                const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                                const monthEnd = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                                monthEnd.setHours(23, 59, 59, 999);
                                matchesDate = bookingDate >= monthStart && bookingDate <= monthEnd;
                            }
                        }
                        
                        // Show or hide row based on all filters
                        if (matchesSearch && matchesStatus && matchesDate) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Check if there are any visible rows
                    checkNoResults();
                }

                function checkNoResults() {
                    let hasVisibleRows = false;
                    rows.forEach(row => {
                        if (row.style.display !== 'none') {
                            hasVisibleRows = true;
                        }
                    });

                    // If no visible rows, show no results message
                    let noResultsRow = table.querySelector('.no-results-row');
                    if (!hasVisibleRows && !noResultsRow) {
                        const tbody = table.querySelector('tbody');
                        noResultsRow = document.createElement('tr');
                        noResultsRow.className = 'no-results-row';
                        noResultsRow.innerHTML = `
                            <td colspan="9">
                                <div class="no-results">
                                    <div class="no-results-icon">🔍</div>
                                    <h3 class="no-results-title">No matching bookings</h3>
                                    <p class="no-results-text">No bookings match your current filters. Try adjusting your search criteria.</p>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(noResultsRow);
                    } else if (hasVisibleRows && noResultsRow) {
                        noResultsRow.remove();
                    }
                }

                // Add event listeners
                searchInput.addEventListener('input', filterTable);
                statusFilter.addEventListener('change',filterTable);
                dateFilter.addEventListener('change', filterTable);

                // Modal functionality
                const modal = document.getElementById('bookingDetailModal');
                const closeModalBtn = document.getElementById('closeModal');

                closeModalBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });

                window.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        modal.style.display = 'none';
                    }
                });

                // Expose viewBookingDetails function globally
                window.viewBookingDetails = function(bookingId) {
                    const bookingDetailContent = document.getElementById('bookingDetailContent');
                    bookingDetailContent.innerHTML = `
                        <div style="padding: 2rem; text-align: center;">
                            <p>Loading booking #${bookingId} details...</p>
                        </div>
                    `;
                    
                    // In a real application, you would use AJAX to load the booking details
                    // For demo purposes, we'll simulate loading booking details
                    setTimeout(() => {
                        // Find the booking data from the table
                        const bookingRow = document.querySelector(`tr[data-id="${bookingId}"]`) || 
                                        Array.from(rows).find(row => row.cells[0].textContent.trim() === bookingId.toString());
                        
                        if (bookingRow) {
                            const name = bookingRow.cells[1].textContent.trim();
                            const vehicle = bookingRow.cells[2].textContent.trim();
                            const fromDate = bookingRow.cells[3].textContent.trim();
                            const toDate = bookingRow.cells[4].textContent.trim();
                            const message = bookingRow.cells[5].textContent.trim();
                            const status = bookingRow.cells[6].textContent.trim();
                            const postingDate = bookingRow.cells[7].textContent.trim();
                            
                            bookingDetailContent.innerHTML = `
                                <div style="padding: 1rem;">
                                    <div style="margin-bottom: 1.5rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                            <h4 style="font-size: 1.25rem; font-weight: 600;">Booking #${bookingId}</h4>
                                            <div>${status}</div>
                                        </div>
                                        <p style="color: #64748b; font-size: 0.875rem;">Booked on ${postingDate}</p>
                                    </div>
                                    
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                                        <div>
                                            <h5 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Customer</h5>
                                            <p style="font-weight: 500;">${name}</p>
                                        </div>
                                        <div>
                                            <h5 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Vehicle</h5>
                                            <p style="font-weight: 500;">${vehicle}</p>
                                        </div>
                                    </div>
                                    
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                                        <div>
                                            <h5 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">From Date</h5>
                                            <p>${fromDate}</p>
                                        </div>
                                        <div>
                                            <h5 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">To Date</h5>
                                            <p>${toDate}</p>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-bottom: 1.5rem;">
                                        <h5 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Message</h5>
                                        <p style="background-color: #f8fafc; padding: 1rem; border-radius: 0.375rem;">${message}</p>
                                    </div>
                                </div>
                            `;
                        } else {
                            bookingDetailContent.innerHTML = `
                                <div style="padding: 2rem; text-align: center;">
                                    <p>Error loading booking details. Please try again.</p>
                                </div>
                            `;
                        }
                    }, 500);
                    
                    modal.style.display = 'block';
                };

                // Handle window resize for sidebar
                window.addEventListener('resize', function() {
                    const sidebar = document.querySelector('.sidebar');
                    if (window.innerWidth > 768 && sidebar) {
                        sidebar.classList.remove('active');
                    }
                });
            });
        </script>
    </body>

    </html>
<?php } ?>