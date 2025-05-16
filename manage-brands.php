<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
}
else {
    if(isset($_GET['del'])) {
        $id=$_GET['del'];
        $sql = "delete from tblbrands WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id',$id, PDO::PARAM_STR);
        $query->execute();
        $msg="Brand deleted successfully";
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="Car Rental Portal Admin Manage Brands">
    <meta name="author" content="">
    
    <title>Car Rental Portal | Admin Manage Brands</title>
    
    <!-- <link rel="stylesheet" href="css/manage-brands.css"> -->
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

/* Card Styles */
.card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.card-header h3 {
    font-size: 1.25rem;
    color: #1e293b;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

/* Table Styles */
.table-container {
    overflow-x: auto;
    margin: 1rem 0;
}

.table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 0.875rem;
}

.table th {
    background-color: #f8fafc;
    padding: 0.75rem 1rem;
    font-weight: 600;
    color: #475569;
    border-bottom: 2px solid #e2e8f0;
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    color: #1e293b;
}

.table tbody tr:hover {
    background-color: #f1f5f9;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-icon {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
    color: #475569;
}

.btn-icon:hover {
    background-color: #e2e8f0;
    color: #1e40af;
}

.btn-edit:hover {
    color: #1e40af;
}

.btn-delete:hover {
    color: #dc2626;
}

/* Alert Messages */
.alert {
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
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

/* Responsive Design */
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
        padding: 1rem;
    }
    
    .table th,
    .table td {
        padding: 0.75rem;
    }
}

@media (max-width: 480px) {
    .table-container {
        margin: 0.5rem -1rem;
        width: calc(100% + 2rem);
    }
    
    .table th,
    .table td {
        padding: 0.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
}



 #deleteModal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-content {
            background: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        .modal-content h3 {
            margin-bottom: 1rem;
        }
        .modal-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 1.5rem;
        }
        .modal-buttons button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal-delete {
            background-color: #dc2626;
            color: white;
        }
        .modal-cancel {
            background-color: #e2e8f0;
            color: #1e293b;
        }
	 </style>
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="main-container">
    <?php include('includes/leftbar.php'); ?>
    <main class="content">
        <div class="content-container">
            <h2 class="page-title">Manage Brands</h2>

            <div class="card">
                <div class="card-header">
                    <h3>Listed Brands</h3>
                </div>
                <div class="card-body">

                    <?php if($error){ ?>
                        <div class="alert error">
                            <strong>Error:</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php } else if($msg){ ?>
                        <div class="alert success">
                            <strong>Success:</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php } ?>

                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Brand Name</th>
                                    <th>Creation Date</th>
                                    <th>Last Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql = "SELECT * from tblbrands";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) {
                                ?>	
                                <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($result->BrandName);?></td>
                                    <td><?php echo htmlentities($result->CreationDate);?></td>
                                    <td><?php echo htmlentities($result->UpdationDate);?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit-brand.php?id=<?php echo $result->id;?>" 
                                               class="btn-icon btn-edit" 
                                               title="Edit Brand">
                                                ✏️
                                            </a>
                                            <button class="btn-icon btn-delete" 
                                                    onclick="showDeleteModal(<?php echo $result->id; ?>)" 
                                                    title="Delete Brand">
                                                🗑️
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php $cnt++; } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>This action cannot be undone. Are you sure you want to delete this brand?</p>
        <div class="modal-buttons">
            <button class="modal-delete" onclick="confirmDeletion()">Delete</button>
            <button class="modal-cancel" onclick="hideDeleteModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
    let deleteId = null;

    function showDeleteModal(id) {
        deleteId = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function hideDeleteModal() {
        deleteId = null;
        document.getElementById('deleteModal').style.display = 'none';
    }

    function confirmDeletion() {
        if (deleteId !== null) {
            window.location.href = 'manage-brands.php?del=' + deleteId;
        }
    }

    // Sorting logic remains the same
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('.table');
        const headers = table.querySelectorAll('th');
        
        headers.forEach((header, index) => {
            if (index === 4) return; // Skip Actions column
            
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                const rows = Array.from(table.querySelectorAll('tbody tr'));
                const isNumeric = index === 0;
                
                rows.sort((a, b) => {
                    const aValue = a.cells[index].textContent.trim();
                    const bValue = b.cells[index].textContent.trim();
                    
                    if (isNumeric) {
                        return parseInt(aValue) - parseInt(bValue);
                    }
                    return aValue.localeCompare(bValue);
                });
                
                if (header.classList.contains('sorted-asc')) {
                    rows.reverse();
                    header.classList.remove('sorted-asc');
                    header.classList.add('sorted-desc');
                } else {
                    header.classList.remove('sorted-desc');
                    header.classList.add('sorted-asc');
                }
                
                const tbody = table.querySelector('tbody');
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
</script>
</body>
</html>
<?php } ?>