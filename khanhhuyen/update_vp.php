<?php
require_once __DIR__ . '/../../../../data/connect.php';
require_once __DIR__ . '/../../../../data/repositories/ViPhamRepo.php';

$db = (new Database())->getConnection();
$repo = new ViPhamRepo($db);

$ma_vp = $_GET['ma_vp'] ?? '';


$sql = "SELECT vp.*, dg.ho_ten, dg.ma_docgia as ma_sv 
        FROM vipham vp 
        JOIN docgia dg ON vp.ma_docgia = dg.ma_docgia 
        WHERE vp.ma_vp = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $ma_vp);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "<script>alert('Không tìm thấy bản ghi!'); window.location.href='../index_tt.php?view=qlvp';</script>";
    exit();
}


$tien_tre_bandau = $data['tong_tien_phat'] - $data['tien_phat_them'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập Nhật Vi Phạm</title>
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/menu_tt.css">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/qlvp/update_vp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="layout-container">
    <?php include __DIR__ . '/../menu_tt.php'; ?>
    <main class="main-content">
    <div class="update-vp-container">
        
        <div class="form-card">
            <div class="form-header">
                <h2><i class="fas fa-edit"></i> Chỉnh Sửa Biên Bản #<?= htmlspecialchars($ma_vp) ?></h2>
            </div>
            
            <form action="../../../../business/api/api_vp.php?action=update&id=<?= $ma_vp ?>" method="POST" class="form-body">
                <input type="hidden" name="ma_vp" value="<?= $ma_vp ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Mã phiếu mượn</label>
                        <input type="text" value="<?= $data['ma_pm'] ?>" class="readonly-input" readonly>
                    </div>
                    <div class="form-group">
                        <label>Độc giả</label>
                        <input type="text" value="<?= htmlspecialchars($data['ho_ten']) ?> (<?= $data['ma_sv'] ?>)" class="readonly-input" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label>Lý do vi phạm</label>
                    <textarea name="ly_do" required rows="2"><?= htmlspecialchars($data['ly_do']) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tiền phạt trễ hạn</label>
                        <input type="number" id="tien_tre" value="<?= $tien_tre_bandau ?>" class="readonly-input" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tiền phạt thêm (Hư hỏng...)</label>
                        <input type="number" name="tien_phat_them" id="tien_hong" value="<?= $data['tien_phat_them'] ?>" oninput="tinhTongPhat()">
                    </div>
                </div>

                <div class="form-group">
                    <label>Trạng thái thanh toán</label>
                    <select name="trang_thai">
                        <option value="0" <?= $data['trang_thai'] == '0' ? 'selected' : '' ?>>Chưa thanh toán</option>
                        <option value="1" <?= $data['trang_thai'] == '1' ? 'selected' : '' ?>>Đã thanh toán</option>
                    </select>
                </div>

                <div class="total-section">
                    <label>Tổng tiền phạt cần nộp (VNĐ)</label>
                    <input type="number" name="tong_tien_phat" id="tong_tien" value="<?= $data['tong_tien_phat'] ?>" readonly>
                    <p id="ghi_chu_cong" class="helper-text"></p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Lưu Thay Đổi</button>
                    <a href="../index_tt.php?view=qlvp" class="btn-cancel">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
    </main>

    <script>
        function tinhTongPhat() {
            const tienTre = parseInt(document.getElementById('tien_tre').value) || 0;
            const tienHong = parseInt(document.getElementById('tien_hong').value) || 0;
            const tong = tienTre + tienHong;
            
            document.getElementById('tong_tien').value = tong;
            
            const ghiChu = document.getElementById('ghi_chu_cong');
            ghiChu.innerHTML = `<i class="fas fa-calculator"></i> Chi tiết: ${tienTre.toLocaleString()}đ + ${tienHong.toLocaleString()}đ = <strong>${tong.toLocaleString()} VNĐ</strong>`;
        }
        document.addEventListener('DOMContentLoaded', tinhTongPhat);
    </script>
</body>
</html>
