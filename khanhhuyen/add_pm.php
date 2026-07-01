<?php

require_once __DIR__ . '/../../../../data/connect.php';
require_once __DIR__ . '/../../../../data/repositories/PhieuMuonRepo.php';
require_once __DIR__ . '/../../../../business/services/PhieuMuonService.php';


$database = new Database();
$conn = $database->getConnection();


$phieuMuonService = new PhieuMuonService($conn);
$formData = $phieuMuonService->formData();

$res_dg = $formData['list_docgia']; 
$res_sach = $formData['list_sach'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Phiếu Mượn | Hệ thống Thủ thư</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../assets/css/ThuThuView/menu_tt.css">
    <link rel="stylesheet" href="../../../assets/css/ThuThuView/qlpm/add_pm.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="display: flex; margin: 0; background: #f4f7f6; font-family: 'Segoe UI', sans-serif;">

    <?php include '../menu_tt.php'; ?>

    <main class="main-content" style="flex: 1; padding: 20px;">
        <div class="add-form-container">
            <div class="form-header">
                <i class="fas fa-layer-group"></i>
                <h2>Tạo Phiếu Mượn Mới</h2>
                <p>Nhập thông tin độc giả và sách mượn</p>
            </div>

            
            <form id="formAddPhieuMuon">
                
                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Độc giả mượn:</label>
                    <input list="ds_docgia" name="ma_docgia" class="form-control" placeholder="Chọn hoặc gõ mã/tên độc giả..." required>
                    <datalist id="ds_docgia">
                        <?php while($row = mysqli_fetch_assoc($res_dg)): ?>
                            <option value="<?= $row['ma_docgia'] ?>"><?= htmlspecialchars($row['ho_ten']) ?></option>
                        <?php endwhile; ?>
                    </datalist>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-book"></i> Sách mượn:</label>
                    <input list="ds_sach" name="ma_sach" class="form-control" placeholder="Chọn hoặc gõ tên sách..." required>
                    <datalist id="ds_sach">
                        <?php while($row = mysqli_fetch_assoc($res_sach)): ?>
                            <?php 
                                
                                $display_text = htmlspecialchars($row['ten_sach']) . " (Còn: " . $row['so_luong_hien_tai'] . ")";
                            ?>
                            <option value="<?= $row['ma_sach'] ?>"><?= $display_text ?></option>
                        <?php endwhile; ?>
                    </datalist>
                </div>

                <div class="form-row" style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label><i class="fas fa-sort-numeric-up"></i> Số lượng:</label>
                        <input type="number" name="so_luong" id="so_luong" min="1" max="5" value="1" class="form-control" oninput="updatePhi()">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label><i class="fas fa-calendar-alt"></i> Ngày mượn:</label>
                        <input type="date" name="ngay_muon" id="ngay_muon" value="<?= date('Y-m-d') ?>" class="form-control" onchange="updateHan()">
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-clock"></i> Hạn trả dự kiến (+15 ngày):</label>
                    <input type="date" name="ngay_tra_dk" id="ngay_tra_dk" readonly class="form-control" style="background-color: #e9ecef;">
                </div>

                <div class="form-row" style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label><i class="fas fa-handshake"></i> Hình thức:</label>
                    <select name="hinh_thuc" id="hinh_thuc" class="form-control" onchange="toggleStatus()">
                        <option value="1">Tại quầy</option>
                        <option value="0">Online</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label><i class="fas fa-info-circle"></i> Trạng thái:</label>
                    <select name="tinh_trang" id="tinh_trang" class="form-control">
                        <option value="1">Đang mượn</option>
                        <option value="0">Chờ duyệt</option>
                        <option value="2">Đã trả</option>
                        <option value="3">Chờ xử lý vi phạm</option>
                        <option value="4">Hủy</option>
                    </select>
                </div>
            </div>

                <div class="fee-info-box" style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
                    <div class="fee-label">Phí mượn tạm tính:</div>
                    <div class="fee-amount" style="font-size: 1.5rem; font-weight: bold; color: #007bff;"><span id="hien_phi">3,000</span> VNĐ</div>
                    <input type="hidden" name="phi_muon" id="phi_muon" value="3000">
                </div>

                <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <a href="../index_tt.php?view=muontra" class="btn-cancel" style="padding: 10px 20px; border: 1px solid #ccc; text-decoration: none; border-radius: 5px; color: #333;">Hủy bỏ</a>
                    <button type="submit" class="btn-submit" style="padding: 10px 25px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Xác nhận</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function updateHan() {
            let ngayMuon = document.getElementById('ngay_muon').value;
            if(!ngayMuon) return;
            let d = new Date(ngayMuon);
            d.setDate(d.getDate() + 15);
            document.getElementById('ngay_tra_dk').value = d.toISOString().split('T')[0];
        }

        function updatePhi() {
            let sl = document.getElementById('so_luong').value;
            let total = sl * 3000;
            document.getElementById('hien_phi').innerText = total.toLocaleString('vi-VN');
            document.getElementById('phi_muon').value = total;
        }
        window.onload = function() {
            updateHan();
            updatePhi();
        };
    </script>
    <script>
    document.getElementById('formAddPhieuMuon').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const formData = new FormData(this);

        fetch('/hocphp/pttkpm_QLTV moi/business/api/api_PhieuMuon.php?action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Đã tạo phiếu mượn mới.',
                    timer: 2000
                }).then(() => {
                    window.location.href = '../index_tt.php?view=muontra';
                });
            } else {
         
                let msg = data.message || 'Có lỗi xảy ra không xác định!';
                
               
                let title = 'Không thể thêm phiếu';
                if(data.error_code === 'has_overdue') title = 'Vi phạm: Quá hạn';
                if(data.error_code === 'limit_exceeded') title = 'Vượt hạn mức';

                Swal.fire({
                    icon: 'warning', 
                    title: title,
                    text: msg,
                    confirmButtonText: 'Đã hiểu'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ', 'error');
        });
    });
    </script>
</body>
</html>
