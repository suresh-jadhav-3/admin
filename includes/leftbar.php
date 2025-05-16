<aside class="sidebar">
    <nav class="sidebar-nav">
        <div class="nav-section">
            <h3 class="nav-label">Main</h3>
            <a href="dashboard.php" class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/dashboard.php')?'active':''; ?>">
                <span class="nav-icon">📊</span>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <a href="#" class="nav-item has-submenu">
                <span class="nav-icon">🏢</span>
                Brands
                <span class="submenu-arrow">▼</span>
            </a>
            <div class="submenu">
                <a href="create-brand.php" class="nav-subitem">Create Brand</a>
                <a href="manage-brands.php" class="nav-subitem">Manage Brands</a>
            </div>
        </div>

        <div class="nav-section">
            <a href="#" class="nav-item has-submenu">
                <span class="nav-icon">🚗</span>
                Vehicles
                <span class="submenu-arrow">▼</span>
            </a>
            <div class="submenu">
                <a href="post-avehical.php" class="nav-subitem">Post a Vehicle</a>
                <a href="manage-vehicles.php" class="nav-subitem">Manage Vehicles</a>
            </div>
        </div>

        <div class="nav-section">
            <a href="#" class="nav-item has-submenu">
                <span class="nav-icon">📅</span>
                Bookings
                <span class="submenu-arrow">▼</span>
            </a>
            <div class="submenu">
                <a href="new-bookings.php" class="nav-subitem">New</a>
                <a href="confirmed-bookings.php" class="nav-subitem">Confirmed</a>
                <a href="canceled-bookings.php" class="nav-subitem">Canceled</a>
            </div>
        </div>

        <div class="nav-section">
            <a href="testimonials.php" class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/testimonials.php')?'active':''; ?>">
                <span class="nav-icon">⭐</span>
                Manage Testimonials
            </a>
            <a href="manage-conactusquery.php" class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/manage-conactusquery.php')?'active':''; ?>">
                <span class="nav-icon">📞</span>
                Manage Contact Query
            </a>
            <a href="reg-users.php" class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/reg-users.php')?'active':''; ?>">
                <span class="nav-icon">👥</span>
                Reg Users
            </a>
            <a href="manage-pages.php" class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/manage-pages.php')?'active':''; ?>">
                <span class="nav-icon">📄</span>
                Manage Pages
            </a>
            <a href="update-contactinfo.php" class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/update-contactinfo.php')?'active':''; ?>">
                <span class="nav-icon">📝</span>
                Update Contact Info
            </a>
            <a href="manage-subscribers.php" class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/manage-subscribers.php')?'active':''; ?>">
                <span class="nav-icon">📧</span>
                Manage Subscribers
            </a>
        </div>
    </nav>
</aside>

<style>
.sidebar {
    width: 280px;
    background: white;
    border-right: 1px solid #e2e8f0;
    height: calc(100vh - 64px);
    position: sticky;
    top: 64px;
    overflow-y: auto;
}

.sidebar-nav {
    padding: 1.5rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.nav-section {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.nav-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #64748b;
    padding: 0 1rem;
    margin-bottom: 0.5rem;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #475569;
    text-decoration: none;
    border-radius: 0.375rem;
    transition: all 0.2s;
    cursor: pointer;
}

.nav-icon {
    font-size: 1.25rem;
}

.nav-item:hover {
    background-color: #f1f5f9;
    color: #1e40af;
}

.nav-item.active {
    background-color: #1e40af;
    color: white;
}

.has-submenu {
    display: flex;
    justify-content: space-between;
}

.submenu-arrow {
    font-size: 0.75rem;
    transition: transform 0.2s;
}

.has-submenu.active .submenu-arrow {
    transform: rotate(180deg);
}

.submenu {
    display: none;
    padding-left: 2.5rem;
}

.has-submenu.active + .submenu {
    display: flex;
    flex-direction: column;
}

.nav-subitem {
    padding: 0.5rem 1rem;
    color: #64748b;
    text-decoration: none;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.nav-subitem:hover {
    background-color: #f1f5f9;
    color: #1e40af;
}

@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        left: -280px;
        transition: left 0.3s ease;
        z-index: 99;
    }
    
    .sidebar.active {
        left: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const submenuItems = document.querySelectorAll('.has-submenu');
    
    submenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
        });
    });
});
</script>