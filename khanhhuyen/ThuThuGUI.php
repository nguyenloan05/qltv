<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

$sql_top = "SELECT s.ten_sach, tg.ten_tg, s.image, COUNT(pm.ma_pm) as luot 
            FROM sach s 
            LEFT JOIN phieu_muon pm ON s.ma_sach = pm.ma_sach 
            LEFT JOIN tac_gia tg ON s.ma_tg = tg.ma_tg
            GROUP BY s.ma_sach 
            ORDER BY luot DESC LIMIT 10";
$result_top = mysqli_query($conn, $sql_top);
?>

<div class="thuthu-dashboard">
    <div class="mb-4">
        <h4 class="fw-bold">Bảng điều khiển</h4>
        <p class="text-muted">Xin chào, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Thủ thư'); ?></p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="bg-white p-4 rounded-3 border h-100">
                <h6 class="fw-bold fs-5 mb-4 text-primary"><i class="fas fa-crown me-2"></i>Top sách mượn nhiều</h6>
                <div class="mt-3 row g-4">
                <?php if($result_top && mysqli_num_rows($result_top) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result_top)): 
                        $img_path = "/hocphp/pttkpm_QLTV moi/presentation/assets/images/" . $row['image'];
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex align-items-center p-3 border rounded-3 shadow-sm h-100 bg-light">
                            <img src="<?php echo $row['image'] ? $img_path : 'https://via.placeholder.com/60x80'; ?>" class="me-3 rounded shadow-sm" style="width: 60px; height: 80px; object-fit: cover;" alt="Book">
                            <div class="small">
                                <div class="fw-bold text-dark mb-1" style="font-size: 15px;"><?php echo htmlspecialchars($row['ten_sach']); ?></div>
                                <?php if ($row['ten_tg']): ?>
                                    <div class="text-secondary mb-1"><i class="fas fa-user-edit me-1"></i><?php echo htmlspecialchars($row['ten_tg']); ?></div>
                                <?php endif; ?>
                                <div class="text-primary fw-bold"><i class="fas fa-chart-line me-1"></i><?php echo $row['luot']; ?> lượt mượn</div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted small">Chưa có dữ liệu</p>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

