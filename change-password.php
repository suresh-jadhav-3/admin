<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:index.php');
}
else{
// Code for change password	
if(isset($_POST['submit']))
{
    $password=md5($_POST['password']);
    $newpassword=md5($_POST['newpassword']);
    $username=$_SESSION['alogin'];
    $sql ="SELECT Password FROM admin WHERE UserName=:username and Password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    if($query -> rowCount() > 0)
    {
        $con="update admin set Password=:newpassword where UserName=:username";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        $msg="Your Password succesfully changed";
    }
    else {
        $error="Your current password is not valid.";	
    }
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
    
    <title>Car Rental Portal | Admin Change Password</title>

    <!-- <link rel="stylesheet" href="css/change-password.css"> -->
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
.error-message, .success-message {
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

.error-text {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
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
    <?php include('includes/header.php');?>
    <div class="main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container">
                <h2 class="page-title">Change Password</h2>

                <div class="card-container">
                    <div class="card">
                        <div class="card-header">Form Fields</div>
                        <div class="card-body">
                            <?php if($error){?>
                                <div class="error-message">
                                    <strong>ERROR:</strong> <?php echo htmlentities($error); ?>
                                </div>
                            <?php } else if($msg){?>
                                <div class="success-message">
                                    <strong>SUCCESS:</strong> <?php echo htmlentities($msg); ?>
                                </div>
                            <?php }?>

                            <form method="post" name="chngpwd" id="changePasswordForm" onSubmit="return validateForm();">
                                <div class="form-group">
                                    <label for="password">Current Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <div class="divider"></div>
                                
                                <div class="form-group">
                                    <label for="newpassword">New Password</label>
                                    <input type="password" class="form-control" name="newpassword" id="newpassword" required>
                                </div>
                                <div class="divider"></div>

                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                                    <span id="password-match-error" class="error-text"></span>
                                </div>
                                <div class="divider"></div>
                            
                                <div class="form-actions">
                                    <button class="btn-primary" name="submit" type="submit">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="js/change-password.js"></script> -->
	 <script>
		document.addEventListener('DOMContentLoaded', function() {
    // Password matching validation
    const newPasswordInput = document.getElementById('newpassword');
    const confirmPasswordInput = document.getElementById('confirmpassword');
    const passwordMatchError = document.getElementById('password-match-error');
    
    // Function to check if passwords match
    function checkPasswordMatch() {
        if (confirmPasswordInput.value && newPasswordInput.value !== confirmPasswordInput.value) {
            passwordMatchError.textContent = "New Password and Confirm Password do not match!";
            confirmPasswordInput.style.borderColor = "#dc2626";
            return false;
        } else {
            passwordMatchError.textContent = "";
            confirmPasswordInput.style.borderColor = "";
            return true;
        }
    }
    
    // Add event listeners to password fields
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    newPasswordInput.addEventListener('input', function() {
        if (confirmPasswordInput.value) {
            checkPasswordMatch();
        }
    });
    
    // Form submission validation
    window.validateForm = function() {
        return checkPasswordMatch();
    };
    
    // Handle mobile sidebar toggle
    const menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        });
    }
    
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
    
    // Add focus and blur effects to inputs
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
});
	 </script>
</body>
</html>
<?php } ?>