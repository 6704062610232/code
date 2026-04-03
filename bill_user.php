<?php
$conn = new mysqli("localhost","root","","cozyhome_db");

$room = "101"; // 🔥 ตรงนี้เอาจาก login ได้ในอนาคต

// ดึงบิลล่าสุดของห้องนี้
$stmt = $conn->prepare("
    SELECT * FROM bills 
    WHERE room = ?
    ORDER BY id DESC LIMIT 1
");
$stmt->bind_param("s", $room);
$stmt->execute();
$result = $stmt->get_result();

$bill = $result->fetch_assoc();
?>
<?php if(!$bill): ?>
<h3 style="text-align:center; margin-top:50px;">ยังไม่มีบิลในเดือนนี้</h3>
<?php exit; endif; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ดูบิลค่าเช่า - Cozy Home Member</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* --- Style จากหน้าบิล --- */
        body { font-family: 'Sarabun', sans-serif; background-color: #fcfaf2; }
        .accent-bg { background-color: #e2b088; } 
        .accent-text { color: #e2b088; }
        .input-bg { background-color: #f5f5f5; }
        
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            cursor: pointer; filter: invert(75%) sepia(15%) saturate(800%) hue-rotate(330deg) brightness(95%) contrast(90%);
        }

        @media print {
            @page { size: A5 landscape; margin: 0; }
            html, body { height: 148mm; overflow: hidden; } 
            body * { visibility: hidden; }
            #printableReceipt, #printableReceipt * { visibility: visible; }
            #printableReceipt {
                display: block !important;
                position: absolute; left: 0; top: 0;
                width: 210mm; height: 148mm;
                padding: 10mm; background: white; color: black; box-sizing: border-box;
            }
            .no-print { display: none !important; }
        }

        #printableReceipt { display: none; }
        .receipt-table { border-collapse: collapse; width: 100%; border: 1px solid black; }
        .receipt-table th, .receipt-table td { border: 1px solid black; padding: 4px 8px; text-align: center; font-size: 12px; }
        .info-border { border: 1px solid black; }

        /* --- Style จากหน้าแท็บซ้าย --- */
        :root {
            --c1: #CCD5AE; --c2: #E9EDC9; --c3: #FEFAE0; --c4: #FAEDCD; --c5: #D4A373;
            --white: #ffffff; --text: #444; --danger: #e74c3c;
            --nav-height: 65px;
        }

        body { margin: 0; padding: 0; color: var(--text); overflow-x: hidden; background-color: #fcfaf2; }

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
        
        .user-dropdown { 
            position: absolute; right: 0; top: 45px; background: white; border: 1px solid #f0f0f0; 
            border-radius: 12px; display: none; z-index: 100; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 160px; overflow: hidden; 
        }
        .user-nav-item:hover .user-dropdown { display: block; }
        .user-dropdown button { display: block; width: 100%; padding: 12px 15px; border: none; background: none; text-align: left; font-size: 14px; cursor: pointer; font-family: 'Sarabun'; transition: 0.2s; color: #555; }
        .user-dropdown button i { margin-right: 10px; width: 15px; color: #888; text-align: center; }
        .user-dropdown button:hover { background: #fffaf4; color: var(--c5); }

        .sidebar { position: fixed; top: 0; left: -300px; width: 300px; height: 100%; background: var(--white); z-index: 2001; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 15px 0 40px rgba(0,0,0,0.1); overflow-y: auto; }
        .sidebar.active { left: 0; }
        .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); z-index: 2000; display: none; backdrop-filter: blur(2px); }

        .sidebar-header { 
            padding: 40px 20px; 
            display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; 
            background: linear-gradient(135deg, #faf1e6 0%, #ffffff 100%); border-bottom: 1px solid #f8f8f8; 
        }
        .sidebar-user-img { 
            width: 85px; height: 85px; border-radius: 50%; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.08); object-fit: cover; display: block;
        }
        
        .sidebar-menu { list-style: none; padding: 15px; margin: 0; }
        .sidebar-menu li { margin-bottom: 2px; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 15px; text-decoration: none; color: #555; border-radius: 12px; transition: 0.3s; font-weight: 500; font-size: 14.5px; }
        .sidebar-menu a i { width: 20px; text-align: center; font-size: 16px; color: #999; }
        .sidebar-menu a.active { background: #fff9f2; color: var(--c5); font-weight: 600; }
        .sidebar-menu a.active i { color: var(--c5); }
        .sidebar-menu a:hover:not(.active) { background: #fdfdfd; transform: translateX(5px); color: var(--c5); }
        .sidebar-menu a.danger { color: var(--danger); margin-top: 10px; }
        .sidebar-menu a.danger i { color: var(--danger); }

        /* Modals */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 3000; justify-content: center; align-items: center; backdrop-filter: blur(4px); }
        .modal-card { background: white; width: 90%; max-width: 450px; border-radius: 25px; padding: 30px; box-sizing: border-box; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
        .modal-input-group { margin-bottom: 15px; }
        .modal-input-group label { font-size: 13px; color: #888; margin-bottom: 5px; display: block; }
        .modal-input-group input { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #eee; background: #fafafa; font-family: 'Sarabun'; outline: none; box-sizing: border-box; font-size: 14.5px; }
        
        .btn-row { display: flex; gap: 12px; margin-top: 20px; }
        .btn-confirm { flex: 2; background: #e1ad7f; color: white; border: none; padding: 14px; border-radius: 12px; cursor: pointer; font-weight: bold; font-family: 'Sarabun'; }
        .btn-cancel { flex: 1; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; }
        .btn-close-profile { width: 100%; background: #f1f1f1; border: none; padding: 14px; border-radius: 12px; cursor: pointer; color: #777; font-family: 'Sarabun'; margin-top: 10px; }
    </style>
</head>
<body class="min-h-screen">

    <!-- Navbar -->
    <header class="top-navbar no-print">
        <div class="nav-left">
            <div class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <div class="brand-logo">Cozy Home</div>
        </div>
        <div class="nav-center">
            <h2 class="page-title" id="navPageTitle">แจ้งชำระค่าน้ำ-ไฟ</h2>
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
    <div id="sidebarOverlay" class="sidebar-overlay no-print" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar no-print">
        <div class="sidebar-header">
            <img src="https://i.pravatar.cc/150?u=tenant1" class="sidebar-user-img">
            <h4 style="margin:15px 0 0 0; color:#5d4037; font-size:17px;">คุณประเสริฐ สิริกวินวงศ์</h4>
            <p style="font-size:12px; color:#aaa; margin-top:5px;">ห้อง 101 | ผู้เช่า</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" onclick="changePage('กระดานข่าวสาร', this)"><i class="fas fa-bullhorn"></i> กระดานข่าวสาร</a></li>
            <li><a href="#" onclick="changePage('แจ้งชำระค่าน้ำ-ไฟ', this)" class="active"><i class="fas fa-tachometer-alt"></i> แจ้งชำระค่าน้ำ-ไฟ</a></li>
            <li><a href="#" onclick="changePage('รายการพัสดุ', this)"><i class="fas fa-box"></i> รายการพัสดุของฉัน</a></li>
            <li><a href="#" onclick="changePage('แจ้งซ่อม', this)"><i class="fas fa-tools"></i> แจ้งซ่อม/แจ้งปัญหา</a></li>
            <li><a href="#" onclick="changePage('สัญญาเช่า', this)"><i class="fas fa-file-contract"></i> สัญญาเช่าของฉัน</a></li>
            <hr style="border:0; border-top:1px solid #f5f5f5; margin:15px 0;">
            <li><a href="#" onclick="openProfileModal()"><i class="fas fa-user-circle"></i> ข้อมูลส่วนตัว</a></li>
            <li><a href="#" onclick="openModal('logoutConfirmModal')" class="danger"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
        </ul>
    </nav>

    <!-- Main Content Area -->
    <main class="p-4 md:py-12 md:px-10 flex flex-col items-center">
        <div class="no-print bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.06)] border border-white w-full max-w-xl overflow-hidden mt-4 md:mt-2">
            <div class="p-8 md:p-10 pb-4">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <svg width="120" height="40" viewBox="0 0 240 80" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 50 L45 30 L70 50 L70 75 L20 75 Z" fill="none" stroke="#4a4a4a" stroke-width="2"/>
                            <path d="M40 34 L40 28 L45 28 L45 30" fill="none" stroke="#4a4a4a" stroke-width="2"/>
                            <line x1="90" y1="20" x2="90" y2="70" stroke="#4a4a4a" stroke-width="2"/>
                            <text x="110" y="45" font-family="Sarabun" font-size="22" font-weight="bold" fill="#4a4a4a">COZY</text>
                            <text x="110" y="68" font-family="Sarabun" font-size="22" font-weight="bold" fill="#4a4a4a">HOME</text>
                        </svg>
                    </div>
                    <?php if($bill['status'] == 'paid'): ?><span id="statusBadge" class="bg-green-50 text-green-600 px-4 py-1.5 rounded-full text-xs font-bold border border-green-100">ชำระแล้ว</span>
<?php else: ?>
<span id="statusBadge" class="bg-[#fdf3e7] text-[#e2b088] px-4 py-1.5 rounded-full text-xs font-bold border border-[#fae8d5]">
รอชำระ
</span>
<?php endif; ?>
                </div>
                <div class="flex justify-between items-end gap-4">
                    <div class="space-y-1">
                        <p class="text-gray-400 text-sm">เดือนเมษายน 2569</p>
                        <p class="text-lg font-semibold">ห้อง <?= $bill['room'] ?> | <?= $bill['name'] ?></p>
                    </div>
                    <div class="bg-rose-50 px-4 py-2 rounded-2xl border border-rose-100">
                        <span class="text-[10px] text-rose-400 font-bold block text-right">ครบกำหนด</span>
                        <span class="text-xs text-rose-600 font-bold">5 เม.ย. 2569</span>
                    </div>
                </div>
            </div>
            <div class="px-8 md:px-10 py-4">
                <div class="flex justify-between"><span>ค่าเช่าห้องพัก</span><span class="font-bold"><?= number_format($bill['rent'],2) ?></span>
</div>
                    <div class="flex justify-between">
                        <div class="flex flex-col"><span>ค่าน้ำ / ค่าไฟ</span><span class="text-[10px] text-gray-400">จดเลขตามจริง (0 หน่วย)</span></div>
                        <span class="font-bold"><?= number_format($bill['water_price'] + $bill['elec_price'],2) ?></span>
                    </div>
                    <div class="flex justify-between"><span>อินเทอร์เน็ต + ส่วนกลาง</span><span class="font-bold">700.00</span></div>
                    <div class="border-t-2 border-dashed border-gray-100 my-4"></div>
                    <div class="flex justify-between items-end">
                        <span class="text-gray-500 font-bold">ยอดรวมทั้งหมด</span>
                        <div class="text-right">
                            <span class="text-3xl font-bold accent-text"><?= number_format($bill['total'],2) ?></span>
                            <span class="text-sm font-bold accent-text ml-1">บาท</span>
                        </div>
                    </div>
                    <div class="p-8 md:p-10 pt-4">
                <div id="sectionUnpaid" class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex-1 text-center">
                            <label class="text-[10px] text-gray-400 font-bold">วันที่ชำระ</label>
                            <input type="date" id="payDate" class="w-full input-bg rounded-2xl py-4 px-2 text-xs border-2 border-transparent focus:border-[#e2b088] text-center">
                        </div>
                        <div class="flex-1 text-center">
                            <label class="text-[10px] text-gray-400 font-bold">เวลา</label>
                            <input type="time" id="payTime" class="w-full input-bg rounded-2xl py-4 px-2 text-xs border-2 border-transparent focus:border-[#e2b088] text-center">
                        </div>
                    </div>
                    <input type="file" id="fileInput" accept="image/*" class="hidden">
                    <div onclick="document.getElementById('fileInput').click()" class="border-2 border-dashed border-[#fae8d5] rounded-[1.5rem] p-8 flex flex-col items-center justify-center cursor-pointer hover:bg-[#fff9f2] min-h-[160px] relative transition-all">
                        <div id="placeholder" class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2 accent-text" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="text-xs accent-text font-bold uppercase">แนบสลิปโอนเงิน</span>
                        </div>
                        <img id="preview" src="#" class="hidden max-h-48 rounded-xl object-contain shadow-sm">
                    </div>
                    <button onclick="updateStatus('success')" class="w-full accent-bg text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#e2b088]/20 transition-all active:scale-95 text-sm">
                        ส่งหลักฐานการชำระเงิน
                    </button>
                </div>
                </div>
            </div>
            
                <div id="sectionSuccess" class="hidden space-y-3">
                    <div class="bg-green-50 p-4 rounded-2xl border border-green-100 text-center mb-4 text-green-600 font-bold text-sm">ชำระเงินเรียบร้อยแล้ว</div>
                    <div class="flex gap-3">
                        <!-- ปุ่มดูใบแจ้งหนี้ -->
                        <button onclick="openPreview()" class="flex-1 bg-white text-[#4a4a4a] border border-gray-200 font-bold py-4 rounded-2xl text-xs hover:bg-gray-50 active:scale-95 transition-all">ดูใบแจ้งหนี้</button>
                        <button onclick="window.print()" class="flex-[2] accent-bg text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#e2b088]/20 text-sm flex items-center justify-center gap-2 active:scale-95 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            พิมพ์ใบเสร็จ (A5)
                        </button>
                    </div>
                </div>
            </div>
            </div>
    </main>
    <!-- Modal: ข้อมูลส่วนตัว -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <h3 style="text-align:center; color:#5d4037; margin-top: 0;">👤 ข้อมูลส่วนตัว</h3>
            <div style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 20px; width: 100%;">
                <img src="https://i.pravatar.cc/150?u=tenant1" style="width:100px; height:100px; border-radius:50%; border:3px solid white; box-shadow:0 5px 15px rgba(0,0,0,0.1); object-fit: cover; display: block;">
            </div>
            <div class="modal-input-group">
                <label>ชื่อ-นามสกุล</label>
                <input type="text" value="คุณประเสริฐ สิริกวินวงศ์" readonly>
            </div>
            <div class="modal-input-group">
                <label>เลขห้อง / ยูนิต</label>
                <input type="text" value="101" readonly>
            </div>
            <div class="modal-input-group">
                <label>ประเภทสมาชิก</label>
                <input type="text" value="ผู้เช่า / ผู้อยู่อาศัย" readonly>
            </div>
            <button class="btn-close-profile" onclick="closeModal('profileModal')">ปิดหน้าต่าง</button>
        </div>
    </div>

    <!-- Modal: ยืนยันออกจากระบบ (แบบแก้ไขใหม่) -->
    <div id="logoutConfirmModal" class="modal-overlay">
        <div class="modal-card" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
            <div style="background: #fff5f5; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-sign-out-alt" style="font-size: 35px; color: var(--danger);"></i>
            </div>
            <h3 style="margin: 0; color: #5d4037; font-size: 20px;">ต้องการออกจากระบบ?</h3>
            <p style="color: #888; margin-top: 10px; font-size: 14px;">คุณแน่ใจหรือไม่ว่าต้องการออกจากเซสชันนี้</p>
            <div class="btn-row" style="width: 100%;">
                <button class="btn-cancel" onclick="closeModal('logoutConfirmModal')">ยกเลิก</button>
                <button class="btn-confirm" onclick="location.reload()" style="background:var(--danger); box-shadow: 0 10px 20px rgba(231, 76, 60, 0.2);">ยืนยัน</button>
            </div>
        </div>
    </div>

    <!-- PREVIEW MODAL (สำหรับปุ่มดูใบแจ้งหนี้) -->
    <div id="previewModal" class="fixed inset-0 bg-black/70 z-[5000] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-4xl rounded-3xl overflow-hidden shadow-2xl">
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-sm">ตัวอย่างเอกสาร</h3>
                <button onclick="closePreview()" class="p-2 hover:bg-gray-200 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            <div class="p-4 md:p-10 overflow-auto max-h-[70vh] bg-gray-200 flex justify-center">
                <div id="modalReceiptBody" class="bg-white shadow-lg" style="width: 210mm; height: 148mm; padding: 10mm; box-sizing: border-box;"></div>
            </div>
            <div class="p-4 border-t text-center bg-white"><button onclick="window.print()" class="accent-bg text-white px-10 py-3 rounded-xl font-bold text-sm shadow-lg">สั่งพิมพ์ตอนนี้</button></div>
        </div>
    </div>

    <!-- PRINT TEMPLATE (Hidden) -->
    <div id="printableReceipt">
        <div class="flex justify-between items-start mb-2">
            <svg width="180" height="60" viewBox="0 0 240 80" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 50 L45 30 L70 50 L70 75 L20 75 Z" fill="none" stroke="black" stroke-width="2"/>
                <path d="M40 34 L40 28 L45 28 L45 30" fill="none" stroke="black" stroke-width="2"/>
                <line x1="90" y1="20" x2="90" y2="70" stroke="black" stroke-width="2"/>
                <text x="110" y="45" font-family="Sarabun" font-size="22" font-weight="bold" fill="black">COZY</text>
                <text x="110" y="68" font-family="Sarabun" font-size="22" font-weight="bold" fill="black">HOME</text>
            </svg>
            <div class="text-5xl font-bold">101</div>
        </div>
        <h1 class="text-center text-2xl font-bold underline mb-4">ใบแจ้งหนี้</h1>
        <div class="grid grid-cols-12 info-border mb-3 text-xs">
            <div class="col-span-8 p-2 border-r border-black space-y-1">
                <p><strong>ชื่อผู้เช่า:</strong> คุณประเสริฐ สิริกวินวงศ์</p>
                <p><strong>ที่อยู่:</strong> เลขที่ 123/45 ซอยวงศ์สว่าง 11 แขวงวงศ์สว่าง เขตบางซื่อ กรุงเทพฯ 10800</p>
            </div>
            <div class="col-span-4 p-2">
                <p><strong>เลขที่ No.</strong> INV-101</p>
                <div class="border-b border-black my-1"></div>
                <p><strong>วันที่ Date</strong> 01/เมษายน 2569</p>
            </div>
        </div>
        <table class="receipt-table mb-2">
            <thead>
                <tr class="text-xs"><th>ลำดับ</th><th>รายการ</th><th>จำนวน</th><th>ราคา</th><th>เงิน</th></tr>
            </thead>
            <tbody class="text-xs">
                <tr><td>1</td><td class="text-left">ค่าไฟ ( 5000 - 5000 )</td><td>0</td><td>7.00</td><td>0.00</td></tr>
                <tr><td>2</td><td class="text-left">ค่าน้ำ ( 100 - 100 )</td><td>0</td><td>19.00</td><td>0.00</td></tr>
                <tr><td>3</td><td class="text-left">ค่าเช่าห้องพัก ประจำเดือน เมษายน</td><td>1</td><td>2600.00</td><td>2,600.00</td></tr>
                <tr><td>4</td><td class="text-left">ค่าอินเทอร์เน็ต + ค่าส่วนกลาง</td><td>1</td><td>700.00</td><td>700.00</td></tr>
                <tr class="font-bold">
                    <td colspan="4" class="text-center">(สามพันสามร้อยบาทถ้วน)</td>
                    <td class="bg-gray-50">สุทธิ: 3,300.00</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-between items-end mt-8">
            <div class="text-[9px] space-y-1">
                <p>หมายเหตุ: 1. แจ้งสลิปผ่านทาง LINE Official ของหอพัก</p>
                <p>2. ชำระเกินวันที่ 5 ของเดือน มีค่าปรับวันละ 50 บาท</p>
            </div>
            <div class="text-center text-xs">
                <p class="mb-10">ลงชื่อ __________________________ ผู้รับเงิน</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
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
            if(element) element.classList.add('active');
            if (window.innerWidth < 1000) toggleSidebar(); 
        }
        function openModal(id) { 
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').style.display = 'none';
            document.getElementById(id).style.display = 'flex'; 
        }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        function openProfileModal() { openModal('profileModal'); }
        function updateStatus(status) {
            const badge = document.getElementById('statusBadge');
            const secUnpaid = document.getElementById('sectionUnpaid');
            const secSuccess = document.getElementById('sectionSuccess');
            if (status === 'success') {
                secUnpaid.classList.add('hidden');
                secSuccess.classList.remove('hidden');
                badge.innerText = 'ชำระสำเร็จ';
                badge.className = 'bg-green-50 text-green-600 px-4 py-1.5 rounded-full text-xs font-bold border border-green-100';
            } else {
                secUnpaid.classList.remove('hidden');
                secSuccess.classList.add('hidden');
                badge.innerText = 'รอชำระ';
                badge.className = 'bg-[#fdf3e7] text-[#e2b088] px-4 py-1.5 rounded-full text-xs font-bold border border-[#fae8d5]';
            }
        }
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview').src = event.target.result;
                    document.getElementById('preview').classList.remove('hidden');
                    document.getElementById('placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
        
        // ฟังก์ชันเปิดดูใบแจ้งหนี้
        function openPreview() {
            const template = document.getElementById('printableReceipt').innerHTML;
            document.getElementById('modalReceiptBody').innerHTML = template;
            document.getElementById('previewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>