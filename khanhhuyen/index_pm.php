<?php
require_once __DIR__ . '/../../../../data/connect.php';
require_once __DIR__ . '/../../../../data/repositories/PhieuMuonRepo.php';
require_once __DIR__ . '/../../../../business/services/PhieuMuonService.php';

$database = new Database();
$dbConn = $database->getConnection();
$phieuMuonService = new PhieuMuonService($dbConn);
$phieuMuonRepo = new PhieuMuonRepo($dbConn);

$tu_khoa = isset($_GET['tu_khoa']) ? $_GET['tu_khoa'] : '';
$tinh_trang = isset($_GET['btn_tinhtrang']) ? $_GET['btn_tinhtrang'] : 'all'; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$total_records   = $phieuMuonRepo->countPhieuMuon($tu_khoa, 'all');
$count_pending   = $phieuMuonRepo->countPhieuMuon($tu_khoa, '0'); 
$count_borrowing = $phieuMuonRepo->countPhieuMuon($tu_khoa, '1'); 
$count_returned  = $phieuMuonRepo->countPhieuMuon($tu_khoa, '2'); 
$count_violation = $phieuMuonRepo->countPhieuMuon($tu_khoa, '3'); 
$count_cancelled = $phieuMuonRepo->countPhieuMuon($tu_khoa, '4'); 

$params = [
    'tu_khoa' => $tu_khoa,
    'tinh_trang' => $tinh_trang,
    'page' => $page,
    'limit' => 10
];

$result = $phieuMuonService->getList($params);
$dsPhieuMuon = ($result['status'] === 'success') ? $result['data'] : [];
$total_pages = ($result['status'] === 'success') ? $result['pagination']['total_pages'] : 1;
?>
<head>
    <link rel="stylesheet" href="../../assets/css/ThuThuView/qlpm/tt_tinhtrang.css">
    <link rel="stylesheet" href="../../assets/css/ThuThuView/qlpm/index_pm.css">
</head>

<div class="main-view-container">
    <div class="view-header">
        <h1><i class="fas fa-exchange-alt"></i> Quản lý Mượn - Trả Sách</h1>
        <p>Hệ thống quản lý thông tin phiếu mượn và tình trạng trả sách</p>
    </div>

    <div class="toolbar-card">
        <form method="GET" action="index_tt.php">
            <input type="hidden" name="view" value="muontra">
            <input type="hidden" name="btn_tinhtrang" value="<?= htmlspecialchars($tinh_trang) ?>">
            <div class="toolbar-top">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="tu_khoa" placeholder="Tìm tên độc giả, mã phiếu..." value="<?= htmlspecialchars($tu_khoa) ?>">
                    <button type="submit">Tìm kiếm</button>
                </div>
                <a href="qlpm/add_pm.php" class="btn-add-new">
                    <i class="fas fa-plus"></i> Thêm phiếu mới
                </a>
            </div>
            
            <div class="filter-section">
                <?php include 'qlpm/tt_tinhtrang.php'; ?>
            </div>
        </form>
    </div>

    <div class="table-container-card">
        <div class="table-responsive">
            <?php include 'qlpm/table_pm.php'; ?>
        </div>

        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <a href="index_tt.php?view=muontra&page=1&tu_khoa=<?= urlencode($tu_khoa) ?>&btn_tinhtrang=<?= $tinh_trang ?>" class="<?= ($page <= 1) ? 'disabled' : '' ?>">&laquo;</a>

            <?php 
            
            $start_loop = max(1, $page - 2);
            $end_loop = min($total_pages, $page + 2);
            
            for($i = $start_loop; $i <= $end_loop; $i++): ?>
                <a href="index_tt.php?view=muontra&page=<?= $i ?>&tu_khoa=<?= urlencode($tu_khoa) ?>&btn_tinhtrang=<?= $tinh_trang ?>" 
                class="<?= ($i == $page) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <a href="index_tt.php?view=muontra&page=<?= $total_pages ?>&tu_khoa=<?= urlencode($tu_khoa) ?>&btn_tinhtrang=<?= $tinh_trang ?>" class="<?= ($page >= $total_pages) ? 'disabled' : '' ?>">&raquo;</a>
        </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deletePhieuMuon(maPM) {
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: "Phiếu mượn này sẽ bị xóa vĩnh viễn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Đồng ý xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/hocphp/pttkpm_QLTV moi/business/api/api_PhieuMuon.php?action=delete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'ma_pm=' + encodeURIComponent(maPM)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Thành công', data.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Thất bại', data.message, 'error');
                }
            })
            .catch(err => {
                Swal.fire('Lỗi', 'Không thể kết nối máy chủ. Vui lòng thử lại.', 'error');
            });
        }
    });
}

</script>
