<style>
    .top-navbar {
        position: fixed; top: 0; left: 0; right: 0; height: 60px;
        background: var(--white); display: flex; align-items: center;
        justify-content: space-between; padding: 0 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); z-index: 1001;
    }
    .nav-brand { font-weight: 600; color: var(--c5); font-size: 1.3rem; letter-spacing: 1px; }
    .nav-brand i { margin-right: 8px; }
    .user-info { display: flex; align-items: center; gap: 10px; }
    .user-avatar { width: 35px; height: 35px; border-radius: 50%; background: var(--c2); display: flex; align-items: center; justify-content: center; color: var(--c5); }
</style>

<header class="top-navbar">
    <div class="nav-brand">
        <i class="fas fa-leaf"></i> COZY HOME
    </div>
    <div class="user-info">
        <span>Admin</span>
        <div class="user-avatar"><i class="fas fa-user"></i></div>
    </div>
</header>