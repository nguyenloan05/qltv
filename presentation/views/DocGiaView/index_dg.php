<?php
// 1. Khởi động session nếu chưa có (để dùng được $_SESSION['user_id'])
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. NHÚNG FILE KẾT NỐI DATABASE VÀO ĐÂY
// Hãy thay đổi đường dẫn dưới đây cho ĐÚNG với file kết nối DB (PDO/MySQLi) trong dự án của bạn
// Ví dụ: nếu file kết nối tên là connect.php nằm ở thư mục config ngoài cùng:
require_once __DIR__ . '/../../../data/connect.php'; 

$db = new Database();
$conn = $db->getConnection();

$user_id = $_SESSION['user_id'] ?? 0;
$sql_profile = "SELECT ho_ten, ma_docgia FROM docgia WHERE user_id = ?";

// Lúc này biến $conn đã tồn tại nhờ file connect.php được nhúng ở trên
$stmt_profile = $conn->prepare($sql_profile); 
$stmt_profile->bind_param("i", $user_id);
$stmt_profile->execute();
$profile = $stmt_profile->get_result()->fetch_assoc();

$ten_dg = $profile['ho_ten'] ?? 'Khách';
$id_dg = $profile['ma_docgia'] ?? 'Chưa có ID';

if (!isset($_SESSION['ma_dg']) || $_SESSION['ma_dg'] === 'DG0001') {
    $_SESSION['ma_dg'] = $id_dg;
}

$view = $_GET['view'] ?? 'trangchu';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giao diện Độc giả | Thư viện ABC</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/menu_dg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    
    <?php if ($view === 'trangchu'): ?>
        <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/TrangChu_Dg.css">
    <?php elseif ($view === 'muonsach'): ?>
        <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/ycMuon.css">
    <?php elseif ($view === 'dattruoc'): ?>
        <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/phieudat/phieudat.css">
    <?php elseif ($view === 'dangkythe'): ?>
        <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/card/docgia_card.css">
    <?php elseif ($view === 'lichsu'): ?>
        <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/lichSuMT.css">
    <?php elseif ($view === 'doimkDocGia'): ?>
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/doimkDocGia.css">
    <?php endif; ?>
    
    <style>

        .user-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 30px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            gap: 15px;
        }
        .user-info-text { text-align: right; }
        .user-info-text strong { display: block; font-size: 14px; color: #2d3748; }
        .user-info-text small { color: #a0aec0; font-size: 12px; }
        .avatar-circle {
            width: 40px; height: 40px; border-radius: 50%;
            background: #e2e8f0; border: 2px solid #4318ff;
            overflow: hidden;
        }
    </style>
</head>
<body style="display: flex; margin: 0; background: #f8f9fa; font-family: 'Segoe UI', sans-serif;">
    
    
    <?php include __DIR__ . '/menu_dg.php'; ?>

    
    <div style="flex: 1; display: flex; flex-direction: column;">

        
        <main style="padding: 25px; min-height: 100vh;">
            <?php 
                switch ($view) {
                    case 'trangchu':
                        
                        include __DIR__ . '/TrangChu_Dg.php';
                        break;
                    case 'chitietsach':
                        include __DIR__ . '/ChiTietSach_dg.php';
                        break;
                    case 'muonsach':
                        include __DIR__ . '/ycMuon.php';
                        break;
                    case 'dattruoc':
                        include __DIR__ . '/phieudat/phieudat.php';
                        break;
                    case 'dangkythe':
                        include __DIR__ . '/dangkythe.php';
                        break;
                    case 'lichsu':
                        include __DIR__ . '/lichSuMT.php';
                        break;
                    case 'taikhoan':
                        include __DIR__ . '/CanhanDG.php';
                        break;
                    case 'suaThongTinDG':
                        include __DIR__ . '/suaThongTinDG.php';
                        break;
                    case 'doimkDocGia':
                        include __DIR__ . '/doimkDocGia.php';
                        break;
                    default:
                        echo "<h2>Trang đang cập nhật</h2>";
                        break;
                }
            ?>
        </main>
    </div>

</body>
</html>
