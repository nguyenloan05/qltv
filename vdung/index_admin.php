<?php

$view = $_GET['view'] ?? 'tongquan';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng điều khiển Admin | Thư viện ABC</title>
    
    <link rel="stylesheet" href="presentation/assets/css/AdminView/menu_admin.css">
    <link rel="stylesheet" href="presentation/assets/css/AdminView/AdminGUI.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="display: flex; margin: 0; background: #f4f7f6; font-family: 'Segoe UI', sans-serif;">
    
    
    <?php include __DIR__ . '/menu_admin.php'; ?>

    <main style="flex: 1; padding: 30px; min-height: 100vh;">
        <?php 
            switch ($view) {
                case 'tongquan':
                    echo '<div class="content-card">';
                    
                    include __DIR__ . '/AdminGUI.php';
                    echo '</div>';
                    break;
                case 'thuthu':
                    echo '<div class="content-card">';
                    include __DIR__ . '/ThuThu.php';
                    echo '</div>';
                    break;
                case 'docgia':
                    echo '<div class="content-card">';
                    include __DIR__ . '/DocGia.php';
                    echo '</div>';
                    break;
                case 'phanquyen':
                    echo '<div class="content-card">';
                    include __DIR__ . '/admin_pq.php';
                    echo '</div>';
                    break;
                case 'chinhsach':
                    echo '<div class="content-card">';
                    include __DIR__ . '/cauhinh_ht.php';
                    echo '</div>';
                    break;
                case 'thongbao':
                    echo '<div class="content-card">';
                    include __DIR__ . '/admin_tb.php';
                    echo '</div>';
                    break;
                case 'updateThuThu':
                    echo '<div class="content-card">';
                    include __DIR__ . '/updateThuThu.php';
                    echo '</div>';
                    break;
                case 'addDocGia':
                    echo '<div class="content-card">';
                    include __DIR__ . '/addDocGia.php';
                    echo '</div>';
                    break;
                case 'updateDocGia':
                    echo '<div class="content-card">';
                    include __DIR__ . '/updateDocGia.php';
                    echo '</div>';
                    break;
                default:
                    echo "<h2>Trang không tồn tại</h2>";
                    break;
            }
        ?>
    </main>
</body>
</html>