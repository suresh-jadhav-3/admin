<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Get image ID from URL
    $imgid = intval($_GET['imgid']);
    $img = intval($_GET['img'] ?? 1); // Default to image 1 if not specified

    if (isset($_POST['update'])) {
        $vimage = $_FILES["vehicleimage"]["name"];
        
        // Validate file type
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = strtolower(pathinfo($vimage, PATHINFO_EXTENSION));
        
        if (!in_array($file_ext, $allowed_types)) {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else if ($_FILES["vehicleimage"]["size"] > 1048576) { // 1MB max file size
            $error = "Sorry, your file is too large. Maximum file size is 1MB.";
        } else {
            // Generate unique filename
            $vimage = md5($vimage) . time() . "." . $file_ext;
            
            // Move uploaded file
            move_uploaded_file($_FILES["vehicleimage"]["tmp_name"], "img/vehicleimages/" . $vimage);
            
            // Update database
            $imgfield = "Vimage" . $img;
            $sql = "UPDATE tblvehicles SET $imgfield=:vimage WHERE id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':vimage', $vimage, PDO::PARAM_STR);
            $query->bindParam(':id', $imgid, PDO::PARAM_STR);
            $query->execute();
            
            $msg = "Image updated successfully";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Car Rental Portal | Change Vehicle Image</title>

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

        /* Card Styles */
        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
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

        /* Form Styles */
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
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Image Container */
        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }

        .current-image-wrapper {
            width: 100%;
            max-width: 400px;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .current-image {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0.375rem;
            transition: transform 0.3s ease;
        }

        .current-image:hover {
            transform: scale(1.02);
        }

        .image-label {
            margin-top: 0.5rem;
            font-weight: 500;
            color: #475569;
        }

        /* Navigation */
        .image-nav {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .image-nav-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            margin: 0 0.25rem;
            border-radius: 9999px;
            background-color: #e2e8f0;
            color: #475569;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .image-nav-item:hover, .image-nav-item.active {
            background-color: #1e40af;
            color: white;
        }

        .image-nav-item.active {
            pointer-events: none;
        }

        /* File Input */
        .file-input-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .file-input-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed #cbd5e1;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-input-label:hover {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.05);
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-input-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #64748b;
        }

        .file-input-text {
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.25rem;
        }

        .file-input-subtext {
            font-size: 0.875rem;
            color: #64748b;
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #3b82f6;
            font-weight: 500;
        }

        /* Buttons */
        .btn-row {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
        }

        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
        }

        .alert-success {
            background-color: #dcfce7;
            border-left: 4px solid #16a34a;
            color: #15803d;
        }

        .alert-danger {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            color: #b91c1c;
        }

        /* Help text */
        .help-text {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .image-nav {
                flex-wrap: wrap;
            }

            .image-nav-item {
                margin-bottom: 0.5rem;
            }

            .btn-row {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
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
                <h2 class="page-title">Change Vehicle Image</h2>

                <?php
                // Display success message
                if (isset($msg)) { ?>
                    <div class="alert alert-success">
                        <strong>SUCCESS:</strong> <?php echo htmlentities($msg); ?>
                    </div>
                <?php } ?>

                <?php
                // Display error message
                if (isset($error)) { ?>
                    <div class="alert alert-danger">
                        <strong>ERROR:</strong> <?php echo htmlentities($error); ?>
                    </div>
                <?php } ?>

                <?php
                // Fetch current vehicle details
                $sql = "SELECT tblvehicles.*, tblbrands.BrandName from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:imgid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':imgid', $imgid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        $vimage = "Vimage" . $img;
                ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo htmlentities($result->BrandName . " " . $result->VehiclesTitle); ?> - Change Image <?php echo $img; ?>
                    </div>
                    <div class="card-body">
                        <!-- Navigation between images -->
                        <div class="image-nav">
                            <?php for($i = 1; $i <= 5; $i++) { 
                                $active = $i == $img ? 'active' : '';
                            ?>
                            <a href="changeimage.php?imgid=<?php echo $imgid; ?>&img=<?php echo $i; ?>" class="image-nav-item <?php echo $active; ?>">
                                <?php echo $i; ?>
                            </a>
                            <?php } ?>
                        </div>

                        <!-- Current Image Display -->
                        <div class="image-container">
                            <div class="current-image-wrapper">
                                <?php if($result->$vimage == "") { ?>
                                    <img src="img/vehicleimages/no-image.png" alt="No Image Available" class="current-image">
                                <?php } else { ?>
                                    <img src="img/vehicleimages/<?php echo htmlentities($result->$vimage); ?>" alt="Vehicle Image" class="current-image">
                                <?php } ?>
                            </div>
                            <span class="image-label">Current Image <?php echo $img; ?></span>
                        </div>

                        <form method="post" enctype="multipart/form-data">
                            <!-- File Input -->
                            <div class="file-input-wrapper">
                                <label class="file-input-label">
                                    <span class="file-input-icon">📁</span>
                                    <span class="file-input-text">Choose a new image</span>
                                    <span class="file-input-subtext">or drag and drop it here</span>
                                    <input type="file" name="vehicleimage" id="vehicleimage" class="file-input" required>
                                    <span id="file-name" class="file-name"></span>
                                </label>
                            </div>
                            <p class="help-text">Allowed file types: JPG, JPEG, PNG, GIF. Maximum file size: 1MB</p>

                            <!-- Action Buttons -->
                            <div class="btn-row">
                                <a href="edit-vehicle.php?id=<?php echo $imgid; ?>" class="btn btn-secondary">Back to Edit Vehicle</a>
                                <button type="submit" name="update" class="btn btn-primary">Update Image</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>

    <script>

        const menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        });
    }
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('vehicleimage');
            const fileName = document.getElementById('file-name');
            const alertSuccess = document.querySelector('.alert-success');
            const alertDanger = document.querySelector('.alert-danger');
            
            // Display file name when selected
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileName.textContent = this.files[0].name;
                    
                    // Validate file size
                    if (this.files[0].size > 1048576) { // 1MB
                        alert('File size exceeds 1MB. Please choose a smaller file.');
                        this.value = '';
                        fileName.textContent = '';
                    }
                    
                    // Validate file type
                    const fileType = this.files[0].type;
                    if (fileType !== 'image/jpeg' && fileType !== 'image/jpg' && fileType !== 'image/png' && fileType !== 'image/gif') {
                        alert('Please select an image file (JPG, JPEG, PNG, GIF).');
                        this.value = '';
                        fileName.textContent = '';
                    }
                }
            });
            
            // Drag and drop functionality
            const dropZone = document.querySelector('.file-input-label');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropZone.classList.add('highlight');
            }
            
            function unhighlight() {
                dropZone.classList.remove('highlight');
            }
            
            dropZone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                // Trigger change event manually
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
            
            // Auto-hide alerts after 5 seconds
            if (alertSuccess || alertDanger) {
                setTimeout(() => {
                    if (alertSuccess) {
                        alertSuccess.style.opacity = '0';
                        alertSuccess.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => alertSuccess.style.display = 'none', 500);
                    }
                    if (alertDanger) {
                        alertDanger.style.opacity = '0';
                        alertDanger.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => alertDanger.style.display = 'none', 500);
                    }
                }, 5000);
            }
            
            // Preview image before upload
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    const currentImage = document.querySelector('.current-image');
                    
                    reader.onload = function(e) {
                        currentImage.src = e.target.result;
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
</body>
</html>
<?php } ?>