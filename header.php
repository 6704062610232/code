<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Cozy Home"; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            /* ชุดสีจากโค้ดของคุณ */
            --c1: #CCD5AE; --c2: #E9EDC9; --c3: #FEFAE0; --c4: #FAEDCD; --c5: #D4A373;
            --white: #ffffff; --text: #444; --danger: #e74c3c; --bg-light: #f6f5f2;
            --sidebar-width: 250px;
        }
        * { font-family: 'Sarabun', sans-serif; box-sizing: border-box; }
        body { margin: 0; background-color: var(--bg-light); color: var(--text); display: flex; min-height: 100vh; }

        /* Layout หลัก */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            margin-top: 60px; /* เว้นที่ให้ Navbar */
            width: calc(100% - var(--sidebar-width));
        }

        /* สไตล์ตาราง/การ์ด ที่ใช้ร่วมกัน */
        .main-card {
            background: white; border-radius: 15px; padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .btn-brown { 
            background: var(--c5); color: white; border: none; 
            padding: 10px 20px; border-radius: 8px; cursor: pointer; 
            font-weight: 600; transition: 0.3s;
        }
        .btn-brown:hover { opacity: 0.9; transform: translateY(-2px); }
    </style>
</head>