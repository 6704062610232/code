<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Home - Admin System</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* ============================================================
           ส่วนที่ 1: CSS ของระบบ Admin (โครงสร้างหลัก) 
           ============================================================ */
        :root {
            --c1-adm: #CCD5AE;
            --c2-adm: #E9EDC9;
            --c3-adm: #FEFAE0;
            --c4-adm: #FAEDCD;
            --c5-adm: #D4A373;
            --white-adm: #ffffff;
            --text-adm: #444;
            --danger-adm: #e74c3c;
            --bg-light-adm: #f6f5f2;
            --nav-height: 65px;
        }

        /* บังคับใช้ฟอนต์ Sarabun */
        * {
            font-family: 'Sarabun', sans-serif;
        }

        body {
            background-color: var(--bg-light-adm);
            margin: 0;
            padding: 0;
            color: var(--text-adm);
            overflow-x: hidden;
        }

        .top-navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            height: var(--nav-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #eee;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .menu-toggle {
            font-size: 20px;
            color: var(--c5-adm);
            cursor: pointer;
            padding: 5px;
        }

        .brand-logo {
            font-weight: 600;
            color: #5d4037;
            font-size: 16px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-left: 2px solid #eee;
            padding-left: 15px;
        }

        .nav-center {
            flex: 2;
            text-align: center;
        }

        .page-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-adm);
        }

        .nav-right {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            position: relative;
        }

        .nav-user-small {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--c4-adm);
            cursor: pointer;
        }

        .user-dropdown {
            position: absolute;
            right: 0;
            top: 45px;
            background: white;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            display: none;
            z-index: 6000;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 160px;
            overflow: hidden;
        }

        .nav-right:hover .user-dropdown {
            display: block;
        }

        .user-dropdown button {
            display: block;
            width: 100%;
            padding: 12px 15px;
            border: none;
            background: none;
            text-align: left;
            font-size: 14px;
            cursor: pointer;
            color: #555;
        }

        .user-dropdown button:hover {
            background: #fffaf4;
            color: var(--c5-adm);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: white;
            z-index: 2001;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 15px 0 40px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            z-index: 2000;
            display: none;
            backdrop-filter: blur(2px);
        }

        .sidebar-header {
            padding: 40px 20px;
            text-align: center;
            background: linear-gradient(135deg, #faf1e6 0%, #ffffff 100%);
            border-bottom: 1px solid #f8f8f8;
        }

        .sidebar-user-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            object-fit: cover;
        }

        .sidebar-menu {
            list-style: none;
            padding: 15px;
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            text-decoration: none;
            color: #555;
            border-radius: 10px;
            transition: 0.3s;
            font-weight: 500;
            font-size: 14.5px;
        }

        .sidebar-menu a.active {
            background: #fff9f2;
            color: var(--c5-adm);
            font-weight: 600;
        }

        .sidebar-menu a:hover:not(.active) {
            background: #fdfdfd;
            transform: translateX(5px);
            color: var(--c5-adm);
        }

        /* Admin Popup Modals (จากชุดที่ 2) */
        .adm-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 7000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(4px);
        }

        .adm-modal-card {
            background: white;
            width: 90%;
            max-width: 400px;
            border-radius: 25px;
            padding: 30px;
            box-sizing: border-box;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .adm-modal-input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .adm-modal-input-group label {
            font-size: 12px;
            color: #999;
            margin-bottom: 5px;
            display: block;
            text-transform: uppercase;
        }

        .adm-modal-input-group input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #eee;
            background: #fafafa;
            font-family: 'Sarabun';
            outline: none;
            box-sizing: border-box;
            font-size: 14px;
            color: #555;
        }

        .adm-btn-row {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .adm-btn-confirm {
            flex: 2;
            background: var(--danger-adm);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Sarabun';
        }

        .adm-btn-cancel {
            flex: 1;
            background: #f1f1f1;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            color: #777;
            font-family: 'Sarabun';
        }

        /* ============================================================
           ส่วนที่ 2: CSS ของหน้าผังห้อง (ยกมาวางห้ามแก้แม้แต่บรรทัดเดียว)
           ============================================================ */
        :root {
            --bg-main: #F5F5F3;
            --primary: #E3B38A;
            --primary-hover: #D4A373;
            --text-dark: #6D4C41;
            --text-muted: #8E8E8E;
            --white: #FFFFFF;
            --danger: #E53E3E;
            --success: #A3B18A;
            --accent: #34495E;
        }

        .header-area {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 25px;
        }

        /* ปรับชิดขวาเพราะเอาหัวข้อออก */
        .btn-add-room {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            font-family: 'Sarabun';
        }

        .main-card {
            background: var(--white);
            border-radius: 30px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        }

        .floor-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 40px;
            padding: 10px;
            border: 1px solid #f0f0f0;
        }

        .floor-label {
            min-width: 70px;
            font-weight: bold;
            color: var(--primary);
            text-align: center;
            font-size: 15px;
        }

        .room-container {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            flex: 1;
            padding: 5px;
        }

        .room-card {
            min-width: 90px;
            height: 95px;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px dashed #E0E0E0;
            background: var(--white);
            transition: 0.3s;
        }

        .room-card.has-tenant {
            background-color: var(--primary);
            color: var(--white);
            border: none;
        }

        .room-card.full-room {
            background-color: var(--text-dark);
            color: var(--white);
            border: none;
        }

        .room-card b {
            font-size: 18px;
        }

        .count-tag {
            font-size: 10px;
            margin-top: 4px;
            background: rgba(0, 0, 0, 0.05);
            padding: 2px 8px;
            border-radius: 10px;
        }

        #modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 5000;
            backdrop-filter: blur(5px);
        }

        .modal-card {
            background: var(--white);
            width: 95%;
            max-width: 500px;
            border-radius: 40px;
            padding: 30px;
            position: relative;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .close-modal {
            position: absolute;
            top: 25px;
            right: 25px;
            font-size: 28px;
            cursor: pointer;
            color: #DDD;
            border: none;
            background: none;
        }

        .modal-nav {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .btn-back-nav {
            border: none;
            background: none;
            color: var(--primary);
            cursor: pointer;
            font-size: 17px;
            font-weight: bold;
            font-family: 'Sarabun';
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0;
        }

        .tenant-profile-head {
            text-align: center;
            margin-bottom: 20px;
        }

        .tenant-profile-head img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 5px solid var(--bg-main);
            object-fit: cover;
            margin-bottom: 10px;
        }

        .tenant-profile-head h2 {
            margin: 5px 0;
            font-size: 22px;
            color: #333;
        }

        .badge-room-detail {
            background: var(--primary);
            color: white;
            padding: 4px 15px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
        }

        .section-label {
            font-size: 12px;
            font-weight: bold;
            color: var(--primary);
            border-bottom: 1px solid #EEE;
            padding-bottom: 5px;
            margin: 20px 0 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-card-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-card-box {
            background: #F9F9F9;
            padding: 12px 15px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-card-box i {
            width: 18px;
            color: var(--primary);
            text-align: center;
            font-size: 16px;
        }

        .info-val-label {
            font-size: 11px;
            color: #999;
        }

        .info-val-text {
            font-size: 14px;
            color: #333;
            font-weight: 600;
        }

        .span-2 {
            grid-column: span 2;
        }

        .status-bar-info {
            padding: 15px;
            border-radius: 18px;
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
            font-size: 14px;
        }

        .status-active-info {
            background: #FFF3E0;
            color: #EF6C00;
        }

        .status-success-info {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 5px;
            padding-left: 5px;
        }

        .form-control {
            width: 100%;
            padding: 14px;
            border-radius: 15px;
            border: 1px solid #eee;
            font-family: 'Sarabun';
            font-size: 14px;
            background: #fafafa;
            box-sizing: border-box;
        }

        .form-control[readonly] {
            background: #f0f0f0;
            color: #888;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-save-main {
            width: 100%;
            padding: 18px;
            border-radius: 22px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }

        .warning-item-box {
            background: #FFF;
            border-radius: 20px;
            padding: 18px;
            margin-bottom: 15px;
            border-left: 8px solid var(--danger);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            text-align: left;
        }

        .deposit-sum-card {
            border: 2.5px solid var(--danger);
            border-radius: 30px;
            padding: 25px;
            margin: 25px 0;
            background: #FFF;
            text-align: center;
        }

        .deposit-amt-big {
            font-size: 48px;
            font-weight: bold;
            color: var(--danger);
        }

        #move-banner {
            display: none;
            background: var(--text-dark);
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Move Banner ชุดผังห้อง (ห้ามแก้) -->
    <div id="move-banner">
        <i class="fas fa-exchange-alt"></i> โหมดย้ายห้อง | เลือกห้องปลายทาง (สูงสุด 2 คน)
        <button onclick="cancelMove()"
            style="margin-left:15px; background:var(--primary); color:white; border:none; padding:5px 15px; border-radius:10px; cursor:pointer; font-weight:bold;">ยกเลิก</button>
    </div>

    <!-- Navbar ชุดที่ 2 -->
    <header class="top-navbar">
        <div class="nav-left">
            <div class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <div class="brand-logo">Cozy Home</div>
        </div>
        <div class="nav-center">
            <h2 class="page-title" id="navPageTitle">ผังห้อง/ยูนิต</h2>
        </div>
        <div class="nav-right">
            <img src="https://i.pravatar.cc/150?u=admin" class="nav-user-small">
            <div class="user-dropdown">
                <button onclick="openAdmModal('profileAdm')"><i class="fas fa-user-circle"></i> ข้อมูลส่วนตัว</button>
                <button onclick="openAdmModal('logoutAdm')"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</button>
            </div>
        </div>
    </header>

    <!-- Sidebar ชุดที่ 2 -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <img src="https://i.pravatar.cc/150?u=admin" class="sidebar-user-img">
            <h4 style="margin:12px 0 0 0; color:#5d4037; font-size:16px;">แอดมินนิติ</h4>
            <p style="font-size:12px; color:#aaa; margin-top:4px;">Management System</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" onclick="changePage('กระดานข่าวสาร', this)"><i class="fas fa-bullhorn"></i>
                    กระดานข่าวสาร</a></li>
            <li><a href="#" onclick="changePage('จดมิเตอร์น้ำ-ไฟ', this)"><i class="fas fa-tachometer-alt"></i>
                    จดมิเตอร์น้ำ-ไฟ</a></li>
            <li><a href="#" onclick="changePage('เลือกรอบบิล', this)"><i class="fas fa-calendar-check"></i>
                    เลือกรอบบิล</a></li>
            <li><a href="#" onclick="changePage('รายการพัสดุ', this)"><i class="fas fa-box"></i> รายการพัสดุ</a></li>
            <li><a href="#" onclick="changePage('จัดการแจ้งซ่อม', this)"><i class="fas fa-tools"></i> จัดการแจ้งซ่อม</a>
            </li>
            <li><a href="#" onclick="changePage('สัญญาเช่า/ซื้อขาย', this)"><i class="fas fa-file-contract"></i>
                    สัญญาเช่า/ซื้อขาย</a></li>
            <li><a href="#" onclick="changePage('ผังห้อง/ยูนิต', this)" class="active"><i class="fas fa-th-large"></i>
                    ผังห้อง/ยูนิต</a></li>
            <hr style="border:0; border-top:1px solid #f5f5f5; margin:10px 0;">
            <li><a href="#" onclick="openAdmModal('profileAdm')"><i class="fas fa-user-circle"></i> ข้อมูลส่วนตัว</a>
            </li>
            <li><a href="#" onclick="openAdmModal('logoutAdm')" style="color:var(--danger-adm);"><i
                        class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
        </ul>
    </nav>

    <!-- Main Content Area (เอาหัวข้อออกเหลือแต่ปุ่ม) -->
    <main style="padding: 20px;">
        <div class="container">
            <div class="header-area">
                <button class="btn-add-room" onclick="showAddRoomForm()">
                    <i class="fas fa-plus-circle"></i> เพิ่มห้องพักใหม่
                </button>
            </div>
            <div class="main-card">
                <div id="roomRowsContainer"></div>
            </div>
        </div>
    </main>

    <!-- Modals หน้าผังห้อง (ชุดที่คุณส่งมา - ห้ามแก้) -->
    <div id="modal-overlay" onclick="closeModal()">
        <div class="modal-card" onclick="event.stopPropagation()">
            <button class="close-modal" onclick="closeModal()">&times;</button>
            <div id="modal-content"></div>
        </div>
    </div>

    <!-- Modals Admin (ข้อมูลส่วนตัว / ออกจากระบบ ตามต้นฉบับชุด 2) -->
    <div id="profileAdm" class="adm-modal-overlay">
        <div class="adm-modal-card">
            <h3 style="text-align:center; color:#5d4037; margin-top: 0;">👤 ข้อมูลส่วนตัว</h3>
            <div style="text-align:center; margin-bottom:20px;">
                <img src="https://i.pravatar.cc/150?u=admin"
                    style="width:90px; height:90px; border-radius:50%; border:3px solid white; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
            </div>
            <div class="adm-modal-input-group"><label>ชื่อผู้ใช้งาน</label><input type="text" value="แอดมินนิติ"
                    readonly></div>
            <div class="adm-modal-input-group"><label>ตำแหน่ง</label><input type="text" value="ผู้ดูแลระบบ (Admin)"
                    readonly></div>
            <button class="adm-btn-cancel" style="width:100%;"
                onclick="closeAdmModal('profileAdm')">ปิดหน้าต่าง</button>
        </div>
    </div>

    <div id="logoutAdm" class="adm-modal-overlay">
        <div class="adm-modal-card">
            <i class="fas fa-sign-out-alt" style="font-size: 45px; color: var(--danger-adm); margin-bottom: 15px;"></i>
            <h3 style="margin: 0;">ต้องการออกจากระบบ?</h3>
            <p style="color: #888; margin-top: 8px; font-size: 14px;">คุณแน่ใจหรือไม่ว่าต้องการออกจากเซสชันนี้</p>
            <div class="adm-btn-row">
                <button class="adm-btn-cancel" onclick="closeAdmModal('logoutAdm')">ยกเลิก</button>
                <button class="adm-btn-confirm" onclick="location.reload()">ยืนยัน</button>
            </div>
        </div>
    </div>

    <script>
        /* Logic Admin */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        }
        function changePage(title, element) {
            document.getElementById('navPageTitle').innerText = title;
            const menuLinks = document.querySelectorAll('.sidebar-menu a');
            menuLinks.forEach(link => link.classList.remove('active'));
            element.classList.add('active');
            toggleSidebar();
            if (title !== 'ผังห้อง/ยูนิต') {
                document.querySelector('main').innerHTML = `<div style="background:white; padding:50px; border-radius:30px; text-align:center;"><h2>${title}</h2><p>กำลังพัฒนา...</p></div>`;
            } else { location.reload(); }
        }
        function openAdmModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeAdmModal(id) { document.getElementById(id).style.display = 'none'; }

        /* ============================================================
           Logic หน้าผังห้อง (ยกมาวางห้ามแก้แม้แต่บรรทัดเดียว)
           ============================================================ */
        let mockContracts = [];

        let roomData = [];
        let movingJob = null;
        const TODAY = new Date();

        async function init() {
            // แสดง loading
            document.getElementById('roomRowsContainer').innerHTML = `
            <div style="text-align:center; padding:60px 20px; color:#bbb;">
                <i class="fas fa-spinner fa-spin" style="font-size:36px; color:var(--primary); margin-bottom:15px; display:block;"></i>
                <div style="font-size:15px;">กำลังโหลดข้อมูลห้องพัก...</div>
            </div>`;
            try {
                const res = await fetch('get_room.php');
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();

                // แปลงข้อมูลจาก API ให้ตรงกับ format ที่ระบบใช้
                roomData = data.map(room => ({
                    id: room.id,
                    floor: room.floor,
                    tenants: (room.tenants || []).map(t => ({
                        name: t.name,
                        contractId: t.contractId,
                        phone: t.phone,
                        lineId: t.lineId,
                        deposit: t.deposit,
                        rent: t.rent,
                        contractMonths: t.contractMonths,
                        startDate: t.startDate,
                        img: t.img || `https://i.pravatar.cc/150?u=${t.contractId}`,
                        emergency: t.emergency || '-'
                    }))
                }));
                console.log('ข้อมูลห้องหลังแปลง:', roomData);

                renderGrid();
            } catch (err) {
                console.error('โหลดข้อมูลไม่สำเร็จ:', err);
                document.getElementById('roomRowsContainer').innerHTML = `
                <div style="text-align:center; padding:60px 20px; color:#e74c3c;">
                    <i class="fas fa-exclamation-triangle" style="font-size:36px; margin-bottom:15px; display:block;"></i>
                    <div style="font-size:15px; font-weight:bold;">โหลดข้อมูลไม่สำเร็จ</div>
                    <div style="font-size:13px; color:#aaa; margin-top:8px;">${err.message}</div>
                    <button onclick="init()" style="margin-top:20px; background:var(--primary); color:white; border:none; padding:10px 25px; border-radius:12px; cursor:pointer; font-family:'Sarabun'; font-weight:bold;">
                        <i class="fas fa-redo"></i> ลองใหม่
                    </button>
                </div>`;
            }
        }

        function isContractUsed(cid) {
            return roomData.some(room => room.tenants.some(t => t.contractId === cid));
        }

        function renderGrid() {
            const container = document.getElementById('roomRowsContainer');
            container.innerHTML = '';
            const floors = [...new Set(roomData.map(r => r.floor))].sort((a, b) => a - b);
            floors.forEach(f => {
                const row = document.createElement('div');
                row.className = 'floor-row';
                row.innerHTML = `<div class="floor-label">ชั้น ${f}</div>`;
                const wrap = document.createElement('div');
                wrap.className = 'room-container';
                roomData.filter(r => r.floor === f).sort((a, b) => a.id - b.id).forEach(room => {
                    const count = room.tenants.length;
                    const isFull = count >= 2;
                    const card = document.createElement('div');
                    card.className = `room-card ${count > 0 ? (isFull ? 'full-room' : 'has-tenant') : ''}`;
                    card.innerHTML = `<b>${room.id}</b><div class="count-tag">${isFull ? 'เต็ม 2/2' : (count > 0 ? count + '/2 คน' : 'ว่าง')}</div>`;
                    card.onclick = () => movingJob ? completeMove(room.id) : openRoomModal(room.id);
                    wrap.appendChild(card);
                });
                row.appendChild(wrap);
                container.appendChild(row);
            });
        }

        function openRoomModal(roomId) {
            const room = roomData.find(r => r.id === roomId);
            const isFull = room.tenants.length >= 2;
            let html = `<h2>จัดการห้อง ${room.id}</h2><div style="overflow-y:auto; max-height:55vh; padding-right:5px;">`;
            if (room.tenants.length === 0) { html += `<p style="text-align:center; padding:30px; color:#CCC;">ไม่มีผู้เข้าพักในขณะนี้</p>`; }
            else {
                room.tenants.forEach((t, idx) => {
                    const c = getContractDetails(t.startDate, t.contractMonths);
                    html += `<div style="background:#FBFBFB; border:1px solid #EEE; border-radius:25px; padding:18px; margin-bottom:15px;">
                        <div style="display:flex; align-items:center; gap:15px"><img src="${t.img}" style="width:50px; height:50px; border-radius:50%; object-fit:cover;"><div style="flex:1; text-align:left;"><h4 style="margin:0">${t.name}</h4><small style="color:${c.isFulfilled ? 'var(--success)' : 'var(--primary)'}; font-weight:bold;">${c.isFulfilled ? 'ครบสัญญา' : 'ติดสัญญา (' + c.diffDays + ' วัน)'}</small></div></div>
                        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; margin-top:15px;">
                            <button onclick="showTenantDetail(${roomId}, ${idx})" style="border:none; padding:10px; border-radius:12px; background:#F0F0F0; font-size:12px; cursor:pointer; font-family:'Sarabun'; font-weight:bold;">ข้อมูล</button>
                            <button onclick="startMove(${roomId}, ${idx})" ${!c.isFulfilled ? 'disabled' : ''} style="border:none; padding:10px; border-radius:12px; background:#E9EDC9; font-size:12px; cursor:pointer; font-family:'Sarabun'; font-weight:bold; opacity:${!c.isFulfilled ? 0.4 : 1}">ย้าย</button>
                            <button onclick="deleteTenant(${roomId}, ${idx})" ${!c.isFulfilled ? 'disabled' : ''} style="border:none; padding:10px; border-radius:12px; background:#FFE6E6; color:#C53030; font-size:12px; cursor:pointer; font-family:'Sarabun'; font-weight:bold; opacity:${!c.isFulfilled ? 0.4 : 1}">ออก</button>
                        </div></div>`;
                });
            }
            html += `</div><button class="btn-save-main" ${isFull ? 'disabled' : ''} style="background:${isFull ? '#DDD' : 'var(--primary)'};" onclick="showAddTenantForm(${roomId})">${isFull ? 'ห้องเต็ม' : '+ ลงทะเบียนผู้เช่า'}</button>
        <button style="width:100%; border:none; background:none; color:var(--danger); font-weight:bold; cursor:pointer; margin-top:15px; font-size:13px;" onclick="removeRoomConfirm(${roomId})">ลบห้องพักนี้</button>`;
            document.getElementById('modal-content').innerHTML = html;
            document.getElementById('modal-overlay').style.display = 'flex';
        }

        function showTenantDetail(roomId, idx) {
            const t = roomData.find(r => r.id === roomId).tenants[idx];
            const c = getContractDetails(t.startDate, t.contractMonths);
            let html = `<div class="modal-nav"><button class="btn-back-nav" onclick="openRoomModal(${roomId})"><i class="fas fa-arrow-left"></i> กลับ</button></div>
            <div class="tenant-profile-head"><img src="${t.img}"><h2>${t.name}</h2><div class="badge-room-detail">ห้องพักหมายเลข ${roomId}</div></div>
            <div class="section-label">ข้อมูลการติดต่อ</div>
            <div class="info-card-grid"><div class="info-card-box"><i class="fas fa-phone"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">เบอร์โทร</span><span class="info-val-text">${t.phone}</span></div></div><div class="info-card-box"><i class="fab fa-line"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">LINE ID</span><span class="info-val-text">${t.lineId}</span></div></div><div class="info-card-box span-2"><i class="fas fa-user-shield"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">ผู้ติดต่อฉุกเฉิน</span><span class="info-val-text">${t.emergency}</span></div></div></div>
            <div class="section-label">สัญญาและการเงิน</div>
            <div class="info-card-grid"><div class="info-card-box"><i class="fas fa-receipt"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">เลขสัญญา</span><span class="info-val-text">${t.contractId}</span></div></div><div class="info-card-box"><i class="fas fa-coins"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">เงินประกัน</span><span class="info-val-text">฿${t.deposit.toLocaleString()}</span></div></div><div class="info-card-box"><i class="fas fa-money-bill-wave"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">ค่าเช่า</span><span class="info-val-text">฿${t.rent.toLocaleString()}</span></div></div><div class="info-card-box"><i class="fas fa-clock"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">ระยะเวลา</span><span class="info-val-text">${t.contractMonths} เดือน</span></div></div></div>
            <div class="section-label">ช่วงเวลา</div>
            <div class="info-card-grid"><div class="info-card-box"><i class="fas fa-calendar-day"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">วันเริ่มพัก</span><span class="info-val-text">${new Date(t.startDate).toLocaleDateString('th-TH')}</span></div></div><div class="info-card-box"><i class="fas fa-calendar-check"></i><div style="display:flex; flex-direction:column;"><span class="info-val-label">วันสิ้นสุด</span><span class="info-val-text">${c.endDate.toLocaleDateString('th-TH')}</span></div></div></div>
            <div class="status-bar-info ${c.isFulfilled ? 'status-success-info' : 'status-active-info'}">${c.isFulfilled ? 'ครบกำหนดสัญญาแล้ว' : 'ติดสัญญา (เหลืออีก ' + c.diffDays + ' วัน)'}</div>
            <button class="btn-save-main" style="background:var(--accent);" onclick="alert('แสดงเล่มสัญญา')"><i class="fas fa-file-pdf"></i> ดูเล่มสัญญาเช่าแบบเต็ม</button>`;
            document.getElementById('modal-content').innerHTML = html;
        }

        function showAddTenantForm(roomId) {
            let html = `<div class="modal-nav"><button class="btn-back-nav" onclick="openRoomModal(${roomId})"><i class="fas fa-arrow-left"></i> กลับ</button><h2 style="margin:0; font-size:18px;">ลงทะเบียน ห้อง ${roomId}</h2></div>
            <div class="form-group"><label>เลขสัญญา</label><input type="text" id="t_cid" class="form-control" placeholder="เช่น CT-68001"></div>
            <div class="form-group"><label>ชื่อ-นามสกุล</label><input type="text" id="t_name" class="form-control" placeholder="ชื่อผู้เช่า"></div>
            <div class="form-grid"><div class="form-group"><label>เบอร์โทรศัพท์</label><input type="text" id="t_phone" class="form-control" placeholder="08x-xxx-xxxx"></div><div class="form-group"><label>LINE ID</label><input type="text" id="t_line" class="form-control" placeholder="line_id"></div></div>
            <div class="form-grid"><div class="form-group"><label>เงินประกัน (฿)</label><input type="number" id="t_dep" class="form-control" placeholder="5000"></div><div class="form-group"><label>ค่าเช่า/เดือน (฿)</label><input type="number" id="t_rent" class="form-control" placeholder="4500"></div></div>
            <div class="form-grid"><div class="form-group"><label>ระยะสัญญา (เดือน)</label><input type="number" id="t_mon" class="form-control" placeholder="6"></div><div class="form-group"><label>วันที่เริ่มเข้าพัก</label><input type="date" id="t_start" class="form-control" value="${TODAY.toISOString().split('T')[0]}"></div></div>
            <button onclick="saveTenant(${roomId})" class="btn-save-main">ยืนยันการบันทึกข้อมูล</button>`;
            document.getElementById('modal-content').innerHTML = html;
        }

        function saveTenant(roomId) {
            const name = document.getElementById('t_name').value.trim();
            const cid = document.getElementById('t_cid').value.trim();
            if (!name || !cid) return alert("กรุณากรอกชื่อผู้เช่าและเลขสัญญา");
            roomData.find(r => r.id === roomId).tenants.push({
                contractId: cid,
                name: name,
                phone: document.getElementById('t_phone').value,
                lineId: document.getElementById('t_line').value,
                deposit: parseFloat(document.getElementById('t_dep').value) || 0,
                rent: parseFloat(document.getElementById('t_rent').value) || 0,
                contractMonths: parseInt(document.getElementById('t_mon').value) || 0,
                startDate: document.getElementById('t_start').value,
                img: `https://i.pravatar.cc/150?u=${cid}`,
                emergency: '-'
            });
            renderGrid(); openRoomModal(roomId);
        }
        function removeRoomConfirm(roomId) {
            const room = roomData.find(r => r.id === roomId);
            if (room.tenants.length === 0) { if (confirm(`ยืนยันลบห้องว่าง ${roomId}?`)) { roomData = roomData.filter(r => r.id !== roomId); renderGrid(); closeModal(); } return; }
            let totalDep = 0; let listHtml = ""; let anyActive = false;
            room.tenants.forEach(t => {
                const c = getContractDetails(t.startDate, t.contractMonths); totalDep += t.deposit; if (!c.isFulfilled) anyActive = true;
                listHtml += `<div class="warning-item-box"><div style="font-weight:bold; font-size:18px;">${t.name}</div><div style="color:#666; font-size:14px; margin-top:5px;"><i class="fas fa-clock"></i> สถานะ: <span style="color:${c.isFulfilled ? 'var(--success)' : 'var(--danger)'}; font-weight:bold;">${c.isFulfilled ? 'ครบสัญญาแล้ว' : 'ติดสัญญา (' + c.diffDays + ' วัน)'}</span></div><div style="color:#666; font-size:14px; margin-top:3px;"><i class="fas fa-coins"></i> เงินประกัน: ฿${t.deposit.toLocaleString()}</div></div>`;
            });
            let html = `<div style="text-align:center;"><button class="btn-back-nav" onclick="openRoomModal(${roomId})"><i class="fas fa-arrow-left"></i> กลับ</button><div style="margin-top:20px;"><i class="fas fa-exclamation-triangle" style="font-size:50px; color:var(--danger);"></i></div><h2 style="color:var(--danger); margin:10px 0;">คำเตือนการลบห้อง ${roomId}</h2><div style="max-height:220px; overflow-y:auto; padding:5px;">${listHtml}</div><div class="deposit-sum-card"><div style="font-size:14px; color:#888;">ยอดเงินประกันรวมที่ต้องตรวจสอบ</div><div class="deposit-amt-big">฿${totalDep.toLocaleString()}</div>${anyActive ? `<div style="color:var(--danger); font-size:12px; font-weight:bold; margin-top:8px;">* มีผู้เช่ายังไม่ครบสัญญา การลบห้องอาจมีผลต่อการริบเงินประกัน</div>` : ''}</div><button onclick="doRemove(${roomId})" class="btn-save-main" style="background:var(--danger);"><i class="fas fa-trash-alt"></i> ยืนยันการลบห้องและผู้เช่าทั้งหมด</button></div>`;
            document.getElementById('modal-content').innerHTML = html;
        }
        function doRemove(id) { if (confirm("ลบถาวร?")) { roomData = roomData.filter(r => r.id !== id); renderGrid(); closeModal(); } }
        function showAddRoomForm() {
            let html = `<div style="text-align:left"><h2>เพิ่มห้องพักใหม่</h2><div class="form-grid"><div class="form-group"><label>ชั้น</label><input type="number" id="nr_fl" class="form-control"></div><div class="form-group"><label>เลขต่อท้าย</label><input type="text" id="nr_suffix" class="form-control"></div></div><button onclick="saveRoom()" class="btn-save-main">สร้างห้องพัก</button></div>`;
            document.getElementById('modal-content').innerHTML = html;
            document.getElementById('modal-overlay').style.display = 'flex';
        }
        function saveRoom() {
    const floor = document.getElementById('nr_fl').value;
    const suffix = document.getElementById('nr_suffix').value;

    if (!floor || !suffix) {
        return alert("กรุณากรอกข้อมูล");
    }

    const formData = new FormData();
    formData.append("floor", floor);
    formData.append("room_number", suffix);

    fetch("save_room.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("เพิ่มห้องสำเร็จ");
            location.reload(); // รีโหลดเพื่อดึงข้อมูลใหม่
        } else {
            alert("เกิดข้อผิดพลาด: " + data);
        }
    })
    .catch(err => {
        console.error(err);
        alert("เชื่อมต่อเซิร์ฟเวอร์ไม่ได้");
    });
}
        function getContractDetails(startStr, months) {
            let start = new Date(startStr); let end = new Date(start); end.setMonth(end.getMonth() + months);
            let diffDays = Math.ceil((end - TODAY) / (1000 * 60 * 60 * 24)); return { isFulfilled: diffDays <= 0, diffDays, endDate: end };
        }
        function startMove(roomId, idx) { movingJob = { fromRoom: roomId, idx, data: roomData.find(r => r.id === roomId).tenants[idx] }; closeModal(); document.getElementById('move-banner').style.display = 'block'; }
        function completeMove(targetId) {
            const target = roomData.find(r => r.id === targetId); if (target.tenants.length >= 2) return alert("ห้องเต็ม");
            roomData.find(r => r.id === movingJob.fromRoom).tenants.splice(movingJob.idx, 1);
            target.tenants.push(movingJob.data); cancelMove(); renderGrid(); alert("ย้ายสำเร็จ");
        }
        function cancelMove() { movingJob = null; document.getElementById('move-banner').style.display = 'none'; }
        function deleteTenant(roomId, idx) { if (confirm("แจ้งย้ายออก?")) { roomData.find(r => r.id === roomId).tenants.splice(idx, 1); renderGrid(); openRoomModal(roomId); } }
        function closeModal() { document.getElementById('modal-overlay').style.display = 'none'; }

        init();
    </script>
</body>

</html>