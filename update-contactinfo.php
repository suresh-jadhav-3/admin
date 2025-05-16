<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {
    if(isset($_POST['submit'])) {
        $address = $_POST['address'];
        $email = $_POST['email'];	
        $contactno = $_POST['contactno'];
        $sql = "update tblcontactusinfo set Address=:address,EmailId=:email,ContactNo=:contactno";
        $query = $dbh->prepare($sql);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
        $query->execute();
        $msg = "Info Updated successfully";
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    
    <title>Car Rental Portal | Update Contact Info</title>

    <!-- <link rel="stylesheet" href="css/admin.css"> -->
	 <style>
		/* Main Layout Styles */
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f7fb;
    color: #1e293b;
    line-height: 1.5;
}

.main-container {
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
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    overflow: hidden;
}

.card-header {
    padding: 1rem 1.5rem;
    background-color: white;
    border-bottom: 1px solid #e2e8f0;
    font-weight: 600;
    color: #1e293b;
}

.card-body {
    padding: 1.5rem;
}

/* Form Styles */
.form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

label {
    font-weight: 500;
    color: #475569;
    font-size: 0.875rem;
}

.form-control {
    padding: 0.75rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.375rem;
    font-size: 1rem;
    color: #1e293b;
    transition: all 0.2s;
    width: 100%;
    box-sizing: border-box;
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

.button-group {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background-color: #1e40af;
    color: white;
}

.btn-primary:hover {
    background-color: #1e3a8a;
}

/* Alert Styles */
.alert {
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.alert.success {
    background-color: #ecfdf5;
    border-left: 4px solid #10b981;
    color: #065f46;
}

.alert.error {
    background-color: #fef2f2;
    border-left: 4px solid #ef4444;
    color: #991b1b;
}

/* Editor Styles */
.editor-container {
    border: 1px solid #cbd5e1;
    border-radius: 0.375rem;
    overflow: hidden;
}

.editor-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    padding: 0.5rem;
    background-color: #f8fafc;
    border-bottom: 1px solid #cbd5e1;
}

.toolbar-btn {
    padding: 0.5rem;
    background: none;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    color: #475569;
    font-size: 1rem;
    transition: all 0.2s;
    min-width: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toolbar-btn:hover {
    background-color: #e2e8f0;
}

.toolbar-btn.active {
    background-color: #e2e8f0;
    color: #1e40af;
}

.toolbar-divider {
    width: 1px;
    height: 1.5rem;
    background-color: #cbd5e1;
    margin: 0 0.25rem;
}

.editor-content {
    min-height: 300px;
    padding: 1rem;
    overflow-y: auto;
}

.editor-content:focus {
    outline: none;
}

/* Responsive Styles */
@media (max-width: 1024px) {
    .content-wrapper {
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .content-wrapper {
        padding: 1rem;
    }

    .editor-toolbar {
        justify-content: center;
    }

    .button-group {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}

@media (max-width: 640px) {
    .page-title {
        font-size: 1.5rem;
    }

    .card-header, .card-body {
        padding: 1rem;
    }
}

/* Animation for Alerts */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert {
    animation: fadeIn 0.3s ease-out forwards;
}
	 </style>
</head>

<body>
    <?php include('includes/header.php');?>
    <div class="main-container">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container">
                <h2 class="page-title">Update Contact Info</h2>

                <div class="card">
                    <div class="card-header">Contact Information</div>
                    <div class="card-body">
                        <form method="post" name="contactForm" class="form">
                            <?php if($error) { ?>
                                <div class="alert error">
                                    <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                </div>
                            <?php } else if($msg) { ?>
                                <div class="alert success">
                                    <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                </div>
                            <?php } ?>

                            <?php 
                            $sql = "SELECT * from tblcontactusinfo";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if($query->rowCount() > 0) {
                                foreach($results as $result) {
                            ?>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea 
                                    class="form-control" 
                                    name="address" 
                                    id="address" 
                                    required
                                ><?php echo htmlentities($result->Address);?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    name="email" 
                                    id="email" 
                                    value="<?php echo htmlentities($result->EmailId);?>" 
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="contactno">Contact Number</label>
                                <input 
                                    type="tel" 
                                    class="form-control" 
                                    name="contactno" 
                                    id="contactno" 
                                    value="<?php echo htmlentities($result->ContactNo);?>" 
                                    required
                                >
                            </div>
                            <?php }} ?>

                            <div class="form-group button-group">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    Update Contact Info
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="js/admin.js"></script> -->
	 <script>
		document.addEventListener('DOMContentLoaded', function() {
    // Initialize editor toolbar functionality if on manage-pages
    if (document.querySelector('.editor-toolbar')) {
        initEditor();
    }
    
    // Set up form validation
    setupFormValidation();
    
    // Set up alert animations and auto-dismiss
    setupAlerts();
});

/**
 * Initialize the rich text editor functionality
 */
function initEditor() {
    const toolbar = document.querySelector('.editor-toolbar');
    const editor = document.getElementById('editor');
    
    if (!toolbar || !editor) return;
    
    // Add click event listeners to toolbar buttons
    const buttons = toolbar.querySelectorAll('.toolbar-btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const command = this.dataset.command;
            
            if (command === 'createLink') {
                const url = prompt('Enter the link URL:');
                if (url) {
                    document.execCommand(command, false, url);
                }
            } else {
                document.execCommand(command, false, null);
            }
            
            // Toggle active state for formatting commands
            if (['bold', 'italic', 'underline'].includes(command)) {
                this.classList.toggle('active');
            }
            
            // Focus back on editor
            editor.focus();
        });
    });
    
    // Make editor resizable
    makeEditorResizable(editor);
}

/**
 * Make the editor resizable
 */
function makeEditorResizable(editor) {
    let startY, startHeight;
    
    const resizer = document.createElement('div');
    resizer.className = 'editor-resizer';
    resizer.style.height = '10px';
    resizer.style.cursor = 'ns-resize';
    resizer.style.backgroundColor = '#f1f5f9';
    resizer.style.borderTop = '1px solid #cbd5e1';
    
    editor.parentNode.insertBefore(resizer, editor.nextSibling);
    
    resizer.addEventListener('mousedown', initResize, false);
    
    function initResize(e) {
        startY = e.clientY;
        startHeight = parseInt(document.defaultView.getComputedStyle(editor).height, 10);
        document.documentElement.addEventListener('mousemove', resize, false);
        document.documentElement.addEventListener('mouseup', stopResize, false);
    }
    
    function resize(e) {
        editor.style.height = (startHeight + e.clientY - startY) + 'px';
    }
    
    function stopResize() {
        document.documentElement.removeEventListener('mousemove', resize, false);
        document.documentElement.removeEventListener('mouseup', stopResize, false);
    }
}

/**
 * Set up form validation
 */
function setupFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
            
            // For manage-pages form, transfer content from editor to textarea
            if (form.id === 'pageForm') {
                const editorContent = document.getElementById('editor');
                const textArea = document.getElementById('pgedetails');
                
                if (editorContent && textArea) {
                    textArea.value = editorContent.innerHTML;
                }
            }
        });
    });
}

/**
 * Set up alerts with animations and auto-dismiss
 */
function setupAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Add close button
        const closeBtn = document.createElement('span');
        closeBtn.innerHTML = '×';
        closeBtn.className = 'alert-close';
        closeBtn.style.position = 'absolute';
        closeBtn.style.right = '1rem';
        closeBtn.style.top = '50%';
        closeBtn.style.transform = 'translateY(-50%)';
        closeBtn.style.cursor = 'pointer';
        closeBtn.style.fontSize = '1.25rem';
        
        closeBtn.addEventListener('click', () => dismissAlert(alert));
        alert.appendChild(closeBtn);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => dismissAlert(alert), 5000);
    });
}

/**
 * Dismiss an alert with animation
 */
function dismissAlert(alert) {
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';
    alert.style.transition = 'opacity 0.3s, transform 0.3s';
    
    setTimeout(() => {
        alert.remove();
    }, 300);
}

/**
 * Navigate to the selected page type
 */
function navigateToPage(select) {
    if (select.value) {
        window.location.href = select.value;
    }
}
	 </script>
</body>
</html>
<?php } ?>