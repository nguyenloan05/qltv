<?php
ob_start();
require_once __DIR__ . '/../../../data/connect.php';

$view = $_GET['view'] ?? 'trangchu';

$tu_khoa = $_GET['tu_khoa'] ?? '';
$page = $_GET['page'] ?? 1;
$tinh_trang = 'all';

$status_config = [
    0 => ['label' => 'Đang mượn', 'color' => '#3498db', 'icon' => 'fa-clock'],
    1 => ['label' => 'Quá hạn', 'color' => '#e74c3c', 'icon' => 'fa-exclamation-circle'],
    2 => ['label' => 'Chờ vi phạm', 'color' => '#f39c12', 'icon' => 'fa-gavel'],
    3 => ['label' => 'Hoàn thành', 'color' => '#2ecc71', 'icon' => 'fa-check-double']
];

$msg_config = [
    'success'         => ['text' => 'Thao tác thành công!', 'icon' => 'fa-check-circle', 'class' => 'msg-success'],
    'error'           => ['text' => 'Đã có lỗi xảy ra!', 'icon' => 'fa-times-circle', 'class' => 'msg-error'],
    'error_overdue'   => ['text' => 'CHẶN: Sinh viên này đang có sách quá hạn chưa trả!', 'icon' => 'fa-ban', 'class' => 'msg-danger'],
    'error_unpaid'    => ['text' => 'CHẶN: Sinh viên còn nợ tiền phạt chưa thanh toán!', 'icon' => 'fa-hand-holding-usd', 'class' => 'msg-danger'],
    'limit_exceeded'  => ['text' => 'CHẶN: Sinh viên đã mượn tối đa 5 quyển!', 'icon' => 'fa-exclamation-triangle', 'class' => 'msg-warning'],
    'updated'         => ['text' => 'Cập nhật trạng thái thành công!', 'icon' => 'fa-edit', 'class' => 'msg-success'],

    'error_not_completed' => ['text' => 'CHẶN XÓA: Phiếu mượn chưa hoàn thành (sinh viên chưa trả sách)!', 'icon' => 'fa-lock', 'class' => 'msg-danger'],
    'error_has_unpaid_debt' => ['text' => 'CHẶN XÓA: Phiếu này còn khoản nợ phạt chưa thanh toán!', 'icon' => 'fa-dollar-sign', 'class' => 'msg-danger'],
    'error_system'        => ['text' => 'Lỗi hệ thống: Không thể xóa dữ liệu liên kết!', 'icon' => 'fa-bug', 'class' => 'msg-error'],
    'not_found'           => ['text' => 'Không tìm thấy phiếu mượn để xóa!', 'icon' => 'fa-search', 'class' => 'msg-warning'],
];


?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hệ thống Thủ thư | Quản lý Mượn Trả</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/menu_tt.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/index_tt.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/ThuThuGUI.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/TheLoai.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/TacGia.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/Sach.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/card/index_card.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/phieudat/index_phieudat.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="margin: 0; background: #f8f9fa; font-family: 'Be Vietnam Pro', 'Segoe UI', sans-serif;">

    <?php include 'menu_tt.php'; ?>

    <div style="margin-left: 260px;">
        <main style="padding: 25px; min-height: 100vh;">
        <?php if (isset($_GET['msg']) && isset($msg_config[$_GET['msg']])):
            $m = $msg_config[$_GET['msg']]; ?>
            <div class="alert <?= $m['class'] ?>" style="padding: 15px; margin-bottom: 20px; border-radius: 8px; display: flex; align-items: center; gap: 10px; border: 1px solid currentColor;">
                <i class="fas <?= $m['icon'] ?>"></i>
                <div>
                    <strong>Thông báo:</strong>
                    <?= $m['text'] ?>
                    <?php if ($_GET['msg'] == 'limit_exceeded' && isset($_GET['current'])): ?>
                        <br><small>(Số lượng sách đang giữ: <?= (int)$_GET['current'] ?> quyển)</small>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($view === 'trangchu'): ?>
            <?php include 'ThuThuGUI.php'; ?>
        <?php elseif ($view === 'tacgia' || $view === 'TacGiaAPI'): ?>
            <?php include 'TacGia.php'; ?>
        <?php elseif ($view === 'TacGia_Them'): ?>
            <?php include 'TacGia_Them.php'; ?>
        <?php elseif ($view === 'TacGia_Sua'): ?>
            <?php include 'TacGia_Sua.php'; ?>
        <?php elseif ($view === 'theloai' || $view === 'TheLoaiAPI'): ?>
            <?php include 'TheLoai.php'; ?>
        <?php elseif ($view === 'TheLoai_Them'): ?>
            <?php include 'TheLoai_Them.php'; ?>
        <?php elseif ($view === 'TheLoai_Sua'): ?>
            <?php include 'TheLoai_Sua.php'; ?>
        <?php elseif ($view === 'sach' || $view === 'SachAPI'): ?>
            <?php include 'Sach.php'; ?>
        <?php elseif ($view === 'Sach_Them'): ?>
            <?php include 'Sach_Them.php'; ?>
        <?php elseif ($view === 'Sach_Sua'): ?>
            <?php include 'Sach_Sua.php'; ?>


        <?php elseif ($view === 'muontra'): ?>
            <?php include __DIR__ . '/qlpm/index_pm.php'; ?>

        <?php elseif ($view === 'add_pm'): ?>
            <?php include __DIR__ . '/qlpm/add_pm.php'; ?>

        <?php elseif ($view === 'update_pm'): ?>
            <?php include __DIR__ . '/qlpm/update_pm.php'; ?>


            <div style="background: white; padding: 15px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">

                <?php if (isset($total_pages) && $total_pages > 1): ?>
                    <div style="margin-top: 20px; display: flex; justify-content: center; gap: 5px;">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="index_tt.php?view=muontra&page=<?= $i ?>&tu_khoa=<?= urlencode($tu_khoa) ?>&btn_tinhtrang=<?= $tinh_trang ?>"
                                style="padding: 8px 15px; border-radius: 5px; text-decoration: none; border: 1px solid #ddd; <?= ($i == $page) ? 'background:#3498db; color:white;' : 'color:#333;' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($view === 'qlvp'): ?>
            <div class="qlvp-container">
                <?php include 'qlvp/index_vp.php'; ?>
            </div>
        <?php elseif ($view === 'quanlythe'): ?>
            <?php include __DIR__ . '/card/index_card.php'; ?>
        <?php elseif ($view === 'card_detail'): ?>
            <?php include __DIR__ . '/card/card_detail.php'; ?>
        <?php elseif ($view === 'phieudattruoc'): ?>
            <?php include __DIR__ . '/phieudat/index_phieudat.php'; ?>
        <?php elseif ($view === 'quanlytaikhoan'): ?>
            <?php include __DIR__ . '/taikhoan_tt.php'; ?>
        <?php endif; ?>
        </main>
    </div>
</body>

</html>
