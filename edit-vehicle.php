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
        $id = intval($_GET['id']);

        $sql = "update tblvehicles set VehiclesTitle=:vehicletitle,VehiclesBrand=:brand,VehiclesOverview=:vehicleoverview,PricePerDay=:priceperday,FuelType=:fueltype,ModelYear=:modelyear,SeatingCapacity=:seatingcapacity,AirConditioner=:airconditioner,PowerDoorLocks=:powerdoorlocks,AntiLockBrakingSystem=:antilockbrakingsys,BrakeAssist=:brakeassist,PowerSteering=:powersteering,DriverAirbag=:driverairbag,PassengerAirbag=:passengerairbag,PowerWindows=:powerwindow,CDPlayer=:cdplayer,CentralLocking=:centrallocking,CrashSensor=:crashcensor,LeatherSeats=:leatherseats where id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
        $query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
        $query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
        $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
        $query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
        $query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
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
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Vehicle updated successfully";
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

        <title>Car Rental Portal | Edit Vehicle</title>

        <!-- <link rel="stylesheet" href="css/edit-vehicle.css"> -->
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

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #1e293b;
                margin: 2rem 0 1rem;
                padding-bottom: 0.5rem;
                border-bottom: 2px solid #e2e8f0;
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
            .form-row {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 1.5rem;
            }

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

            textarea.form-control {
                min-height: 100px;
                resize: vertical;
            }

            /* Image Grid */
            .image-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                margin: 1rem 0;
            }

            .image-item {
                position: relative;
                border-radius: 0.375rem;
                overflow: hidden;
            }

            .image-item img {
                width: 100%;
                height: 150px;
                object-fit: cover;
                border-radius: 0.375rem;
            }

            .change-image {
                display: block;
                text-align: center;
                padding: 0.5rem;
                background: #1e40af;
                color: white;
                text-decoration: none;
                margin-top: 0.5rem;
                border-radius: 0.375rem;
                transition: background-color 0.2s;
            }

            .change-image:hover {
                background: #1e3a8a;
            }

            /* Accessories Grid */
            .accessories-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                margin: 1rem 0;
            }

            .checkbox-wrapper {
                display: flex;
                align-items: center;
                padding: 0.5rem;
                border-radius: 0.375rem;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .checkbox-wrapper:hover {
                background-color: #f1f5f9;
            }

            .checkbox-wrapper input[type="checkbox"] {
                margin-right: 0.5rem;
                width: 1.25rem;
                height: 1.25rem;
            }

            .checkbox-label {
                font-size: 0.875rem;
                color: #475569;
            }

            /* Buttons */
            .form-actions {
                display: flex;
                justify-content: flex-end;
                margin-top: 2rem;
                padding-top: 1rem;
                border-top: 1px solid #e2e8f0;
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
            .success-message {
                background-color: #dcfce7;
                border-left: 4px solid #16a34a;
                color: #15803d;
                padding: 1rem;
                margin-bottom: 1.5rem;
                border-radius: 0.375rem;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .main-content {
                    flex-direction: column;
                }

                .content-wrapper {
                    padding: 1rem;
                }

                .form-row {
                    grid-template-columns: 1fr;
                }

                .image-grid {
                    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                }

                .accessories-grid {
                    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
                    <h2 class="page-title">Edit Vehicle</h2>

                    <?php if ($msg) { ?>
                        <div class="success-message">
                            <strong>SUCCESS:</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php } ?>

                    <?php
                    $id = intval($_GET['id']);
                    $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblvehicles.id=:id";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':id', $id, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                    ?>

                            <div class="card">
                                <div class="card-header">Basic Information</div>
                                <div class="card-body">
                                    <form method="post" id="editVehicleForm" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="vehicletitle">Vehicle Title</label>
                                                <input type="text" name="vehicletitle" id="vehicletitle" class="form-control" value="<?php echo htmlentities($result->VehiclesTitle) ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="brandname">Select Brand</label>
                                                <select name="brandname" id="brandname" class="form-control" required>
                                                    <option value="<?php echo htmlentities($result->bid); ?>"><?php echo htmlentities($result->BrandName); ?></option>
                                                    <?php
                                                    $ret = "select id,BrandName from tblbrands";
                                                    $query = $dbh->prepare($ret);
                                                    $query->execute();
                                                    $resultss = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($resultss as $results) {
                                                            if ($results->BrandName == $result->BrandName) continue;
                                                    ?>
                                                            <option value="<?php echo htmlentities($results->id); ?>"><?php echo htmlentities($results->BrandName); ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="vehicalorcview">Vehicle Overview</label>
                                            <textarea name="vehicalorcview" id="vehicalorcview" class="form-control" rows="3" required><?php echo htmlentities($result->VehiclesOverview); ?></textarea>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="priceperday">Price Per Day (USD)</label>
                                                <input type="number" name="priceperday" id="priceperday" class="form-control" value="<?php echo htmlentities($result->PricePerDay); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="fueltype">Fuel Type</label>
                                                <select name="fueltype" id="fueltype" class="form-control" required>
                                                    <option value="<?php echo htmlentities($result->FuelType); ?>"><?php echo htmlentities($result->FuelType); ?></option>
                                                    <option value="Petrol">Petrol</option>
                                                    <option value="Diesel">Diesel</option>
                                                    <option value="CNG">CNG</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="modelyear">Model Year</label>
                                                <input type="number" name="modelyear" id="modelyear" class="form-control" value="<?php echo htmlentities($result->ModelYear); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="seatingcapacity">Seating Capacity</label>
                                                <input type="number" name="seatingcapacity" id="seatingcapacity" class="form-control" value="<?php echo htmlentities($result->SeatingCapacity); ?>" required>
                                            </div>
                                        </div>

                                        <div class="section-title">Vehicle Images</div>
                                        <div class="image-grid">
                                            <div class="image-item">
                                                <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="Vehicle Image 1">
                                                <a href="changeimage.php?imgid=<?php echo htmlentities($result->id) ?>" class="change-image">Change Image 1</a>
                                            </div>
                                            <div class="image-item">
                                                <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" alt="Vehicle Image 2">
                                                <a href="changeimage.php?imgid=<?php echo htmlentities($result->id) ?>" class="change-image">Change Image 2</a>
                                            </div>
                                            <div class="image-item">
                                                <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" alt="Vehicle Image 3">
                                                <a href="changeimage.php?imgid=<?php echo htmlentities($result->id) ?>" class="change-image">Change Image 3</a>
                                            </div>
                                            <div class="image-item">
                                                <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage4); ?>" alt="Vehicle Image 4">
                                                <a href="changeimage.php?imgid=<?php echo htmlentities($result->id) ?>" class="change-image">Change Image 4</a>
                                            </div>
                                            <div class="image-item">
                                                <?php if ($result->Vimage5 == "") {
                                                    echo htmlentities("File not available");
                                                } else { ?>
                                                    <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" alt="Vehicle Image 5">
                                                    <a href="changeimage.php?imgid=<?php echo htmlentities($result->id) ?>" class="change-image">Change Image 5</a>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="section-title">Accessories</div>
                                        <div class="accessories-grid">
                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="airconditioner" value="1" <?php if ($result->AirConditioner == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Air Conditioner</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="powerdoorlocks" value="1" <?php if ($result->PowerDoorLocks == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Power Door Locks</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="antilockbrakingsys" value="1" <?php if ($result->AntiLockBrakingSystem == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">AntiLock Braking System</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="brakeassist" value="1" <?php if ($result->BrakeAssist == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Brake Assist</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="powersteering" value="1" <?php if ($result->PowerSteering == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Power Steering</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="driverairbag" value="1" <?php if ($result->DriverAirbag == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Driver Airbag</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="passengerairbag" value="1" <?php if ($result->PassengerAirbag == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Passenger Airbag</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="powerwindow" value="1" <?php if ($result->PowerWindows == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Power Windows</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="cdplayer" value="1" <?php if ($result->CDPlayer == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">CD Player</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="centrallocking" value="1" <?php if ($result->CentralLocking == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Central Locking</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="crashcensor" value="1" <?php if ($result->CrashSensor == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Crash Sensor</span>
                                            </label>

                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" name="leatherseats" value="1" <?php if ($result->LeatherSeats == 1) echo 'checked'; ?>>
                                                <span class="checkbox-label">Leather Seats</span>
                                            </label>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" name="submit" class="btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>

        <!-- <script src="js/edit-vehicle.js"></script> -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('editVehicleForm');

                // Form validation
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('error');

                            // Create error message
                            const errorMsg = document.createElement('span');
                            errorMsg.className = 'error-message';
                            errorMsg.textContent = 'This field is required';

                            // Remove existing error message if any
                            const existingError = field.parentElement.querySelector('.error-message');
                            if (existingError) {
                                existingError.remove();
                            }

                            field.parentElement.appendChild(errorMsg);
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                    }
                });

                // Remove error styling on input
                const inputs = form.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        this.classList.remove('error');
                        const errorMsg = this.parentElement.querySelector('.error-message');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    });
                });

                // Number input validation
                const numberInputs = form.querySelectorAll('input[type="number"]');
                numberInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        if (this.value < 0) {
                            this.value = 0;
                        }
                    });
                });

                // Auto-hide success message
                const successMessage = document.querySelector('.success-message');
                if (successMessage) {
                    setTimeout(() => {
                        successMessage.style.opacity = '0';
                        successMessage.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => successMessage.style.display = 'none', 500);
                    }, 5000);
                }

                // Image preview on hover
                const images = document.querySelectorAll('.image-item img');
                images.forEach(img => {
                    img.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.05)';
                        this.style.transition = 'transform 0.2s ease';
                    });

                    img.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                });
            });
        </script>
    </body>

    </html>
<?php } ?>