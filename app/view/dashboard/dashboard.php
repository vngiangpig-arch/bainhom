<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body class="dashboard-body">

    <div class="sidebar">
        <div class="sidebar-header">
            <h3>⚙️ Admin</h3>
        </div>
        <ul class="sidebar-menu">
    <li><a data-target="home" class="menu-link active">🏠 Trang Chủ</a></li>
    <li><a href="index.php?page=user" target="content-frame" class="menu-link">👥 Quản lý User</a></li>
    <li><a href="index.php?page=plan" target="content-frame" class="menu-link">💎 Quản lý Gói</a></li>
    <li><a href="index.php?page=bank" target="content-frame" class="menu-link">🏦 Quản lý Ngân hàng</a></li>
    <li><a href="index.php?page=historybank" target="content-frame" class="menu-link">💵 Lịch sử Nạp tiền</a></li>
    <li><a href="index.php?page=historyplan" target="content-frame" class="menu-link">📜 Lịch sử Thuê Gói</a></li>
</ul>
    </div>

    <div class="main-content">
        
        <div id="home-content">
            <div class="welcome-box">
                <h2>👋 Chào mừng Admin!</h2>
                <p>Đây là khu vực quản trị hệ thống</p>
            </div>
        </div>

        <iframe name="content-frame" id="content-frame"></iframe>

    </div>

    <script>
        const menuLinks = document.querySelectorAll('.menu-link');
        const homeContent = document.getElementById('home-content');
        const contentFrame = document.getElementById('content-frame');

        menuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                menuLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                if (this.dataset.target === 'home') {
                    e.preventDefault();
                    homeContent.style.display = 'block'; 
                    contentFrame.style.display = 'none'; 
                } else {
                    homeContent.style.display = 'none'; 
                    contentFrame.style.display = 'block'; 
                }
            });
        });
    </script>
</body>
</html>