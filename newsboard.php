<div id="postModal" class="modal">
    <div class="modal-content">
        <h2>สร้างประกาศใหม่</h2>
        <form id="postForm">
            <input type="text" id="postTitleInp" name="title" placeholder="หัวข้อประกาศ" required>
            <textarea id="postDescInp" name="description" placeholder="รายละเอียด..." rows="5" required></textarea>
            
            <div class="file-upload">
                <input type="file" id="fileInput" name="image" accept="image/*" onchange="handleImgPreview(this)">
                <img id="previewImg" style="display:none; width:100%; margin-top:10px; border-radius:8px;">
            </div>
            
            <div class="modal-btns">
                <button type="button" onclick="closeModal('postModal')">ยกเลิก</button>
                <button type="button" onclick="submitPost()" class="primary-btn">โพสต์ประกาศ</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 2. ฟังก์ชันดึงข้อมูล (GET)
    async function loadPosts() {
        try {
            const response = await fetch('get_posts.php'); 
            const posts = await response.json();
            const feedArea = document.getElementById('feedArea');
            feedArea.innerHTML = ''; 

            if (posts.length === 0) {
                feedArea.innerHTML = '<p style="text-align:center; color:#888; margin-top:20px;">ยังไม่มีประกาศในขณะนี้</p>';
                return;
            }

            posts.forEach(post => {
                const html = `
                    <article class="post-card">
                        <div class="post-header">
                            <img src="https://i.pravatar.cc/150?u=admin" class="author-img">
                            <div class="post-info">
                                <b>แอดมินนิติ</b>
                                <span class="post-time">${post.created_at}</span>
                            </div>
                        </div>
                        <div class="post-content">
                            <h3>${post.title}</h3>
                            <p>${post.description}</p>
                            ${post.image_path ? `<img src="${post.image_path}" class="post-main-img">` : ''}
                        </div>
                    </article>`;
                feedArea.insertAdjacentHTML('beforeend', html);
            });
        } catch (e) { console.error("Load Error:", e); }
    }

    // 3. ฟังก์ชันส่งข้อมูล (POST) - ปรับปรุงให้ดึงค่าจากฟอร์มโดยตรง
    async function submitPost() {
        const form = document.getElementById('postForm');
        const titleVal = document.getElementById('postTitleInp').value;
        const descVal = document.getElementById('postDescInp').value;
        
        if(!titleVal || !descVal) {
            alert("กรุณากรอกหัวข้อและรายละเอียดให้ครบถ้วน");
            return;
        }

        // ดึงข้อมูลทั้งหมดใน Form (title, description, image) ตาม name ที่เราตั้งไว้
        let formData = new FormData(form);

        try {
            const response = await fetch('save_post.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if(result.status === "success") {
                alert("บันทึกประกาศเรียบร้อยแล้ว!");
                closeModal('postModal'); 
                loadPosts(); // โหลดข้อมูลใหม่มาแสดงทันที
            } else {
                alert("ผิดพลาด: " + result.message);
            }
        } catch (e) { 
            console.error("Submit Error:", e);
            alert("ไม่สามารถติดต่อเซิร์ฟเวอร์ได้"); 
        }
    }

    // --- ส่วน UI อื่นๆ ---
    function openCreatePostModal() { document.getElementById('postModal').style.display = 'flex'; }
    
    function closeModal(id) { 
        document.getElementById(id).style.display = 'none'; 
        document.getElementById('postForm').reset();
        document.getElementById('previewImg').style.display = 'none';
    }

    function handleImgPreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const prev = document.getElementById('previewImg');
                prev.src = e.target.result; 
                prev.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    window.onload = loadPosts;
</script>