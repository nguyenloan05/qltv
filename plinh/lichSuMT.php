<?php
require_once __DIR__ . '/../../../data/connect.php';
require_once __DIR__ . '/../../../data/repositories/PhieuMuonRepo.php';
require_once __DIR__ . '/../../../business/services/PhieuMuonService.php';
require_once __DIR__ . '/../../../data/repositories/ViPhamRepo.php';

$database = new Database();
$conn = $database->getConnection();
$service = new PhieuMuonService($conn);
$viPhamRepo = new ViPhamRepo($conn);


$ma_docgia = $id_dg ?? $_SESSION['ma_docgia'] ?? null;

$lich_su = [];
if ($ma_docgia) {
    
    $params = [
        'tu_khoa' => $ma_docgia,
        'tinh_trang' => 'all',
        'page' => 1,
        'limit' => 50
    ];
    $result = $service->getList($params);
    if ($result['status'] === 'success') {
        $lich_su = $result['data'];
    }
}
?>

<link rel="stylesheet" href="presentation/assets/css/DocGiaView/lichSuMT.css">

<div class="lichsu-container">
    <h2><i class="fas fa-history"></i> Lịch sử mượn trả sách</h2>
    <p class="subtitle">Danh sách các phiếu mượn và trạng thái trả sách của bạn</p>

    <div class="lichsu-table-wrapper">
        <table class="lichsu-table">
            <thead>
                <tr>
                    <th>Mã PM</th>
                    <th>Tên sách</th>
                    <th>Ngày mượn</th>
                    <th>Hạn trả</th>
                    <th>Ngày trả</th>
                    <th>Trạng thái</th>
                    <th>Số lượng</th>
                    <th>Vi phạm</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lich_su)): ?>
                    <?php foreach ($lich_su as $pm): ?>
                        <tr>
                            <td><?= htmlspecialchars($pm['ma_pm']) ?></td>
                            <td><?= htmlspecialchars($pm['ten_sach']) ?></td>
                            <td><?= htmlspecialchars($pm['ngay_muon']) ?></td>
                            <td><?= htmlspecialchars($pm['ngay_tra_du_kien']) ?></td>
                            <td><?= !empty($pm['ngay_tra_thuc_te']) ? htmlspecialchars($pm['ngay_tra_thuc_te']) : '---' ?></td>

                            <td>
                                <span class="status status-<?= $pm['tinh_trang'] ?>">
                                    <?php
                                    $labels = [
                                        0 => "Chờ duyệt",
                                        1 => "Đang mượn",
                                        2 => "Đã trả",
                                        3 => "Vi phạm",
                                        4 => "Đã hủy"
                                    ];
                                    echo $labels[$pm['tinh_trang']] ?? "Không xác định";
                                    ?>
                                </span>
                            </td>
                            <td><?= $pm['so_luong'] ?></td>
                            <td>
                                <?php 
                                $vpList = $viPhamRepo->getViPhamByPhieuMuon($pm['ma_pm']);
                                if (!empty($vpList)) {
                                    foreach ($vpList as $vp) {
                                        echo "<div class='vp-item'>";
                                        echo "<strong>Lý do:</strong> ".htmlspecialchars($vp['ly_do'])."<br>";
                                        echo "<strong>Tổng phạt:</strong> ".number_format($vp['tong_tien_phat'],0,',','.')." đ<br>";
                                        echo "<strong>Trạng thái:</strong> ".($vp['trang_thai']==0 ? "Chưa thanh toán" : "Đã thanh toán");
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<span class='no-vp'>Không có vi phạm</span>";
                                }
                                ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="empty-msg">
                            <i class="fas fa-folder-open"></i> Bạn chưa có lịch sử mượn trả nào
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
