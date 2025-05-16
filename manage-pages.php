<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {
    if($_POST['submit']=="Update") {
        $pagetype=$_GET['type'];
        $pagedetails=$_POST['pgedetails'];
        $sql = "UPDATE tblpages SET detail=:pagedetails WHERE type=:pagetype";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pagetype',$pagetype, PDO::PARAM_STR);
        $query->bindParam(':pagedetails',$pagedetails, PDO::PARAM_STR);
        $query->execute();
        $msg="Page data updated successfully";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Car Rental Portal Admin - Manage Pages">
    <meta name="author" content="">
    <title>Car Rental Portal | Admin Manage Pages</title>
    <!-- <link rel="stylesheet" href="css/page-manager.css"> -->
	 <style>
		/* Page Manager CSS - Car Rental Portal Admin Panel */

/* Base & Reset */
:root {
    --color-primary: #1e40af;
    --color-primary-light: #3b82f6;
    --color-primary-dark: #1e3a8a;
    --color-success: #10b981;
    --color-warning: #f59e0b;
    --color-error: #ef4444;
    --color-gray-50: #f8fafc;
    --color-gray-100: #f1f5f9;
    --color-gray-200: #e2e8f0;
    --color-gray-300: #cbd5e1;
    --color-gray-400: #94a3b8;
    --color-gray-500: #64748b;
    --color-gray-600: #475569;
    --color-gray-700: #334155;
    --color-gray-800: #1e293b;
    --color-gray-900: #0f172a;
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    
    --border-radius-sm: 0.25rem;
    --border-radius-md: 0.375rem;
    --border-radius-lg: 0.5rem;
    
    --spacing-1: 0.25rem;
    --spacing-2: 0.5rem;
    --spacing-3: 0.75rem;
    --spacing-4: 1rem;
    --spacing-6: 1.5rem;
    --spacing-8: 2rem;
    --spacing-12: 3rem;
    
    --transition-fast: 150ms;
    --transition-normal: 250ms;
}

/* Main Layout */
.main-content {
    display: flex;
    min-height: calc(100vh - 64px); /* Adjust based on header height */
}

.content-wrapper {
    flex: 1;
    padding: var(--spacing-6);
    background-color: var(--color-gray-50);
    overflow-y: auto;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Page Header */
.page-header {
    margin-bottom: var(--spacing-6);
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin: 0;
}

/* Card Components */
.card {
    background-color: white;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-md);
    margin-bottom: var(--spacing-6);
    overflow: hidden;
}

.card-header {
    padding: var(--spacing-4) var(--spacing-6);
    background-color: white;
    border-bottom: 1px solid var(--color-gray-200);
    font-weight: 600;
    font-size: 1rem;
    color: var(--color-gray-700);
}

.card-body {
    padding: var(--spacing-6);
}

/* Form Elements */
.form {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-6);
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-2);
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--color-gray-700);
}

.form-control-wrapper {
    position: relative;
}

.form-select, .form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--color-gray-300);
    border-radius: var(--border-radius-md);
    font-size: 0.875rem;
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
    color: var(--color-gray-800);
    background-color: white;
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd' /%3E%3C/svg%3E");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.25rem;
    padding-right: 2.5rem;
}

.form-select:focus, .form-control:focus, .editor:focus {
    outline: none;
    border-color: var(--color-primary-light);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
}

.form-text {
    font-size: 0.875rem;
    color: var(--color-gray-600);
}

.selected-page {
    padding: 0.5rem 0;
    font-weight: 500;
    color: var(--color-primary);
}

.divider {
    height: 1px;
    background-color: var(--color-gray-200);
    margin: var(--spacing-2) 0;
}

/* Editor */
#editor-container {
    border: 1px solid var(--color-gray-300);
    border-radius: var(--border-radius-md);
    overflow: hidden;
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

#editor-container:focus-within {
    border-color: var(--color-primary-light);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
}

.editor {
    width: 100%;
    min-height: 300px;
    padding: var(--spacing-4);
    border: none;
    resize: vertical;
    font-family: inherit;
    line-height: 1.5;
}

/* Editor Toolbar */
.editor-toolbar {
    background-color: var(--color-gray-50);
    border-bottom: 1px solid var(--color-gray-200);
    padding: var(--spacing-2);
}

.toolbar-buttons {
    display: flex;
    gap: var(--spacing-1);
    flex-wrap: wrap;
    align-items: center;
}

.editor-toolbar button {
    background: white;
    border: 1px solid var(--color-gray-200);
    border-radius: var(--border-radius-sm);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition-fast);
    font-size: 14px;
}

.editor-toolbar button:hover {
    background-color: var(--color-gray-100);
    border-color: var(--color-gray-300);
}

