<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cozy Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* รวมตัวแปรสีจากทั้งสองดีไซน์ */
        :root {
            /* สีจากแถบเมนู */
            --c1: #CCD5AE; --c2: #E9EDC9; --c3: #FEFAE0; --c4: #FAEDCD; --c5: #D4A373;
            --white: #ffffff; --text: #444; --danger: #e74c3c;
            --nav-height: 65px;
            
            /* สีจากฟอร์มเดิม */
            --bg-overlay: #848484; 
            --card-bg: #FFFFFF;
            --input-bg: #F8F9FA;
            --primary-beige: #DBA87E; 
            --primary-light: #FFF9F3;
            --text-main: #4A4A4A;
            --text-sub: #8E8E8E;
            --border-dash: #EBC89D;
        }

        body { 
            font-family: 'Sarabun', sans-serif; 
            background-color: #f6f5f2; /* ใช้สีพื้นหลังสว่างตามระบบหลังบ้าน */
            margin: 0; padding: 0; color: var(--text); 
            overflow-x: hidden; 
        }

        /* --- Navbar --- */
        .top-navbar { 
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 25px; height: var(--nav-height);
            background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid #eee;
        }
        .nav-left { display: flex; align-items: center; gap: 15px; flex: 1; }
        .menu-toggle { font-size: 20px; color: var(--c5); cursor: pointer; }
        .brand-logo { font-weight: 600; color: #5d4037; font-size: 16px; letter-spacing: 1.5px; text-transform: uppercase; border-left: 2px solid #eee; padding-left: 15px; }
        
        .nav-right { flex: 1; display: flex; justify-content: flex-end; position: relative; }
        .user-nav-item { display: flex; align-items: center; cursor: pointer; padding: 5px; position: relative; }
        .nav-user-small { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--c4); }
        
        .user-dropdown { 
            position: absolute; right: 0; top: 45px; background: white; border: 1px solid #f0f0f0; 
            border-radius: 12px; display: none; z-index: 100; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 160px; overflow: hidden; 
        }
        .user-nav-item:hover .user-dropdown { display: block; }
        .user-dropdown button { display: block; width: 100%; padding: 12px 15px; border: none; background: none; text-align: left; font-size: 14px; cursor: pointer; font-family: 'Sarabun'; transition: 0.2s; color: #555; }
        .user-dropdown button i { margin-right: 10px; width: 15px; color: #888; text-align: center; }
        .user-dropdown button:hover { background: #fffaf4; color: var(--c5); }

        /* --- Sidebar --- */
        .sidebar { position: fixed; top: 0; left: -300px; width: 300px; height: 100%; background: var(--white); z-index: 2001; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 15px 0 40px rgba(0,0,0,0.1); overflow-y: auto; }
        .sidebar.active { left: 0; }
        .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); z-index: 2000; display: none; backdrop-filter: blur(2px); }

        .sidebar-header { padding: 40px 20px; text-align: center; background: linear-gradient(135deg, #faf1e6 0%, #ffffff 100%); border-bottom: 1px solid #f8f8f8; }
        .sidebar-user-img { width: 85px; height: 85px; border-radius: 50%; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.08); object-fit: cover; }
        
        .sidebar-menu { list-style: none; padding: 15px; margin: 0; }
        .sidebar-menu li { margin-bottom: 2px; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 15px; text-decoration: none; color: #555; border-radius: 12px; transition: 0.3s; font-weight: 500; font-size: 14.5px; }
        .sidebar-menu a i { width: 20px; text-align: center; font-size: 16px; color: #999; }
        .sidebar-menu a.active { background: #fff9f2; color: var(--c5); font-weight: 600; }
        .sidebar-menu a.active i { color: var(--c5); }
        .sidebar-menu a:hover:not(.active) { background: #fdfdfd; transform: translateX(5px); color: var(--c5); }
        .sidebar-menu a.danger { color: var(--danger); margin-top: 10px; }
        .sidebar-menu a.danger i { color: var(--danger); }

        /* --- Main Content Area (Form Container) --- */
        .main-container {
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .admin-card {
            background-color: var(--card-bg);
            width: 100%; max-width: 700px;
            padding: 50px; border-radius: 40px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }

        .header { text-align: center; margin-bottom: 40px; }
        .header i { font-size: 30px; color: var(--primary-beige); margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 24px; font-weight: 700; color: var(--text-main); }
        .header p { margin: 5px 0 0; font-size: 14px; color: var(--text-sub); }

        .section-box {
            border: 1px dashed var(--border-dash); 
            border-radius: 25px; padding: 25px;
            margin-bottom: 25px; background-color: var(--primary-light);
        }

        .section-title {
            font-size: 15px; color: var(--primary-beige);
            font-weight: 700; margin-bottom: 15px;
            display: flex; align-items: center; gap: 10px;
        }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .input-group { margin-bottom: 15px; display: flex; flex-direction: column; }
        .full-width { grid-column: span 2; }

        label { font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 6px; margin-left: 5px; }

        input, select {
            width: 100%; padding: 12px 18px; border: 1px solid #eee;
            background-color: var(--card-bg); border-radius: 12px;
            font-family: 'Sarabun', sans-serif; font-size: 15px;
            color: var(--text-main); outline: none; box-sizing: border-box;
            transition: 0.3s;
        }
        input:focus { border: 1px solid var(--primary-beige); background: #fff; }

        .button-group { display: flex; gap: 20px; margin-top: 30px; }
        .btn {
            flex: 1; padding: 16px; border: none; border-radius: 18px;
            font-family: 'Sarabun', sans-serif; font-size: 16px;
            font-weight: 700; cursor: pointer; transition: all 0.3s;
        }
        .btn-cancel { background-color: #F0F0F0; color: #8E8E8E; }
        .btn-submit { background-color: var(--primary-beige); color: #FFFFFF; box-shadow: 0 10px 20px rgba(219, 168, 126, 0.3); }
        .btn:hover { transform: translateY(-2px); opacity: 0.9; }

        /* --- Modals --- */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 3000; justify-content: center; align-items: center; backdrop-filter: blur(4px); }
        .modal-card { background: white; width: 90%; max-width: 450px; border-radius: 25px; padding: 30px; box-sizing: border-box; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
        .modal-input-group { margin-bottom: 15px; }
        .modal-input-group label { font-size: 13px; color: #888; margin-bottom: 5px; display: block; }
        .modal-input-group input { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #eee; background: #fafafa; font-family: 'Sarabun'; outline: none; box-sizing: border-box; font-size: 14.5px; }
        
        .btn-row { display: flex; gap: 12px; margin-top: 20px; }
        .btn-confirm { flex: 2; background: #e1ad7f; color: white; border: none; padding: 14px; border-radius: 12px; cursor: pointer; font-weight: bold; font-family: 'Sarabun'; }
        .btn-cancel-modal { flex: 1; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; }
        .btn-close-profile { width: 100%; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; margin-top: 10px; }

        .no-split { white-space: nowrap; }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .admin-card { padding: 30px 20px; }
            .button-group { flex-direction: column; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <header class="top-navbar">
        <div class="nav-left">
            <div class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <div class="brand-logo">Cozy Home</div>
        </div>
        <div class="nav-right">
            <div class="user-nav-item">
                <img src="https://i.pravatar.cc/150?u=admin" class="nav-user-small">
                <div class="user-dropdown">
                    <button onclick="openProfileModal()"><i class="fas fa-user-circle"></i> ข้อมูลส่วนตัว</button>
                    <button onclick="openModal('logoutConfirmModal')"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <img src="https://i.pravatar.cc/150?u=admin" class="sidebar-user-img">
            <h4 style="margin:15px 0 0 0; color:#5d4037; font-size:17px;">แอดมินนิติ</h4>
            <p style="font-size:12px; color:#aaa; margin-top:5px;">Cozy Home Management</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#"><i class="fas fa-bullhorn"></i> กระดานข่าวสาร</a></li>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> จดมิเตอร์น้ำ-ไฟ</a></li>
            <li><a href="#"><i class="fas fa-calendar-check"></i> เลือกรอบบิล</a></li>
            <li><a href="#"><i class="fas fa-box"></i> รายการพัสดุ</a></li>
            <li><a href="#"><i class="fas fa-tools"></i> จัดการแจ้งซ่อม</a></li>
            <li><a href="#" class="active"><i class="fas fa-file-contract"></i> สัญญาเช่า/ซื้อขาย</a></li>
            <li><a href="#"><i class="fas fa-th-large"></i> ผังห้อง/ยูนิต</a></li>
            <li><a href="#"><i class="fas fa-chart-line"></i> รายงานสรุป</a></li>
            <hr style="border:0; border-top:1px solid #f5f5f5; margin:15px 0;">
            <li><a href="#" onclick="openProfileModal()"><i class="fas fa-user-circle"></i> ข้อมูลส่วนตัว</a></li>
            <li><a href="#" onclick="openModal('logoutConfirmModal')" class="danger"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
        </ul>
    </nav>

    <!-- Main Content: ฟอร์มเดิม -->
    <div class="main-container">
        <div class="admin-card">
            <div class="header">
                <i class="fas fa-file-invoice"></i>
                <h2 class="no-split">ระบบบันทึกสัญญาเช่าดิจิทัล</h2>
                <p>หอพัก Cozy Home | โดย คุณณัฐรินทร์ สุขใส</p>
            </div>

            <form id="mainAdminForm">
                <!-- ส่วนที่ 1: ข้อมูลผู้เช่า -->
                <div class="section-box">
                    <div class="section-title"><i class="fas fa-user"></i> ข้อมูลผู้เช่าหลัก</div>
                    <div class="form-grid">
                        <div class="input-group full-width">
                            <label>ชื่อ-นามสกุล (ผู้เช่า)</label>
                            <input type="text" id="tenantName" placeholder="ระบุชื่อ-นามสกุลเต็ม" required>
                        </div>
                        <div class="input-group full-width">
                            <label>เลขประจำตัวประชาชน / พาสปอร์ต</label>
                            <input type="text" id="tenantID" placeholder="x-xxxx-xxxxx-xx-x" required>
                        </div>
                        <div class="input-group">
                            <label>เลขห้อง</label>
                            <input type="text" id="roomNo" placeholder="ตัวอย่าง A203" required>
                        </div>
                        <div class="input-group">
                            <label>ชั้น</label>
                            <input type="text" id="floor" placeholder="ตัวอย่าง 2" required>
                        </div>
                    </div>
                </div>

                <!-- ส่วนที่ 2: รายละเอียดสัญญาและค่าใช้จ่าย -->
                <div class="section-box">
                    <div class="section-title"><i class="fas fa-coins"></i> ข้อกำหนดทางการเงินและระยะเวลา</div>
                    <div class="form-grid">
                        <div class="input-group">
                            <label>วันเริ่มสัญญา</label>
                            <input type="date" id="startDate" required>
                        </div>
                        <div class="input-group">
                            <label>วันสิ้นสุดสัญญา</label>
                            <input type="date" id="endDate" required>
                        </div>
                        <div class="input-group">
                            <label>ค่าเช่ารายเดือน (บาท)</label>
                            <input type="number" id="rent" placeholder="4500" required>
                        </div>
                        <div class="input-group">
                            <label>เงินประกันความเสียหาย (บาท)</label>
                            <input type="number" id="deposit" placeholder="9000" required>
                        </div>
                        <div class="input-group">
                            <label>ค่าไฟฟ้า (ต่อหน่วย)</label>
                            <input type="number" step="0.01" id="elec" value="7.00" required>
                        </div>
                        <div class="input-group">
                            <label>ค่าน้ำประปา (ต่อหน่วย)</label>
                            <input type="number" step="0.01" id="water" value="18.00" required>
                        </div>
                        <div class="input-group">
                            <label>ชำระเงินทุกวันที่</label>
                            <input type="number" id="payDay" value="5" max="31" required>
                        </div>
                        <div class="input-group">
                            <label>ค่าปรับจ่ายช้า (บาท/วัน)</label>
                            <input type="number" id="fine" value="100" required>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-cancel no-split" onclick="window.location.reload()">ล้างข้อมูล</button>
                    <button type="submit" class="btn btn-submit no-split">บันทึกและส่งข้อมูลสัญญา</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modals -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <h3 style="text-align:center; color:#5d4037; margin-top: 0;">👤 ข้อมูลส่วนตัว</h3>
            <div style="text-align:center; margin-bottom:20px;">
                <img src="https://i.pravatar.cc/150?u=admin" style="width:100px; height:100px; border-radius:50%; border:3px solid white; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
            </div>
            <div class="modal-input-group">
                <label>ชื่อผู้ใช้งาน</label>
                <input type="text" value="แอดมินนิติ" readonly>
            </div>
            <div class="modal-input-group">
                <label>ตำแหน่ง</label>
                <input type="text" value="ผู้ดูแลระบบ (Admin)" readonly>
            </div>
            <button class="btn-close-profile" onclick="closeModal('profileModal')">ปิดหน้าต่าง</button>
        </div>
    </div>

    <div id="logoutConfirmModal" class="modal-overlay">
        <div class="modal-card" style="text-align: center;">
            <i class="fas fa-sign-out-alt" style="font-size: 50px; color: var(--danger); margin-bottom: 20px;"></i>
            <h3 style="margin: 0;">ต้องการออกจากระบบ?</h3>
            <p style="color: #888; margin-top: 10px;">คุณแน่ใจหรือไม่ว่าต้องการออกจากเซสชันนี้</p>
            <div class="btn-row">
                <button class="btn-cancel-modal" onclick="closeModal('logoutConfirmModal')">ยกเลิก</button>
                <button class="btn-confirm" onclick="location.reload()" style="background:var(--danger);">ยืนยันออกจากระบบ</button>
            </div>
        </div>
    </div>

    <script>
        // --- Sidebar & Modal Scripts ---
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        }

        function openModal(id) { 
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').style.display = 'none';
            document.getElementById(id).style.display = 'flex'; 
        }
        
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        function openProfileModal() { openModal('profileModal'); }

        // --- Form Scripts ---
        document.getElementById('startDate').valueAsDate = new Date();

        document.getElementById('mainAdminForm').onsubmit = function(e) {
            e.preventDefault();

            const formatThai = (val) => {
                const d = new Date(val);
                return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' });
            };

            const contractData = {
                docDate: formatThai(new Date()),
                tenantName: document.getElementById('tenantName').value,
                tenantID: document.getElementById('tenantID').value,
                roomNo: document.getElementById('roomNo').value,
                floor: document.getElementById('floor').value,
                startDate: formatThai(document.getElementById('startDate').value),
                endDate: formatThai(document.getElementById('endDate').value),
                rent: parseFloat(document.getElementById('rent').value).toLocaleString('th-TH', {minimumFractionDigits: 2}),
                deposit: parseFloat(document.getElementById('deposit').value).toLocaleString('th-TH', {minimumFractionDigits: 2}),
                electric: document.getElementById('elec').value,
                water: document.getElementById('water').value,
                payDay: document.getElementById('payDay').value,
                fine: document.getElementById('fine').value
            };

            localStorage.setItem('contractData', JSON.stringify(contractData));
            alert("ดำเนินการออกสัญญาฉบับดิจิทัลเรียบร้อยแล้ว!");
            window.location.href = 'contract.html'; 
        };
    </script>

</body>
</html>
