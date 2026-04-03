<style>
    .sidebar {
        width: var(--sidebar-width); background: var(--white);
        border-right: 1px solid rgba(0,0,0,0.05); padding-top: 80px;
        position: sticky; top: 0; height: 100vh;
    }
    .menu-link {
        display: flex; align-items: center; padding: 14px 25px;
        text-decoration: none; color: #777; transition: 0.3s; font-weight: 400;
    }
    .menu-link i { margin-right: 15px; width: 20px; text-align: center; font-size: 1.1rem; }
    .menu-link:hover { background: var(--c3); color: var(--c5); }
    .menu-link.active {
        background: var(--c2); color: var(--c5); font-weight: 600;
        border-right: 5px solid var(--c5);
    }
    .logout-link { margin-top: 40px; color: var(--danger) !important; }
    .logout-link:hover { background: #fff5f5; }
</style>

<nav class="sidebar">
    <a href="dashboard.php" class="menu-link <?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">
        <i class="fas fa-th-large"></i> แดชบอร์ด
    </a>
    <a href="room.php" class="menu-link <?php echo ($activePage == 'room') ? 'active' : ''; ?>">
        <i class="fas fa-door-open"></i> ผังห้องพัก
    </a>
    <a href="parcel.php" class="menu-link <?php echo ($activePage == 'parcel') ? 'active' : ''; ?>">
        <i class="fas fa-box"></i> รายการพัสดุ
    </a>
    <a href="repair.php" class="menu-link <?php echo ($activePage == 'repair') ? 'active' : ''; ?>">
        <i class="fas fa-tools"></i> แจ้งซ่อม/แจ้งปัญหา
    </a>
    <a href="logout.php" class="menu-link logout-link">
        <i class="fas fa-power-off"></i> ออกจากระบบ
    </a>
</nav>