.editor-toolbar button.active {
    background-color: var(--color-primary-light);
    border-color: var(--color-primary);
    color: white;
}

.font-size-select {
    padding: 0.375rem 0.75rem;
    border: 1px solid var(--color-gray-200);
    border-radius: var(--border-radius-sm);
    font-size: 14px;
    background-color: white;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.font-size-select:hover {
    border-color: var(--color-gray-300);
}

.font-size-select:focus {
    outline: none;
    border-color: var(--color-primary-light);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--border-radius-md);
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.btn-primary {
    background-color: var(--color-primary);
    color: white;
}

.btn-primary:hover {
    background-color: var(--color-primary-dark);
}

.btn-primary:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.4);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
}

/* Alerts */
.alert {
    padding: var(--spacing-4);
    border-radius: var(--border-radius-md);
    margin-bottom: var(--spacing-4);
    animation: fadeIn 0.3s ease-in-out;
}

.alert-success {
    background-color: rgba(16, 185, 129, 0.1);
    border: 1px solid var(--color-success);
    color: var(--color-success);
}

.alert-error {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid var(--color-error);
    color: var(--color-error);
}

strong {
    font-weight: 600;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .content-wrapper {
        padding: var(--spacing-4);
    }
    
    .card-body {
        padding: var(--spacing-4);
    }
    
    .form-group {
        flex-direction: column;
    }
    
    .form-label {
        width: 100%;
        margin-bottom: var(--spacing-2);
    }
    
    .editor {
        min-height: 200px;
    }
    
    .toolbar-buttons {
        gap: var(--spacing-2);
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
                <div class="page-header">
                    <h1 class="page-title">Manage Pages</h1>
                </div>

                <div class="card">
                    <div class="card-header">Page Content Editor</div>
                    <div class="card-body">
                        <form method="post" name="pageForm" class="form" id="pageForm">
                            <?php if($error) { ?>
                                <div class="alert alert-error">
                                    <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                </div>
                            <?php } else if($msg) { ?>
                                <div class="alert alert-success">
                                    <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label for="pageSelector" class="form-label">Select Page</label>
                                <div class="form-control-wrapper">
                                    <select name="pageSelector" id="pageSelector" class="form-select">
                                        <option value="" selected>***Select One***</option>
                                        <option value="terms">Terms and Conditions</option>
                                        <option value="privacy">Privacy and Policy</option>
                                        <option value="aboutus">About Us</option>
                                        <option value="faqs">FAQs</option>
                                    </select>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="form-group">
                                <label class="form-label">Selected Page</label>
                                <div class="form-text selected-page">
                                    <?php
                                    switch($_GET['type']) {
                                        case "terms":
                                            echo "Terms and Conditions";
                                            break;
                                        case "privacy":
                                            echo "Privacy And Policy";
                                            break;
                                        case "aboutus":
                                            echo "About Us";
                                            break;
                                        case "faqs":
                                            echo "FAQs";
                                            break;
                                        default:
                                            echo "No page selected";
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pgedetails" class="form-label">Page Details</label>
                                <div class="form-control-wrapper">
                                    <div id="editor-container">
                                        <textarea class="form-control editor" id="pgedetails" name="pgedetails" rows="10" required><?php 
                                            $pagetype = $_GET['type'];
                                            $sql = "SELECT detail from tblpages where type=:pagetype";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':pagetype',$pagetype,PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if($query->rowCount() > 0) {
                                                foreach($results as $result) {		
                                                    echo htmlentities($result->detail);
                                                }
                                            }
                                        ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group form-actions">
                                <button type="submit" name="submit" value="Update" id="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="js/page-manager.js"></script> -->
	 <script>
			const menuToggle = document.querySelector('.menu-toggle');
				const sidebar = document.querySelector('.sidebar');

				if (menuToggle && sidebar) {
					menuToggle.addEventListener('click', function() {
						sidebar.classList.toggle('active');
					});

					// Close sidebar when clicking outside on mobile
					document.addEventListener('click', function(event) {
						const isClickInside = sidebar.contains(event.target) ||
							menuToggle.contains(event.target);

						if (!isClickInside && sidebar.classList.contains('active') &&
							window.innerWidth <= 768) {
							sidebar.classList.remove('active');
						}
					});
				}
		// Page Manager JavaScript - Car Rental Portal Admin Panel

document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initPageSelector();
    initTextEditor();

    // Form validation
    const pageForm = document.getElementById('pageForm');
    if (pageForm) {
        pageForm.addEventListener('submit', validateForm);
    }
    
    // Handle notifications with auto-dismiss
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            });
        }, 5000);
    }
});

/**
 * Initialize page selector functionality
 */
