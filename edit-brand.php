<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $brand = $_POST['brand'];
        $id = $_GET['id'];
        $sql = "update tblbrands set BrandName=:brand where id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        $msg = "Brand Update successfully";
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

        <title>Car Rental Portal | Admin Update Brand</title>

        <!-- <link rel="stylesheet" href="css/edit-brand.css"> -->
        <style>
            /* Base Styles */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                background-color: #f8fafc;
                color: #334155;
                line-height: 1.5;
            }

            .main-content {
                display: flex;
                min-height: calc(100vh - 64px);
            }

            .content-wrapper {
                flex: 1;
                padding: 2rem;
                overflow-y: auto;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
            }

            /* Typography */
            .page-title {
                font-size: 1.75rem;
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 1.5rem;
            }

            /* Cards */
            .card-container {
                display: flex;
                justify-content: center;
            }

            .card {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                width: 100%;
                max-width: 600px;
                overflow: hidden;
            }

            .card-header {
                background-color: #f8fafc;
                color: #1e293b;
                font-weight: 600;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .card-body {
                padding: 1.5rem;
            }

            /* Forms */
            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group label {
                display: block;
                font-weight: 500;
                margin-bottom: 0.5rem;
                color: #475569;
            }

            .form-control {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #cbd5e1;
                border-radius: 0.375rem;
                font-size: 1rem;
                color: #1e293b;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .form-control:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            }

            .divider {
                height: 1px;
                background-color: #e2e8f0;
                margin: 1.5rem 0;
            }

            .form-actions {
                display: flex;
                justify-content: flex-end;
            }

            .btn-primary {
                background-color: #1e40af;
                color: white;
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 0.375rem;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .btn-primary:hover {
                background-color: #1e3a8a;
            }

            .btn-primary:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.4);
            }

            /* Alert Messages */
            .error-message,
            .success-message {
                padding: 1rem;
                margin-bottom: 1.5rem;
                border-radius: 0.375rem;
            }

            .error-message {
                background-color: #fee2e2;
                border-left: 4px solid #dc2626;
                color: #b91c1c;
            }

            .success-message {
                background-color: #dcfce7;
                border-left: 4px solid #16a34a;
                color: #15803d;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .main-content {
                    flex-direction: column;
                }

                .content-wrapper {
                    padding: 1rem;
                }

                .card {
                    box-shadow: none;
                    border: 1px solid #e2e8f0;
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
                    <h2 class="page-title">Update Brand</h2>

                    <div class="card-container">
                        <div class="card">
                            <div class="card-header">Update Brand</div>
                            <div class="card-body">
                                <?php if ($error) { ?>
                                    <div class="error-message">
                                        <strong>ERROR:</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                <?php } else if ($msg) { ?>
                                    <div class="success-message">
                                        <strong>SUCCESS:</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>

                                <?php
                                $id = $_GET['id'];
                                $ret = "select * from tblbrands where id=:id";
                                $query = $dbh->prepare($ret);
                                $query->bindParam(':id', $id, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                ?>

                                        <form method="post" name="updateBrand" id="updateBrandForm">
                                            <div class="form-group">
                                                <label for="brand">Brand Name</label>
                                                <input type="text" class="form-control" value="<?php echo htmlentities($result->BrandName); ?>" name="brand" id="brand" required>
                                            </div>
                                            <div class="divider"></div>

                                            <div class="form-actions">
                                                <button class="btn-primary" name="submit" type="submit">Update Brand</button>
                                            </div>
                                        </form>

                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <script src="js/edit-brand.js"></script> -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('updateBrandForm');
                const brandInput = document.getElementById('brand');

                // Form validation
                form.addEventListener('submit', function(e) {
                    if (!brandInput.value.trim()) {
                        e.preventDefault();
                        brandInput.classList.add('error');
                        alert('Please enter a brand name');
                        return false;
                    }
                });

                // Input validation and styling
                brandInput.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('error');
                    }
                });

                // Auto-hide alerts after 5 seconds
                const alerts = document.querySelectorAll('.error-message, .success-message');
                if (alerts.length > 0) {
                    setTimeout(function() {
                        alerts.forEach(alert => {
                            alert.style.opacity = '0';
                            alert.style.transition = 'opacity 0.5s ease';
                            setTimeout(() => alert.style.display = 'none', 500);
                        });
                    }, 5000);
                }
            });
        </script>
    </body>

    </html>
<?php } ?>