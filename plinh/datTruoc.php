<?php


require_once __DIR__ . '/../../../business/services/thuthu/PhieuDatService.php';
$pdService = new PhieuDatService();
$allPd = $pdService->getAll();
$ma_dg = $_SESSION['ma_dg'];

$myReservations = array_filter($allPd, function($item) use ($ma_dg) {
    return $item['ma_docgia'] === $ma_dg;
});

$statusMap = [
    0 => ['label' => 'Đang chờ duyệt', 'class' => 'bg-warning text-dark'],
    1 => ['label' => 'Đã duyệt (Vui lòng đến lấy sách)', 'class' => 'bg-info text-dark'],
    2 => ['label' => 'Đã nhận sách', 'class' => 'bg-success'],
    3 => ['label' => 'Đã bị hủy', 'class' => 'bg-danger']
];
?>

<div class="my-reservations">
    <div class="header mb-4">
        <h2><i class="fas fa-clock me-2"></i> Danh sách đặt trước</h2>
        <p class="text-muted">Theo dõi các yêu cầu đặt sách trước của bạn</p>
    </div>

    <?php if (empty($myReservations)): ?>
        <div class="text-center p-5 bg-white rounded-3 shadow-sm">
            <i class="fas fa-calendar-times fa-4x text-light mb-3"></i>
            <p class="text-muted">Bạn chưa có yêu cầu đặt trước nào.</p>
            <a href="index.php?action=trangchu_sv&view=muonsach" class="btn btn-primary">Đặt sách ngay</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($myReservations as $pd): ?>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body">
                            <div class="d-flex gap-3">
                                <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/<?= htmlspecialchars($pd['image']) ?>" 
                                     class="rounded" style="width: 80px; height: 110px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="badge <?= $statusMap[$pd['trang_thai']]['class'] ?> mb-2">
                                        <?= $statusMap[$pd['trang_thai']]['label'] ?>
                                    </div>
                                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($pd['ten_sach']) ?></h5>
                                    <div class="small text-muted mb-2">Ngày đặt: <?= date('d/m/Y', strtotime($pd['ngay_dat'])) ?></div>
                                    
                                    <?php if ($pd['trang_thai'] == 1 && $pd['han_lay_sach']): ?>
                                        <div class="alert alert-warning py-2 px-3 small mb-0">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            Hạn lấy sách: <strong><?= date('d/m/Y', strtotime($pd['han_lay_sach'])) ?></strong>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

