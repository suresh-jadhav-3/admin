<?php
if(strlen($_SESSION['alogin'])==0) { 
    header('location:index.php');
}
?>
<header class="main-header">
    <div class="header-container">
        <div class="brand">
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="dashboard.php" class="brand-logo">Car Rental Portal | Admin Panel</a>
        </div>
        <div class="user-menu">
            <div class="dropdown">
                <button class="dropdown-toggle" id="accountDropdown" aria-haspopup="true" aria-expanded="false">
                    <span>Account</span>
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12">
                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
                    </svg>
                </button>
                <div class="dropdown-menu" role="menu" aria-labelledby="accountDropdown">
                    <a href="change-password.php" role="menuitem">Change Password</a>
                    <a href="logout.php" role="menuitem">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
.main-header {
    background: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.brand {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.brand-logo {
    color: #1e40af;
    text-decoration: none;
    font-size: 1.25rem;
    font-weight: 600;
    transition: color 0.2s;
}

.brand-logo:hover {
    color: #1e3a8a;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    gap: 4px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.menu-toggle:hover {
    background-color: #f1f5f9;
}

.menu-toggle span {
    display: block;
    width: 24px;
    height: 2px;
    background-color: #1e293b;
    transition: transform 0.3s, opacity 0.3s;
}

.menu-toggle.active span:nth-child(1) {
    transform: translateY(6px) rotate(45deg);
}

.menu-toggle.active span:nth-child(2) {
    opacity: 0;
}

.menu-toggle.active span:nth-child(3) {
    transform: translateY(-6px) rotate(-45deg);
}

.dropdown {
    position: relative;
}

.dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: none;
    border: 1px solid transparent;
    border-radius: 0.375rem;
    cursor: pointer;
    color: #1e293b;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.dropdown-toggle:hover {
    background-color: #f1f5f9;
}

.dropdown-toggle:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.arrow-icon {
    transition: transform 0.2s;
}

.dropdown.active .arrow-icon {
    transform: rotate(180deg);
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 0.5rem);
    background: white;
    border-radius: 0.375rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    min-width: 180px;
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.2s, transform 0.2s;
}

.dropdown-menu.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.dropdown-menu a {
    display: block;
    padding: 0.75rem 1rem;
    color: #1e293b;
    text-decoration: none;
    transition: all 0.2s;
    border-radius: 0.25rem;
    margin: 0.25rem;
}

.dropdown-menu a:hover {
    background-color: #f1f5f9;
    color: #1e40af;
}

@media (max-width: 768px) {
    .menu-toggle {
        display: flex;
    }
    
    .header-container {
        padding: 0.75rem 1rem;
    }
    
    .brand-logo {
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const dropdown = document.querySelector('.dropdown');
    const dropdownToggle = document.getElementById('accountDropdown');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    // Toggle dropdown on click
    dropdownToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('active');
        dropdownMenu.classList.toggle('active');
        dropdownToggle.setAttribute('aria-expanded', 
            dropdownToggle.getAttribute('aria-expanded') === 'false' ? 'true' : 'false'
        );
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
            dropdownMenu.classList.remove('active');
            dropdownToggle.setAttribute('aria-expanded', 'false');
        }
    });

    // Toggle mobile menu
    menuToggle.addEventListener('click', () => {
        menuToggle.classList.toggle('active');
        // Add your mobile menu toggle logic here
    });

    // Handle keyboard navigation
    dropdownMenu.addEventListener('keydown', (e) => {
        const items = dropdownMenu.querySelectorAll('a');
        const currentIndex = Array.from(items).indexOf(document.activeElement);

        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                if (currentIndex < items.length - 1) {
                    items[currentIndex + 1].focus();
                }
                break;
            case 'ArrowUp':
                e.preventDefault();
                if (currentIndex > 0) {
                    items[currentIndex - 1].focus();
                }
                break;
            case 'Escape':
                dropdown.classList.remove('active');
                dropdownMenu.classList.remove('active');
                dropdownToggle.setAttribute('aria-expanded', 'false');
                dropdownToggle.focus();
                break;
        }
    });
});
</script>