<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Home - Login & Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --c1: #CCD5AE;
            --c2: #E9EDC9;
            --c3: #FEFAE0;
            --c4: #FAEDCD;
            --c5: #D4A373;
            --white: #ffffff;
            --text: #444;
            --danger: #e74c3c;
            --input-blue: #edf2fa;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f1efeb;
            margin: 0;
            padding: 0;
            color: var(--text);
            overflow-x: hidden;
        }

        /* --- Auth Section --- */
        #authSection {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            background-color: #eeeae6;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-card {
            display: flex;
            background: var(--white);
            width: 100%;
            max-width: 1100px;
            height: 750px;
            border-radius: 60px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.12);
        }

        .login-left {
            flex: 1.2;
            padding: 40px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .login-left::-webkit-scrollbar {
            display: none;
        }

        .dorm-name {
            font-size: 32px;
            font-weight: 600;
            color: #5d4037;
            letter-spacing: 3px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .role-tabs {
            display: flex;
            background: #f0f0f0;
            border-radius: 15px;
            padding: 6px;
            width: 100%;
            margin-bottom: 25px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: none;
            cursor: pointer;
            font-family: 'Sarabun';
            font-size: 15px;
            color: #888;
            transition: 0.3s;
        }

        .tab-btn.active {
            background: var(--white);
            color: #d4a373;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            font-weight: bold;
        }

        .form-title {
            font-size: 20px;
            color: #5d4037;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .input-group {
            width: 100%;
            text-align: left;
            margin-bottom: 18px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            color: #999;
            margin-bottom: 5px;
            margin-left: 5px;
        }

        .field-container {
            position: relative;
            width: 100%;
        }

        .field-container i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #bf9e82;
            font-size: 16px;
        }

        .field-container input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border-radius: 15px;
            border: none;
            background: var(--input-blue);
            box-sizing: border-box;
            outline: none;
            font-family: 'Sarabun';
            font-size: 15px;
            transition: 0.3s;
        }

        .btn-login {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 18px;
            background: #e1ad7f;
            color: white;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
            box-shadow: 0 8px 15px rgba(225, 173, 127, 0.3);
        }

        .btn-login:hover {
            background: #d4a373;
            transform: translateY(-2px);
        }

        .signup-link {
            margin-top: 30px;
            font-size: 14px;
            color: #aaa;
        }

        .signup-link span {
            color: #d4a373;
            cursor: pointer;
            font-weight: bold;
            text-decoration: underline;
        }

        .avatar-circle {
            width: 100px;
            height: 100px;
            border-radius: 50% !important;
            object-fit: cover;
            border: 3px solid var(--white);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        .click-to-change {
            font-size: 12px;
            color: #d4a373;
            margin: 5px 0 15px 0;
            text-decoration: underline;
            cursor: pointer;
            font-weight: 600;
        }

        .login-right {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        /* --- Modals --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(8px);
            padding: 20px;
        }

        .modal-card {
            background: white;
            width: 95%;
            max-width: 450px;
            border-radius: 40px;
            padding: 40px;
            text-align: center;
            box-sizing: border-box;
            animation: slideUp 0.4s ease;
        }

        .btn-row {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn-confirm {
            flex: 2;
            background: #e1ad7f;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-cancel {
            flex: 1;
            background: #f5f5f5;
            border: none;
            padding: 15px;
            border-radius: 18px;
            cursor: pointer;
            color: #888;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div id="authSection">
        <div class="login-card">
            <!-- 1. ส่วนล็อกอิน -->
            <div class="login-left" id="loginForm">
                <div class="dorm-name">COZY HOME</div>
                <div class="role-tabs">
                    <button class="tab-btn active" id="tabTenant" onclick="switchRole('TENANT')">ผู้เช่า</button>
                    <button class="tab-btn" id="tabAdmin" onclick="switchRole('ADMIN')">ผู้ดูแล (Admin)</button>
                </div>
                <div class="form-title" id="formTitle">เข้าสู่ระบบผู้เช่า</div>
                <div class="input-group">
                    <label>ชื่อผู้ใช้งาน</label>
                    <div class="field-container"><i class="fas fa-user"></i><input type="text" id="loginUsername"
                            placeholder="กรอกชื่อผู้ใช้"></div>
                </div>
                <div class="input-group">
                    <label>รหัสผ่าน</label>
                    <div class="field-container"><i class="fas fa-lock"></i><input type="password" id="loginPassword"
                            placeholder="กรอกรหัสผ่าน"></div>
                </div>

                <div
                    style="width:100%; display: flex; justify-content: space-between; margin-bottom: 20px; padding: 0 5px;">
                    <a href="#" onclick="openModal('forgotModal')"
                        style="color:#d4a373; text-decoration:none; font-size: 13px; font-weight:600;">ลืมรหัสผ่าน?</a>
                    <a href="#" onclick="openModal('changePassModal')"
                        style="color:#999; text-decoration:none; font-size: 13px;">เปลี่ยนรหัสผ่าน</a>
                </div>
                <button class="btn-login" onclick="handleLogin()">เข้าสู่ระบบ</button>
                <div class="signup-link">ยังไม่มีบัญชี? <span onclick="showRegister()">สมัครสมาชิกใหม่</span></div>
            </div>
            <!-- 2. ส่วนสมัครสมาชิก -->
            <div class="login-left" id="registerForm" style="display: none;">
                <div class="form-title">สมัครสมาชิกใหม่</div>
                <div class="role-tabs">
                    <button class="tab-btn active" id="regTabTenant" onclick="switchRegRole('TENANT')">ผู้เช่า</button>
                    <button class="tab-btn" id="regTabAdmin" onclick="switchRegRole('ADMIN')">แอดมิน</button>
                </div>
                <!-- อัปโหลดรูปโปรไฟล์ (ซ่อนถ้าเป็นแอดมิน) -->
                <div id="regAvatarSection">
                    <img src="https://i.pravatar.cc/150?u=new" class="avatar-circle" id="regAvatarPrev"
                        onclick="document.getElementById('regAvatarInput').click()">
                    <input type="file" id="regAvatarInput" hidden accept="image/*"
                        onchange="previewAvatar(this, 'regAvatarPrev')">
                    <p class="click-to-change" onclick="document.getElementById('regAvatarInput').click()">
                        คลิกเพื่อเปลี่ยนรูป</p>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; width:100%;">
                    <div class="input-group"><label>ชื่อผู้ใช้</label>
                        <div class="field-container"><i class="fas fa-signature"></i><input type="text" id="regName"
                                placeholder="ระบุชื่อจริง"></div>
                    </div>
                    <div class="input-group" id="regRoomField"><label>เลขห้อง</label>
                        <div class="field-container"><i class="fas fa-door-open"></i><input type="text" id="regRoom"
                                placeholder="เช่น 101"></div>
                    </div>
                    <div class="input-group" id="regEmailField"><label>อีเมล</label>
                        <div class="field-container"><i class="fas fa-envelope"></i><input type="email" id="regEmail"
                                placeholder="ระบุอีเมล"></div>
                    </div>
                    <div class="input-group" id="regPhoneField"><label>เบอร์โทร</label>
                        <div class="field-container"><i class="fas fa-phone"></i><input type="text" id="regPhone"
                                placeholder="ระบุเบอร์โทรศัพท์"></div>
                    </div>
                    <div class="input-group" id="regLineField"><label>ID Line</label>
                        <div class="field-container"><i class="fab fa-line"></i><input type="text" id="regLine"
                                placeholder="ID Line"></div>
                    </div>
                    <div class="input-group"><label>รหัสผ่าน</label>
                        <div class="field-container"><i class="fas fa-key"></i><input type="password" id="regPassword"
                                placeholder="ตั้งรหัสผ่าน"></div>
                    </div>
                </div>

                <button class="btn-login" onclick="handleRegister()">ยืนยันลงทะเบียน</button>
                <div class="signup-link"><span onclick="showLogin()">กลับไปหน้าล็อกอิน</span></div>
            </div>
            <div class="login-right"></div>
        </div>
    </div>
    <!-- Modal: ลืมรหัสผ่าน -->
    <div id="forgotModal" class="modal-overlay">
        <div class="modal-card">
            <h3 style="color:#5d4037;"><i class="fas fa-key" style="color: #ffb703;"></i> กู้คืนรหัสผ่าน</h3>
            <div class="input-group"><label>ชื่อผู้ใช้</label>
                <div class="field-container"><i class="fas fa-user"></i><input type="text" id="forgotUser"
                        placeholder="ชื่อผู้ใช้งาน"></div>
            </div>
            <div class="input-group"><label>เลขห้อง</label>
                <div class="field-container"><i class="fas fa-door-open"></i><input type="text" id="forgotRoom"
                        placeholder="เลขห้อง"></div>
            </div>
            <div class="input-group"><label>รหัสผ่านใหม่</label>
                <div class="field-container"><i class="fas fa-lock"></i><input type="password" id="forgotNewPass"
                        placeholder="รหัสผ่านใหม่"></div>
            </div>
            <div class="btn-row"><button class="btn-cancel" onclick="closeModal('forgotModal')">ยกเลิก</button><button
                    class="btn-confirm" onclick="handleResetPassword()">ตั้งรหัสใหม่</button></div>
        </div>
    </div>
    <!-- Modal: เปลี่ยนรหัสผ่าน -->
    <div id="changePassModal" class="modal-overlay">
        <div class="modal-card">
            <h3 style="color:#5d4037;">เปลี่ยนรหัสผ่าน</h3>
            <div class="input-group"><label>ชื่อผู้ใช้</label>
                <div class="field-container"><i class="fas fa-user"></i><input type="text" id="changeUser"
                        placeholder="ชื่อผู้ใช้งาน"></div>
            </div>
            <div class="input-group"><label>รหัสผ่านเดิม</label>
                <div class="field-container"><i class="fas fa-key"></i><input type="password" id="oldPass"
                        placeholder="รหัสผ่านเดิม"></div>
            </div>
            <div class="input-group"><label>รหัสผ่านใหม่</label>
                <div class="field-container"><i class="fas fa-unlock-alt"></i><input type="password" id="newPass"
                        placeholder="รหัสผ่านใหม่"></div>
            </div>
            <div class="btn-row"><button class="btn-cancel"
                    onclick="closeModal('changePassModal')">ยกเลิก</button><button class="btn-confirm"
                    onclick="handleChangePassword()">อัปเดต</button></div>
        </div>
    </div>
    <script>
        // เริ่มต้น Database (มี Admin เป็นค่าเริ่มต้น)
        if (!localStorage.getItem('cozy_users')) {
            localStorage.setItem('cozy_users', JSON.stringify({
                "admin": { name: "แอดมินนิติ", room: "", pass: "1234", img: "https://i.pravatar.cc/150?u=admin", role: "ADMIN", email: "", phone: "" }
            }));
        }
        let selectedLoginRole = "TENANT";
        let selectedRegRole = "TENANT";
        let tempAvatar = "";
        function switchRole(role) {
            selectedLoginRole = role;
            document.getElementById('tabTenant').classList.toggle('active', role === 'TENANT');
            document.getElementById('tabAdmin').classList.toggle('active', role === 'ADMIN');
            document.getElementById('formTitle').innerText = role === 'TENANT' ? 'เข้าสู่ระบบผู้เช่า' : 'เข้าสู่ระบบผู้ดูแล (Admin)';
        }
        // สลับหน้าสมัครสมาชิก (แอดมินให้กรอกแค่ชื่อ รหัสผ่าน)
        function switchRegRole(role) {
            selectedRegRole = role;
            document.getElementById('regTabTenant').classList.toggle('active', role === 'TENANT');
            document.getElementById('regTabAdmin').classList.toggle('active', role === 'ADMIN');

            const display = role === 'TENANT' ? 'block' : 'none';
            document.getElementById('regAvatarSection').style.display = display;
            document.getElementById('regRoomField').style.display = display;
            document.getElementById('regEmailField').style.display = display;
            document.getElementById('regPhoneField').style.display = display;
            document.getElementById('regLineField').style.display = display;
        }
        function showRegister() { document.getElementById('loginForm').style.display = 'none'; document.getElementById('registerForm').style.display = 'flex'; }
        function showLogin() { document.getElementById('registerForm').style.display = 'none'; document.getElementById('loginForm').style.display = 'flex'; }
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        function previewAvatar(input, prevId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    tempAvatar = e.target.result;
                    document.getElementById(prevId).src = tempAvatar;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        // สมัครสมาชิก (รองรับทั้ง ผู้เช่า และ แอดมิน)
        function handleRegister() {
            const formData = new FormData();
            formData.append("username", document.getElementById('regName').value);
            formData.append("password", document.getElementById('regPassword').value);
            formData.append("role", selectedRegRole);

            formData.append("room", document.getElementById('regRoom').value);
            formData.append("email", document.getElementById('regEmail').value);
            formData.append("phone", document.getElementById('regPhone').value);
            formData.append("line", document.getElementById('regLine').value);
            formData.append("image", tempAvatar);

            fetch("register.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.text())
                .then(res => {
                    if (res === "success") {
                        alert("สมัครสำเร็จ");
                        showLogin();
                    } else if (res === "duplicate") {
                        alert("ชื่อซ้ำ");
                    } else {
                        alert(res);
                    }
                });
        }
        // ล็อกอิน
        function handleLogin() {
            const formData = new FormData();
            formData.append("username", document.getElementById('loginUsername').value);
            formData.append("password", document.getElementById('loginPassword').value);

            fetch("login.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === "success") {
                        if (res.role !== selectedLoginRole) {
                            alert("เลือก role ไม่ถูก");
                            return;
                        }
                        alert("เข้าสู่ระบบสำเร็จ");
                    } else {
                        alert("ผิด");
                    }
                });
        }
        function handleResetPassword() {
            const formData = new FormData();
            formData.append("username", document.getElementById('forgotUser').value);
            formData.append("room", document.getElementById('forgotRoom').value);
            formData.append("newpass", document.getElementById('forgotNewPass').value);

            fetch("reset_password.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.text())
                .then(res => {
                    if (res === "success") {
                        alert("เปลี่ยนสำเร็จ");
                        closeModal('forgotModal');
                    } else alert("ผิด");
                });
        }
        function handleChangePassword() {
            const formData = new FormData();
            formData.append("username", document.getElementById('changeUser').value);
            formData.append("oldpass", document.getElementById('oldPass').value);
            formData.append("newpass", document.getElementById('newPass').value);

            fetch("change_password.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.text())
                .then(res => {
                    if (res === "success") {
                        alert("เปลี่ยนสำเร็จ");
                        closeModal('changePassModal');
                    } else alert("ผิด");
                });
        }
    </script>
</body>

</html>