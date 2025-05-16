<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {
    if(isset($_REQUEST['eid'])) {
        $eid=intval($_GET['eid']);
        $status="2";
        $sql = "UPDATE tblbooking SET Status=:status WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status',$status, PDO::PARAM_STR);
        $query->bindParam(':eid',$eid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Booking Successfully Cancelled');</script>";
        echo "<script type='text/javascript'> document.location = 'canceled-bookings.php'; </script>";
    }

    if(isset($_REQUEST['aeid'])) {
        $aeid=intval($_GET['aeid']);
        $status=1;
        $sql = "UPDATE tblbooking SET Status=:status WHERE id=:aeid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status',$status, PDO::PARAM_STR);
        $query->bindParam(':aeid',$aeid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Booking Successfully Confirmed');</script>";
        echo "<script type='text/javascript'> document.location = 'confirmed-bookings.php'; </script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Portal | Booking Details</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        /* Layout */
        .ts-main-content {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            padding: 2rem;
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Typography */
        .page-title {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        /* Panel Styles */
        .panel {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .panel-heading {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            color: #2c3e50;
        }

        .panel-body {
            padding: 1.5rem;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border: 1px solid #eee;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .table tr:nth-child(even) {
            background: #f8f9fa;
        }

        /* Section Headers */
        .section-header {
            text-align: center;
            color: #2c3e50;
            padding: 1rem;
            background: #f8f9fa;
            margin: 1rem 0;
            border-radius: 4px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-print {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 1rem;
        }

        .btn-print:hover {
            background: #27ae60;
        }

        /* Status Colors */
        .status {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            display: inline-block;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        /* Action Buttons Container */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ts-main-content {
                flex-direction: column;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .table {
                display: block;
                overflow-x: auto;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                margin: 0.5rem 0;
                text-align: center;
            }
        }

        /* Print Styles */
        @media print {
            .btn, .action-buttons {
                display: none;
            }

            body {
                background: white;
            }

            .panel {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <h2 class="page-title">Booking Details</h2>
                <div class="panel">
                    <div class="panel-heading">Bookings Info</div>
                    <div class="panel-body">
                        <div id="print">
                            <?php 
                            $bid=intval($_GET['bid']);
                            $sql = "SELECT tblusers.*,tblbrands.BrandName,tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id,tblbooking.BookingNumber,
                            DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totalnodays,tblvehicles.PricePerDay
                            from tblbooking join tblvehicles on tblvehicles.id=tblbooking.VehicleId join tblusers on tblusers.EmailId=tblbooking.userEmail join tblbrands on tblvehicles.VehiclesBrand=tblbrands.id where tblbooking.id=:bid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':bid',$bid, PDO::PARAM_STR);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            if($query->rowCount() > 0) {
                                foreach($results as $result) { ?>
                                    <h3 class="section-header">Booking #<?php echo htmlentities($result->BookingNumber);?></h3>
                                    <table class="table">
                                        <tr>
                                            <th colspan="4" class="section-header">User Details</th>
                                        </tr>
                                        <tr>
                                            <th>Booking No.</th>
                                            <td>#<?php echo htmlentities($result->BookingNumber);?></td>
                                            <th>Name</th>
                                            <td><?php echo htmlentities($result->FullName);?></td>
                                        </tr>
                                        <tr>
                                            <th>Email Id</th>
                                            <td><?php echo htmlentities($result->EmailId);?></td>
                                            <th>Contact No</th>
                                            <td><?php echo htmlentities($result->ContactNo);?></td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td><?php echo htmlentities($result->Address);?></td>
                                            <th>City</th>
                                            <td><?php echo htmlentities($result->City);?></td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td colspan="3"><?php echo htmlentities($result->Country);?></td>
                                        </tr>

                                        <tr>
                                            <th colspan="4" class="section-header">Booking Details</th>
                                        </tr>
                                        <tr>
                                            <th>Vehicle Name</th>
                                            <td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></a></td>
                                            <th>Booking Date</th>
                                            <td><?php echo htmlentities($result->PostingDate);?></td>
                                        </tr>
                                        <tr>
                                            <th>From Date</th>
                                            <td><?php echo htmlentities($result->FromDate);?></td>
                                            <th>To Date</th>
                                            <td><?php echo htmlentities($result->ToDate);?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Days</th>
                                            <td><?php echo htmlentities($tdays=$result->totalnodays);?></td>
                                            <th>Rent Per Day</th>
                                            <td>$<?php echo htmlentities($ppdays=$result->PricePerDay);?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="section-header">Grand Total</th>
                                            <td>$<?php echo htmlentities($tdays*$ppdays);?></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Status</th>
                                            <td>
                                                <?php 
                                                if($result->Status==0) {
                                                    echo '<span class="status status-pending">Not Confirmed yet</span>';
                                                } else if ($result->Status==1) {
                                                    echo '<span class="status status-confirmed">Confirmed</span>';
                                                } else {
                                                    echo '<span class="status status-cancelled">Cancelled</span>';
                                                }
                                                ?>
                                            </td>
                                            <th>Last Update</th>
                                            <td><?php echo htmlentities($result->LastUpdationDate);?></td>
                                        </tr>
                                    </table>

                                    <?php if($result->Status==0) { ?>
                                        <div class="action-buttons">
                                            <a href="booking-details.php?aeid=<?php echo htmlentities($result->id);?>" 
                                               class="btn btn-primary" 
                                               onclick="return confirm('Do you really want to Confirm this booking?')">
                                                Confirm Booking
                                            </a>
                                            <a href="booking-details.php?eid=<?php echo htmlentities($result->id);?>" 
                                               class="btn btn-danger" 
                                               onclick="return confirm('Do you really want to Cancel this Booking?')">
                                                Cancel Booking
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php }
                            } ?>
                        </div>
                        <button class="btn-print" onclick="printBooking()">Print Booking Details</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printBooking() {
            window.print();
        }

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add fade-in animation for status messages
        document.addEventListener('DOMContentLoaded', function() {
            const statusElements = document.querySelectorAll('.status');
            statusElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    element.style.opacity = '1';
                }, 100);
            });
        });
    </script>
</body>
</html>
<?php } ?>