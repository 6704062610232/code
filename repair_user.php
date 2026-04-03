<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งซ่อม - COZY HOME</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --c1: #CCD5AE; --c2: #E9EDC9; --c3: #FEFAE0; --c4: #FAEDCD; --c5: #D4A373;
            --white: #ffffff; --text: #444; --danger: #e74c3c; --success: #2ecc71;
            --primary-tan: #D9B08C; 
            --status-bg: #FAF3E8;
            --input-bg: #F0F2F5;
            --nav-height: 65px;
        }

        body { font-family: 'Sarabun', sans-serif; background-color: #f6f5f2; margin: 0; padding: 0; color: var(--text); overflow-x: hidden; }

        /* --- Navbar (ชุดใหม่) --- */
        .top-navbar { 
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 25px; height: var(--nav-height);
            background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid #eee;
        }
        .nav-left { display: flex; align-items: center; gap: 15px; flex: 1; }
        .menu-toggle { font-size: 20px; color: var(--c5); cursor: pointer; }
        .brand-logo { font-weight: 600; color: #5d4037; font-size: 16px; letter-spacing: 1.5px; text-transform: uppercase; border-left: 2px solid #eee; padding-left: 15px; }
        .nav-center { flex: 2; text-align: center; }
        .page-title { margin: 0; font-size: 18px; font-weight: 600; color: var(--text); }
        .nav-right { flex: 1; display: flex; justify-content: flex-end; position: relative; }
        .user-nav-item { display: flex; align-items: center; cursor: pointer; padding: 5px; position: relative; }
        .nav-user-small { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--c4); }

        /* User Dropdown */
        .user-dropdown { 
            position: absolute; right: 0; top: 45px; background: white; border: 1px solid #f0f0f0; 
            border-radius: 12px; display: none; z-index: 100; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 160px; overflow: hidden; 
        }
        .user-nav-item:hover .user-dropdown { display: block; }
        .user-dropdown button { display: block; width: 100%; padding: 12px 15px; border: none; background: none; text-align: left; font-size: 14px; cursor: pointer; font-family: 'Sarabun'; transition: 0.2s; color: #555; }
        .user-dropdown button i { margin-right: 10px; width: 15px; color: #888; text-align: center; }
        .user-dropdown button:hover { background: #fffaf4; color: var(--c5); }

        /* --- Sidebar (ชุดใหม่) --- */
        .sidebar { position: fixed; top: 0; left: -300px; width: 300px; height: 100%; background: var(--white); z-index: 2001; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 15px 0 40px rgba(0,0,0,0.1); overflow-y: auto; }
        .sidebar.active { left: 0; }
        .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); z-index: 2000; display: none; backdrop-filter: blur(2px); }
        
        .sidebar-header { padding: 40px 20px; text-align: center; background: linear-gradient(135deg, #faf1e6 0%, #ffffff 100%); border-bottom: 1px solid #f8f8f8; }
        .sidebar-user-img { width: 85px; height: 85px; border-radius: 50%; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.08); object-fit: cover; }
        
        .sidebar-menu { list-style: none; padding: 15px; margin: 0; }
        .sidebar-menu li { margin-bottom: 2px; width: 100%; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 18px; text-decoration: none; color: #555; border-radius: 12px; transition: 0.3s; font-weight: 500; font-size: 14.5px; }
        .sidebar-menu a i { width: 20px; text-align: center; font-size: 16px; color: #999; }
        .sidebar-menu a.active { background: #fff9f2; color: var(--c5); font-weight: 600; }
        .sidebar-menu a.active i { color: var(--c5); }
        .sidebar-menu a:hover:not(.active) { background: #fdfdfd; transform: translateX(5px); color: var(--c5); }
        .sidebar-menu a.danger { color: var(--danger); margin-top: 10px; }
        .sidebar-menu a.danger i { color: var(--danger); }

        /* --- Main Content (Repair Form) --- */
        .main-content { display: flex; justify-content: center; padding: 40px 20px; min-height: calc(100vh - var(--nav-height)); }
        .card { background-color: var(--white); width: 100%; max-width: 500px; border-radius: 40px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); height: fit-content; text-align: center; }
        
        .header-icon { font-size: 24px; color: var(--primary-tan); background: var(--status-bg); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto 20px auto; }
        
        .form-group { margin-bottom: 22px; text-align: left; /* ปรับให้ Label ชิดซ้ายในฟอร์ม */ }
        .form-group label { display: block; font-size: 13px; color: #9B9B9B; margin-bottom: 10px; font-weight: 600; padding-left: 5px; }
        .form-control { width: 100%; background-color: var(--input-bg); border: none; border-radius: 20px; padding: 16px 20px; font-family: 'Sarabun'; font-size: 15px; outline: none; box-sizing: border-box; }
        
        /* Upload Zone */
        .upload-zone { 
            border: 2px dashed #fae8d5; border-radius: 1.5rem; padding: 25px; 
            display: flex; flex-direction: column; justify-content: center; align-items: center; 
            cursor: pointer; background: #fff; transition: all 0.3s; min-height: 180px; position: relative; text-align: center;
        }
        .upload-zone:hover { background-color: #fff9f2; border-color: var(--primary-tan); }
        #placeholder i { color: var(--primary-tan); font-size: 32px; margin-bottom: 10px; }
        #placeholder p { color: var(--primary-tan); font-size: 12px; font-weight: 800; text-transform: uppercase; margin: 0; }
        
        #previewContainer { display: none; flex-wrap: wrap; justify-content: center; align-items: center; gap: 12px; width: 100%; }
        .preview-img { width: 90px; height: 90px; border-radius: 15px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        .btn-submit { width: 100%; background-color: var(--primary-tan); color: white; border: none; padding: 18px; border-radius: 22px; font-size: 16px; font-weight: 700; cursor: pointer; margin-top: 15px; box-shadow: 0 4px 15px rgba(217, 176, 140, 0.4); transition: 0.3s; font-family: 'Sarabun'; }
        .btn-submit:active { transform: scale(0.98); }

        /* --- Modals (Profile, Logout, Success) --- */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 3000; justify-content: center; align-items: center; backdrop-filter: blur(4px); }
        .modal-card { background: white; width: 90%; max-width: 420px; border-radius: 25px; padding: 30px; box-sizing: border-box; box-shadow: 0 20px 50px rgba(0,0,0,0.15); text-align: center; }
        
        .modal-input-group { margin-bottom: 15px; text-align: left; }
        .modal-input-group label { font-size: 13px; color: #888; margin-bottom: 5px; display: block; }
        .modal-input-group input { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #eee; background: #fafafa; font-family: 'Sarabun'; outline: none; box-sizing: border-box; font-size: 14.5px; }
        .modal-input-group input[readonly] { background-color: #f1f1f1; color: #999; }
        
        .btn-row { display: flex; gap: 12px; margin-top: 20px; }
        .btn-confirm { flex: 2; background: #e1ad7f; color: white; border: none; padding: 14px; border-radius: 12px; cursor: pointer; font-weight: bold; font-family: 'Sarabun'; }
        .btn-cancel { flex: 1; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; }
        .btn-close-profile { width: 100%; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; margin-top: 10px; }
        
        .hidden { display: none !important; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <header class="top-navbar">
        <div class="nav-left">
            <div class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <div class="brand-logo">Cozy Home</div>
        </div>
        <div class="nav-center">
            <h2 class="page-title" id="navPageTitle">แจ้งซ่อม/แจ้งปัญหา</h2>
        </div>
        <div class="nav-right">
            <div class="user-nav-item">
                <img src="https://i.pravatar.cc/150?u=tenant1" class="nav-user-small">
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
            <img src="https://i.pravatar.cc/150?u=tenant1" class="sidebar-user-img">
            <h4 style="margin:15px 0 0 0; color:#5d4037; font-size:17px;">คุณสมชาย ใจดี</h4>
            <p style="font-size:12px; color:#aaa; margin-top:5px;">ห้อง 402 | ผู้เช่า</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#"><i class="fas fa-bullhorn"></i> กระดานข่าวสาร</a></li>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> แจ้งชำระค่าน้ำ-ไฟ</a></li>
            <li><a href="#"><i class="fas fa-box"></i> รายการพัสดุของฉัน</a></li>
            <li><a href="#" class="active"><i class="fas fa-tools"></i> แจ้งซ่อม/แจ้งปัญหา</a></li>
            <li><a href="#"><i class="fas fa-file-contract"></i> สัญญาเช่าของฉัน</a></li>
            <hr style="border:0; border-top:1px solid #f5f5f5; margin:15px 0;">
            <li><a href="#" onclick="openProfileModal()"><i class="fas fa-user-circle"></i> ข้อมูลส่วนตัว</a></li>
            <li><a href="#" onclick="openModal('logoutConfirmModal')" class="danger"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="card">
            <div class="header-icon"><i class="fa-solid fa-wrench"></i></div>
            <div style="margin-bottom: 30px;">
                <p style="color: #9B9B9B; font-size: 14px; margin: 0;">แบบฟอร์มส่งเรื่องใหม่</p>
                <h2 style="font-size: 20px; margin: 5px 0; color: #4A4A4A;">ห้อง 402 | คุณสมชาย</h2>
            </div>
            
            <form id="repairForm">
                <div class="form-group">
                    <label>หัวข้อปัญหาที่พบ</label>
                    <select class="form-control" required style="appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%239B9B9B\' d=\'M1.41 4.243L6 8.828l4.586-4.585L12 5.657l-6 6-6-6z\'/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 20px center;">
                        <option value="" disabled selected>กรุณาเลือกรายการแจ้งซ่อม</option>
                        <option value="ไฟฟ้า">ระบบไฟฟ้า / หลอดไฟเสีย</option>
                        <option value="ประปา">ระบบประปา / น้ำรั่วซึม</option>
                        <option value="สุขภัณฑ์">สุขภัณฑ์ / อุปกรณ์ห้องน้ำ</option>
                        <option value="แอร์">เครื่องปรับอากาศ / ล้างแอร์</option>
                        <option value="เฟอร์นิเจอร์">เฟอร์นิเจอร์ / อุปกรณ์ชำรุด</option>
                        <option value="ประตูหน้าต่าง">กลอนประตู / หน้าต่าง / ลูกบิด</option>
                        <option value="เครื่องใช้ไฟฟ้า">เครื่องใช้ไฟฟ้า (ตู้เย็น/น้ำอุ่น)</option>
                        <option value="อินเทอร์เน็ต">อินเทอร์เน็ต / สัญญาณทีวี</option>
                        <option value="อื่นๆ">อื่นๆ (ระบุในรายละเอียดเพิ่มเติม)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>รายละเอียดเพิ่มเติม</label>
                    <textarea class="form-control" style="min-height:100px; resize:none;" placeholder="ระบุอาการชำรุด หรือจุดที่พบปัญหา..."></textarea>
                </div>

                <div class="form-group">
                    <label>แนบรูปภาพปัญหา (ถ้ามี)</label>
                    <input type="file" id="fileInput" accept="image/*" multiple class="hidden">
                    <div onclick="document.getElementById('fileInput').click()" class="upload-zone">
                        <div id="placeholder">
                            <i class="fa-solid fa-camera-retro"></i>
                            <p>ถ่ายภาพ หรือ แนบรูปภาพ</p>
                        </div>
                        <div id="previewContainer"></div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">ส่งข้อมูลแจ้งซ่อม</button>
            </form>
        </div>
    </main>

    <!-- Modal: ข้อมูลส่วนตัว -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <h3 style="color:#5d4037; margin-top: 0;">👤 ข้อมูลส่วนตัว</h3>
            <div style="text-align:center; margin-bottom:20px;">
                <img src="https://i.pravatar.cc/150?u=tenant1" style="width:100px; height:100px; border-radius:50%; border:3px solid white; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
            </div>
            <div class="modal-input-group">
                <label>ชื่อ-นามสกุล</label>
                <input type="text" value="คุณสมชาย ใจดี" readonly>
            </div>
            <div class="modal-input-group">
                <label>เลขห้อง / ยูนิต</label>
                <input type="text" value="402" readonly>
            </div>
            <div class="modal-input-group">
                <label>ประเภทสมาชิก</label>
                <input type="text" value="ผู้เช่า / ผู้อยู่อาศัย" readonly>
            </div>
            <button class="btn-close-profile" onclick="closeModal('profileModal')">ปิดหน้าต่าง</button>
        </div>
    </div>

    <!-- Modal: ยืนยันออกจากระบบ -->
    <div id="logoutConfirmModal" class="modal-overlay">
        <div class="modal-card">
            <i class="fas fa-sign-out-alt" style="font-size: 50px; color: var(--danger); margin-bottom: 20px;"></i>
            <h3 style="margin: 0;">ต้องการออกจากระบบ?</h3>
            <p style="color: #888; margin-top: 10px;">คุณแน่ใจหรือไม่ว่าต้องการออกจากเซสชันนี้</p>
            <div class="btn-row">
                <button class="btn-cancel" onclick="closeModal('logoutConfirmModal')">ยกเลิก</button>
                <button class="btn-confirm" onclick="location.reload()" style="background:var(--danger);">ยืนยันออกจากระบบ</button>
            </div>
        </div>
    </div>

    <!-- Modal: ส่งข้อมูลสำเร็จ -->
    <div id="successModal" class="modal-overlay">
        <div class="modal-card">
            <i class="fas fa-check-circle" style="font-size: 60px; color: var(--success); margin-bottom: 20px;"></i>
            <h3 style="margin: 0;">ส่งข้อมูลสำเร็จ!</h3>
            <p style="color: #888; margin-top: 10px;">เจ้าหน้าที่จะตรวจสอบและดำเนินการให้ครับ</p>
            <button class="btn-submit" style="background:var(--success); box-shadow:none;" onclick="location.reload()">ตกลง</button>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        }

        // Modal Controls
        function openModal(id) { 
            // ปิดเมนูถ้าเปิดอยู่
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').style.display = 'none';
            document.getElementById(id).style.display = 'flex'; 
        }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        function openProfileModal() { openModal('profileModal'); }

        // File Input Preview
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        const placeholder = document.getElementById('placeholder');

        fileInput.addEventListener('change', function() {
            previewContainer.innerHTML = ''; 
            if (this.files && this.files.length > 0) {
                placeholder.classList.add('hidden');
                previewContainer.style.display = 'flex';
                Array.from(this.files).slice(0, 4).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-img';
                        previewContainer.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                placeholder.classList.remove('hidden');
                previewContainer.style.display = 'none';
            }
        });

        // Form Submit
        document.getElementById('repairForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("category", document.querySelector("select").value);
    formData.append("detail", document.querySelector("textarea").value);

    const files = document.getElementById("fileInput").files;
    for (let i = 0; i < files.length; i++) {
        formData.append("images[]", files[i]);
    }

    fetch("submit_repair.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data === "success") {
            document.getElementById('successModal').style.display = 'flex';
        } else {
            alert("เกิดข้อผิดพลาด");
        }
    });
});
    </script>
</body>
</html>