function initPageSelector() {
    const pageSelector = document.getElementById('pageSelector');
    if (!pageSelector) return;
    
    // Set the current value based on URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentType = urlParams.get('type');
    
    if (currentType) {
        pageSelector.value = currentType;
    }
    
    // Add change event listener
    pageSelector.addEventListener('change', function() {
        if (this.value) {
            window.location.href = `manage-pages.php?type=${this.value}`;
        }
    });
}

/**
 * Initialize rich text editor
 */
function initTextEditor() {
    const editorArea = document.getElementById('pgedetails');
    if (!editorArea) return;
    
    // Create a basic toolbar
    const editorContainer = document.getElementById('editor-container');
    const toolbar = document.createElement('div');
    toolbar.className = 'editor-toolbar';
    toolbar.innerHTML = `
        <div class="toolbar-buttons">
            <select class="font-size-select" title="Font Size">
                <option value="1">Small</option>
                <option value="3" selected>Normal</option>
                <option value="5">Large</option>
                <option value="7">Extra Large</option>
            </select>
            <span class="divider"></span>
            <button type="button" data-command="bold" title="Bold"><b>B</b></button>
            <button type="button" data-command="italic" title="Italic"><i>I</i></button>
            <button type="button" data-command="underline" title="Underline"><u>U</u></button>
            <button type="button" data-command="strikeThrough" title="Strike through"><s>S</s></button>
            <span class="divider"></span>
            <button type="button" data-command="justifyLeft" title="Align left">←</button>
            <button type="button" data-command="justifyCenter" title="Align center">↔</button>
            <button type="button" data-command="justifyRight" title="Align right">→</button>
            <span class="divider"></span>
            <button type="button" data-command="insertUnorderedList" title="Bullet list">•</button>
            <button type="button" data-command="insertOrderedList" title="Numbered list">1.</button>
            <span class="divider"></span>
            <button type="button" data-command="createLink" title="Insert link">🔗</button>
            <button type="button" data-command="unlink" title="Remove link">🔓</button>
        </div>
    `;
    
    // Add the toolbar before the textarea
    editorContainer.insertBefore(toolbar, editorArea);
    
    // Create a hidden iframe for editing
    const iframe = document.createElement('iframe');
    iframe.style.width = '100%';
    iframe.style.height = editorArea.offsetHeight + 'px';
    iframe.style.border = 'none';
    iframe.style.display = 'block';
    editorContainer.appendChild(iframe);
    
    // Set up the iframe document
    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    iframeDoc.designMode = 'on';
    iframeDoc.open();
    iframeDoc.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                    font-size: 14px;
                    line-height: 1.5;
                    color: #1e293b;
                    padding: 16px;
                    margin: 0;
                }
                
                p {
                    margin-top: 0;
                    margin-bottom: 16px;
                }
                
                a {
                    color: #3b82f6;
                }
            </style>
        </head>
        <body>${editorArea.value}</body>
        </html>
    `);
    iframeDoc.close();
    
    // Hide the original textarea
    editorArea.style.display = 'none';
    
    // Add event listeners to toolbar buttons
    const buttons = toolbar.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const command = this.getAttribute('data-command');
            
            if (command === 'createLink') {
                const url = prompt('Enter the URL:');
                if (url) {
                    iframe.contentWindow.document.execCommand(command, false, url);
                }
            } else {
                iframe.contentWindow.document.execCommand(command, false, null);
            }
            
            // Update the hidden textarea with the content
            updateTextarea();
            
            // Focus back on the editor
            iframe.contentWindow.focus();
        });
    });

    // Add font size selector functionality
    const fontSizeSelect = toolbar.querySelector('.font-size-select');
    fontSizeSelect.addEventListener('change', function() {
        iframe.contentWindow.document.execCommand('fontSize', false, this.value);
        iframe.contentWindow.focus();
        updateTextarea();
    });
    
    // Update textarea when the form is submitted
    function updateTextarea() {
        editorArea.value = iframe.contentDocument.body.innerHTML;
    }
    
    // Make sure the textarea is updated before form submission
    const form = editorArea.closest('form');
    if (form) {
        form.addEventListener('submit', updateTextarea);
    }
    
    // Make iframe resizable
    iframe.style.resize = 'vertical';
}

/**
 * Form validation
 */
function validateForm(e) {
    const pageSelector = document.getElementById('pageSelector');
    const pageDetails = document.getElementById('pgedetails');
    let isValid = true;
    
    // Check if a page type is selected (for new submissions)
    if (pageSelector && pageSelector.value === '' && !window.location.search.includes('type=')) {
        alert('Please select a page to edit.');
        e.preventDefault();
        isValid = false;
    }
    
    // Check if page details are provided
    if (pageDetails && pageDetails.value.trim() === '') {
        alert('Page content cannot be empty.');
        e.preventDefault();
        isValid = false;
    }
    
    return isValid;
}
	 </script>
</body>
</html>
<?php } ?>