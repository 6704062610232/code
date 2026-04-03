<?php 
  require_once 'db_config.php'; 
  
  $pageTitle = "ระบบจัดการพัสดุ";
  
  // --- Logic การบันทึกข้อมูล ---
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
      if ($_POST['action'] == 'save') {
          $room = $_POST['room'];
          $carrier = $_POST['carrier'];
          $name = $_POST['name'];
          $img = $_POST['img']; 
          $stmt = $conn->prepare("INSERT INTO parcels (room, carrier, receiver_name, image_path) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $room, $carrier, $name, $img);
          $stmt->execute();
          $stmt->close();
          header("Location: parcel.php"); 
          exit();
      }
  }

  // --- ดึงข้อมูลจาก Database ---
  $parcelData = [];
  $res = $conn->query("SELECT * FROM parcels ORDER BY created_at DESC");
  if ($res) {
      while($row = $res->fetch_assoc()) { $parcelData[] = $row; }
  }
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --c1: #CCD5AE; --c5: #D4A373; --white: #ffffff; --bg: #f8f9fa;
            --pending: #e67e22; --completed: #27ae60; --brown: #8d6e63;
        }
        body { font-family: 'Sarabun', sans-serif; background-color: var(--bg); margin: 0; padding: 0; }
        
        /* Navbar จำลองเพื่อให้สวยเหมือนต้นฉบับ */
        .navbar { background: white; padding: 15px 30px; display: flex; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .navbar b { color: var(--brown); font-size: 20px; }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        
        /* Stats Card */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 15px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .stat-card span { color: #888; font-size: 14px; display: block; margin-bottom: 10px; }
        .stat-card div { font-size: 28px; font-weight: bold; }

        /* Main Content */
        .content-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .toolbar { display: flex; justify-content: space-between; margin-bottom: 25px; align-items: center; }
        
        input[type="text"] { padding: 10px 15px; border: 1px solid #ddd; border-radius: 10px; width: 250px; }
        .btn-brown { background: var(--brown); color: white; border: none; padding: 12px 25px; border-radius: 12px; cursor: pointer; font-weight: 600; transition: 0.3s; }
        .btn-brown:hover { background: #6d544b; transform: translateY(-2px); }

        table { width: 100%; border-collapse: collapse; }
        th { color: #aaa; font-weight: normal; padding: 15px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        td { padding: 20px 15px; border-bottom: 1px solid #f8f8f8; }
        
        .badge { padding: 6px 15px; border-radius: 30px; color: white; font-size: 12px; font-weight: 600; cursor: pointer; }
        .bg-pending { background-color: var(--pending); }
        .bg-completed { background-color: var(--completed); }

        /* Modal */
        .modal-overlay { display: none; position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center; backdrop-filter: blur(4px); }
        .modal-card { background:white; padding:30px; border-radius:20px; width:90%; max-width:450px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
    </style>
</head>
<body>

    <div class="navbar">
        <b><i class="fas fa-home"></i> COZY HOME</b>
        <span style="margin-left: auto; color: #888;">รายการพัสดุ</span>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card"><span>พัสดุทั้งหมด</span><div id="countTotal">0</div></div>
            <div class="stat-card"><span style="color:var(--pending)">รอมารับ</span><div id="countPending" style="color:var(--pending)">0</div></div>
            <div class="stat-card"><span style="color:var(--completed)">รับแล้ว</span><div id="countDone" style="color:var(--completed)">0</div></div>
        </div>

        <div class="content-card">
            <div class="toolbar">
                <input type="text" id="searchInput" placeholder="🔍 ค้นหาเลขห้อง..." onkeyup="filterData()">
                <button class="btn-brown" onclick="openModal('addModal')"><i class="fas fa-plus"></i> ลงทะเบียนใหม่</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>เลขห้อง</th>
                        <th>บริษัทขนส่ง / ผู้รับ</th>
                        <th>สถานะ (คลิกดูรูป)</th>
                        <th>วันที่เข้า</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody id="parcelTableBody"></tbody>
            </table>
        </div>
    </div>

    <div id="addModal" class="modal-overlay">
        <div class="modal-card">
            <h3><i class="fas fa-box-open"></i> ลงทะเบียนพัสดุใหม่</h3>
            <form action="parcel.php" method="POST">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="img" id="imgBase64">
                
                <input type="text" name="room" placeholder="เลขห้อง (เช่น 101)" required style="width:100%; margin-bottom:15px;">
                <input type="text" name="carrier" placeholder="บริษัทขนส่ง" required style="width:100%; margin-bottom:15px;">
                <input type="text" name="name" placeholder="ชื่อผู้รับ" required style="width:100%; margin-bottom:15px;">
                
                <div style="border: 2px dashed #ccc; padding: 20px; text-align: center; border-radius: 10px; cursor: pointer;" onclick="document.getElementById('fileInp').click()">
                    <i class="fas fa-camera fa-2x" style="color: #ccc;"></i><br>
                    <span style="color: #888;">คลิกเพื่ออัปโหลดรูป</span>
                    <input type="file" id="fileInp" hidden accept="image/*" onchange="handleFile(this)">
                    <img id="preview" style="width:100%; margin-top:10px; display:none; border-radius:10px;">
                </div>

                <div style="display:flex; gap:10px; margin-top:20px;">
                    <button type="button" onclick="closeModal('addModal')" style="flex:1; padding:12px; border:none; border-radius:10px;">ยกเลิก</button>
                    <button type="submit" class="btn-brown" style="flex:1;">บันทึกพัสดุ</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const parcels = <?php echo json_encode($parcelData); ?>;
        
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }

        function handleFile(input) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('preview').style.display = 'block';
                document.getElementById('imgBase64').value = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }

        function renderTable(data = parcels) {
            const tbody = document.getElementById('parcelTableBody');
            tbody.innerHTML = '';
            data.forEach(p => {
                const badge = p.status === 'pending' ? 'bg-pending' : 'bg-completed';
                const text = p.status === 'pending' ? 'รอมารับ' : 'เสร็จสิ้น';
                tbody.innerHTML += `
                    <tr>
                        <td><b>${p.room}</b></td>
                        <td><b>${p.carrier}</b><br><small style="color:#aaa">ผู้รับ: ${p.receiver_name}</small></td>
                        <td><span class="badge ${badge}">${text}</span></td>
                        <td>${new Date(p.created_at).toLocaleDateString('th-TH')}</td>
                        <td><button style="border:none; background:none; color:var(--brown); cursor:pointer;"><i class="fas fa-edit"></i></button></td>
                    </tr>`;
            });
            updateStats();
        }

        function updateStats() {
            document.getElementById('countTotal').innerText = parcels.length;
            document.getElementById('countPending').innerText = parcels.filter(x => x.status === 'pending').length;
            document.getElementById('countDone').innerText = parcels.filter(x => x.status === 'completed').length;
        }

        function filterData() {
            const val = document.getElementById('searchInput').value.toLowerCase();
            const filtered = parcels.filter(x => x.room.toLowerCase().includes(val));
            renderTable(filtered);
        }

        window.onload = renderTable;
    </script>
</body>
</html>