<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Home - Member Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --c1: #CCD5AE; --c2: #E9EDC9; --c3: #FEFAE0; --c4: #FAEDCD; --c5: #D4A373;
            --white: #ffffff; --text: #444; --danger: #e74c3c;
            --nav-height: 65px;
        }

        body { font-family: 'Sarabun', sans-serif; background-color: #f6f5f2; margin: 0; padding: 0; color: var(--text); overflow-x: hidden; }

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
        .nav-center { flex: 2; text-align: center; }
        .page-title { margin: 0; font-size: 18px; font-weight: 600; color: var(--text); }
        .nav-right { flex: 1; display: flex; justify-content: flex-end; position: relative; }
        .user-nav-item { display: flex; align-items: center; cursor: pointer; padding: 5px; position: relative; }
        .nav-user-small { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--c4); }
        .user-dropdown { position: absolute; right: 0; top: 45px; background: white; border: 1px solid #f0f0f0; border-radius: 12px; display: none; z-index: 100; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 160px; overflow: hidden; }
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

        /* --- Modals --- */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 3000; justify-content: center; align-items: center; backdrop-filter: blur(4px); }
        .modal-card { background: white; width: 90%; max-width: 450px; border-radius: 25px; padding: 30px; box-sizing: border-box; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
        .modal-input-group { margin-bottom: 15px; }
        .modal-input-group label { font-size: 13px; color: #888; margin-bottom: 5px; display: block; }
        .modal-input-group input { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #eee; background: #fafafa; font-family: 'Sarabun'; outline: none; box-sizing: border-box; font-size: 14.5px; }
        .modal-input-group input[readonly] { background-color: #f1f1f1; color: #999; }
        .btn-row { display: flex; gap: 12px; margin-top: 20px; }
        .btn-confirm { flex: 2; background: #e1ad7f; color: white; border: none; padding: 14px; border-radius: 12px; cursor: pointer; font-weight: bold; font-family: 'Sarabun'; }
        .btn-cancel { flex: 1; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; }
        .btn-close-profile { width: 100%; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; margin-top: 10px; }

        /* --- News Feed Area --- */
        .container { width: 95%; max-width: 650px; margin: 25px auto; }
        .post-card { background: var(--white); border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); margin-bottom: 25px; border: 1px solid #f0f0f0; overflow: hidden; }
        .post-header { padding: 18px 20px; display: flex; align-items: center; gap: 12px; }
        .author-img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--c4); }
        .post-info b { color: #5d4037; font-size: 15px; }
        .post-time { font-size: 11px; color: #bbb; display: block; margin-top: 2px; }
        .post-content { padding: 0 20px 20px 20px; }
        .post-content h3 { margin: 0 0 8px 0; color: #333; font-size: 18px; }
        .post-content p { color: #666; line-height: 1.6; margin: 0; font-size: 14.5px; white-space: pre-wrap; }
        .post-main-img { width: 100%; border-radius: 12px; margin-top: 15px; display: block; }
        .comment-section { background: #fafafa; border-top: 1px solid #f0f0f0; padding: 15px 20px; display: flex; gap: 10px; }
        .comment-input { flex: 1; border-radius: 20px; border: 1px solid #ddd; padding: 8px 15px; outline: none; font-family: 'Sarabun'; font-size: 14px; }
        .btn-send { background: none; border: none; color: var(--c5); cursor: pointer; font-size: 18px; }
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
            <h2 class="page-title" id="navPageTitle">กระดานข่าวสาร</h2>
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

    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <img src="https://i.pravatar.cc/150?u=tenant1" class="sidebar-user-img">
            <h4 style="margin:15px 0 0 0; color:#5d4037; font-size:17px;">คุณสมชาย ใจดี</h4>
            <p style="font-size:12px; color:#aaa; margin-top:5px;">ห้อง 402 | ผู้เช่า</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" onclick="changePage('กระดานข่าวสาร', this)" class="active"><i class="fas fa-bullhorn"></i> กระดานข่าวสาร</a></li>
            <li><a href="#" onclick="changePage('แจ้งชำระค่าน้ำ-ไฟ', this)"><i class="fas fa-tachometer-alt"></i> แจ้งชำระค่าน้ำ-ไฟ</a></li>
            <li><a href="#" onclick="changePage('รายการพัสดุ', this)"><i class="fas fa-box"></i> รายการพัสดุของฉัน</a></li>
            <li><a href="#" onclick="changePage('แจ้งซ่อม', this)"><i class="fas fa-tools"></i> แจ้งซ่อม/แจ้งปัญหา</a></li>
            <li><a href="#" onclick="changePage('สัญญาเช่า', this)"><i class="fas fa-file-contract"></i> สัญญาเช่าของฉัน</a></li>
            <hr style="border:0; border-top:1px solid #f5f5f5; margin:15px 0;">
            <li><a href="#" onclick="openProfileModal()"><i class="fas fa-user-circle"></i> ข้อมูลส่วนตัว</a></li>
            <li><a href="#" onclick="openModal('logoutConfirmModal')" class="danger"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
        </ul>
    </nav>

    <!-- News Feed Area -->
    <div class="container" id="contentArea">
        <div id="postList">
            <!-- ข้อมูลจาก Admin จะมาแสดงผลที่นี่ผ่าน JavaScript -->
            <p style="text-align:center; padding:50px; color:#aaa;">ขณะนี้ยังไม่มีประกาศในระบบ</p>
        </div>
    </div>

    <!-- Popup: ข้อมูลส่วนตัว -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <h3 style="text-align:center; color:#5d4037; margin-top: 0;">👤 ข้อมูลส่วนตัว</h3>
            <div style="text-align:center; margin-bottom:20px;">
                <img src="https://i.pravatar.cc/150?u=tenant1" style="width:100px; height:100px; border-radius:50%; border:3px solid white; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
            </div>
            <div class="modal-input-group"><label>ชื่อ-นามสกุล</label><input type="text" value="คุณสมชาย ใจดี" readonly></div>
            <div class="modal-input-group"><label>เลขห้อง / ยูนิต</label><input type="text" value="402" readonly></div>
            <div class="modal-input-group"><label>ประเภทสมาชิก</label><input type="text" value="ผู้เช่า / ผู้อยู่อาศัย" readonly></div>
            <button class="btn-close-profile" onclick="closeModal('profileModal')">ปิดหน้าต่าง</button>
        </div>
    </div>

    <!-- Popup: ยืนยันออกจากระบบ -->
    <div id="logoutConfirmModal" class="modal-overlay">
        <div class="modal-card" style="text-align: center;">
            <i class="fas fa-sign-out-alt" style="font-size: 50px; color: var(--danger); margin-bottom: 20px;"></i>
            <h3 style="margin: 0;">ต้องการออกจากระบบ?</h3>
            <p style="color: #888; margin-top: 10px;">คุณแน่ใจหรือไม่ว่าต้องการออกจากเซสชันนี้</p>
            <div class="btn-row">
                <button class="btn-cancel" onclick="closeModal('logoutConfirmModal')">ยกเลิก</button>
                <button class="btn-confirm" onclick="location.reload()" style="background:var(--danger);">ยืนยันออกจากระบบ</button>
            </div>
        </div>
    </div>

    <script>
        // ฟังก์ชันเปิด/ปิด Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        }

        // ฟังก์ชันเปลี่ยนหน้า (อัปเดตหัวข้อและสถานะเมนู)
        function changePage(title, element) {
            document.getElementById('navPageTitle').innerText = title;
            const menuLinks = document.querySelectorAll('.sidebar-menu a');
            menuLinks.forEach(link => link.classList.remove('active'));
            if(element) element.classList.add('active');
            if (window.innerWidth < 1000) toggleSidebar();
        }

        // ฟังก์ชันเปิด/ปิด Modal
        function openModal(id) { 
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').style.display = 'none';
            document.getElementById(id).style.display = 'flex'; 
        }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        function openProfileModal() { openModal('profileModal'); }

        // --- ส่วนการจัดการกระดานข่าวสาร ---
        
        // ฟังก์ชันต้นแบบสำหรับการสร้าง HTML เมื่อมีข้อมูลจากแอดมิน
        function createPostTemplate(post) {
    const dateObj = new Date(post.created_at);

    const date = dateObj.toLocaleDateString('th-TH');
    const time = dateObj.toLocaleTimeString('th-TH', {
        hour: '2-digit',
        minute: '2-digit'
    });

    return `
        <div class="post-card">
            <div class="post-header">
                <img src="https://i.pravatar.cc/150?u=admin" class="author-img">
                <div class="post-info">
                    <b>Admin</b>
                    <span class="post-time">${date} | ${time} น.</span>
                </div>
            </div>
            <div class="post-content">
                <h3>${post.title}</h3>
                <p>${post.description}</p>
                ${post.image_path ? `<img src="${post.image_path}" class="post-main-img">` : ''}
            </div>
            <div class="comment-section">
                <input type="text" class="comment-input" placeholder="เขียนคอมเมนต์...">
                <button class="btn-send"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    `;
}

        // ฟังก์ชันโหลดข่าวสาร (ขณะนี้ว่างไว้สำหรับเชื่อมต่อ API)
        async function fetchPostsFromAdmin() {
    const list = document.getElementById('postList'); // 👈 ต้องมีบรรทัดนี้

    try {
        const response = await fetch('get_posts.php');
        const posts = await response.json();

        if (posts.length > 0) {
            list.innerHTML = posts.map(p => createPostTemplate(p)).join('');
        } else {
            list.innerHTML = '<p style="text-align:center; padding:50px; color:#aaa;">ขณะนี้ยังไม่มีประกาศในระบบ</p>';
        }

    } catch (error) {
        list.innerHTML = '<p style="color:red;">โหลดข้อมูลล้มเหลว</p>';
        console.error(error);
    }
}

        window.onload = fetchPostsFromAdmin;
    </script>
</body>
</html>