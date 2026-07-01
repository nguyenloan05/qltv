<?php

require_once __DIR__ . '/../../../../data/connect.php';
require_once __DIR__ . '/../../../../data/repositories/ViPhamRepo.php';
require_once __DIR__ . '/../../../../business/services/ViPhamService.php';

$db = (new Database())->getConnection();
$repo = new ViPhamRepo($db);
$service = new ViPhamService($repo);

$ma_pm_auto = $_GET['ma_pm'] ?? '';
$ketqua = $service->tinhToanViPham($ma_pm_auto);
$info = $ketqua['data'];
$so_ngay_tre = $ketqua['so_ngay_tre'] ?? 0;
$tien_phat_tre = $ketqua['tien_phat_tre'] ?? 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lập Biên Bản Vi Phạm</title>
    
    <link rel="stylesheet" href="../../../assets/css/ThuThuView/menu_tt.css">
    <link rel="stylesheet" href="../../../assets/css/ThuThuView/qlvp/add_vp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="display: flex; margin: 0; background: #f4f7f6; font-family: 'Inter', sans-serif;">

    
    <?php include '../menu_tt.php'; ?>

    <div class="content-wrapper" style="flex: 1; padding: 20px;">
        <div class="form-card">
            <div class="form-header">
                <h2><i class="fas fa-exclamation-triangle"></i> Lập Biên Bản Vi Phạm</h2>
            </div>

            <div class="form-body">
                
                <div style="background: #fff5f5; border-radius: 8px; padding: 15px; margin-bottom: 25px; border-left: 4px solid #e74c3c;">
                    <p style="margin: 5px 0; font-size: 14px;">
                        <strong>Độc giả:</strong> <?= htmlspecialchars($info['ho_ten'] ?? 'N/A') ?> 
                        <span style="color: #7f8c8d;">(MS: <?= htmlspecialchars($info['ma_docgia'] ?? 'N/A') ?>)</span>
                    </p>
                    <p style="margin: 5px 0; font-size: 14px;">
                        <strong>Sách:</strong> <?= htmlspecialchars($info['ten_sach'] ?? 'N/A') ?>
                    </p>
                </div>

                <form action="../../../../business/api/api_vp.php?action=create" method="POST">
                    
                    <input type="hidden" name="ma_docgia" value="<?= htmlspecialchars($info['ma_docgia'] ?? '') ?>">
                    
                    <div class="form-group">
                        <label>Mã Phiếu Mượn</label>
                        <input type="text" name="ma_pm" value="<?= htmlspecialchars($ma_pm_auto) ?>" readonly class="readonly-bg">
                    </div>

                    <div class="form-group">
                        <label>Lý do vi phạm</label>
                        <select name="ly_do" id="ly_do" required>
                            <option value="Trả sách quá hạn" <?= ($so_ngay_tre > 0) ? 'selected' : '' ?>>Trả sách quá hạn</option>
                            <option value="Làm hỏng sách">Làm hỏng sách</option>
                            <option value="Làm mất sách">Làm mất sách</option>
                            <option value="Khác">Vi phạm khác</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tiền phạt hư hại/mất (VNĐ)</label>
                        <input type="number" name="tien_phat_them" id="tien_hong" value="0" min="0" placeholder="Nhập số tiền nếu có...">
                    </div>

                    <div class="form-group">
                        <label>Tổng tiền phạt hiện tại</label>
                        <input type="number" name="tong_tien_phat" id="tong_tien" value="<?= $tien_phat_tre ?>" readonly>
                        <p id="label_chi_tiet" style="font-size: 12px; color: #e74c3c; margin-top: 8px;">
                            * Trễ <?= $so_ngay_tre ?> ngày: <?= number_format($tien_phat_tre) ?> VNĐ
                        </p>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Lưu Biên Bản
                    </button>
                    
                    <a href="../index_tt.php?view=muontra" class="back-link">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Logic tính toán động
        const tienPhatGoc = <?= (int)$tien_phat_tre ?>;
        const inputHong = document.getElementById('tien_hong');
        const inputTong = document.getElementById('tong_tien');
        const labelChiTiet = document.getElementById('label_chi_tiet');

        inputHong.addEventListener('input', function() {
            let phatSinh = parseInt(this.value) || 0;
            let tongMoi = tienPhatGoc + phatSinh;
            inputTong.value = tongMoi;
            labelChiTiet.innerText = `* Trễ hạn: ${tienPhatGoc.toLocaleString()}đ + Phát sinh: ${phatSinh.toLocaleString()}đ`;
        });
    </script>
</body>
</html>