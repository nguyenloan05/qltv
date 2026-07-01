<?php

require_once __DIR__ . '/../../../../data/connect.php';
require_once __DIR__ . '/../../../../data/repositories/PhieuMuonRepo.php';
require_once __DIR__ . '/../../../../business/services/PhieuMuonService.php';

$db = new Database();
$conn = $db->getConnection();
$service = new PhieuMuonService($conn);

$ma_pm = $_GET['ma_pm'] ?? $_GET['id'] ?? '';
$result = $service->getDetail($ma_pm);

if ($result['status'] === 'error' || empty($result['data'])) {
    header("Location: index_tt.php?view=muontra&msg=not_found");
    exit;
}

$data = $result['data'] ?? []; 
$ma_hien_thi = $data['ma_pm'] ?? $data['MaPM'] ?? '';
$ngay_muon_raw = $data['ngay_muon'] ?? $data['NgayMuon'] ?? '';
$ngay_tra_dk_raw = $data['ngay_tra_du_kien'] ?? $data['NgayTraDuKien'] ?? '';

if (isset($_GET['msg']) && $_GET['msg'] == 'updated') {
    
}

function showData($value, $default = "<i>Chưa cập nhật</i>") {
    return (!empty($value)) ? htmlspecialchars($value) : $default;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật phiếu mượn | LibManager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../../assets/css/ThuThuView/menu_tt.css">
    <link rel="stylesheet" href="../../../assets/css/ThuThuView/qlpm/update_pm.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="display: flex; margin: 0; background: #f4f7f6;">

    <?php include '../menu_tt.php'; ?>

    <main class="main-wrapper">
        <div class="page-container">
            <div class="form-card">
                <div class="card-header">
                    <h2><i class="fas fa-edit"></i> CẬP NHẬT TRẠNG THÁI TRẢ SÁCH</h2>
                    <span class="badge-id">Mã phiếu: <?= $data['ma_pm'] ?? $data['MaPM'] ?></span>
                </div>

                
                <form id="formUpdatePhieuMuon">
                    <input type="hidden" name="ma_pm" value="<?= $data['ma_pm'] ?>">
                    <input type="hidden" name="ngay_muon" value="<?= $ngay_muon_raw ?>">

                    <div class="grid-layout">
                        <div class="info-section">
                            <h3 class="section-title"><i class="fas fa-id-card"></i> Thông tin đối soát</h3>
                            <div class="read-only-box">
                                <div class="info-group">
                                    <label>Độc giả:</label>
                                    <p><strong><?= showData($data['ho_ten'] ?? $data['ten_docgia'])?></strong> (<?= showData($data['ma_docgia']) ?>)</p>
                                </div>
                                <div class="info-group">
                                    <label>Sách mượn:</label>
                                    <p><strong><?= showData($data['ten_sach']) ?></strong></p>
                                </div>

                                <div class="info-group">
                                    <label>Số lượng:</label>
                                    <p><strong><?= showData($data['so_luong']) ?></strong> quyển</p>
                                </div>

                                <div class="info-group">
                                    <label>Ngày mượn:</label>
                                    <p>
                                        
                                         <strong><?= !empty($data['ngay_muon']) ? date('d/m/Y', strtotime($data['ngay_muon'])) : date('d/m/Y', strtotime($data['NgayMuon'])) ?></strong>
                                    </p>
                                </div>
                                <div class="info-group">
                                    <label>Hạn trả gốc:</label>
                                    <p class="text-danger">
                                        <?= !empty($data['ngay_tra_du_kien'] ?? $data['NgayTraDuKien']) ? date('d/m/Y', strtotime($data['ngay_tra_du_kien']?? $data['NgayTraDuKien'])) : "Chưa có hạn trả" ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="action-section">
                            <h3 class="section-title"><i class="fas fa-pen-nib"></i> Nhập thông tin trả</h3>
                            
                            <div class="form-group"> 
                                <label>Hạn trả dự kiến (Gia hạn):</label>
                                <input type="date" name="ngay_tra_dk" id="ngay_tra_dk" 
                                    value="<?= $data['ngay_tra_du_kien'] ?? $data['NgayTraDuKien'] ?>" 
                                    class="form-input" style="border: 1px solid #3498db;"
                                    onchange="tinhTienTre()"> 
                            </div>
                                    
                            <div class="form-group">
                                <label>Ngày trả thực tế:</label>
                                <input type="date" name="ngay_tra_tt" id="ngay_tra_tt" 
                                        min="<?= $ngay_muon_raw ?>"
                                    value="<?= $data['ngay_tra_thuc_te'] ?? date('Y-m-d') ?>" 
                                    class="form-input" onchange="tinhTienTre()">
                            </div>

                            <div class="form-group">
                                <label>Trạng thái phiếu:</label>
                                <select name="tinh_trang" id="tinh_trang" class="form-input" onchange="toggleViPham()">
                                    <option value="0" <?= ($data['tinh_trang'] ?? $data['TinhTrang']) == 0 ? 'selected' : '' ?>>0 - Chờ duyệt</option>
                                    <option value="1" <?= ($data['tinh_trang'] ?? $data['TinhTrang']) == 1 ? 'selected' : '' ?>>1 - Đang mượn</option>
                                    <option value="2" <?= ($data['tinh_trang'] ?? $data['TinhTrang']) == 2 ? 'selected' : '' ?>>2 - Đã trả (Hoàn thành)</option>
                                    <option value="3" <?= ($data['tinh_trang'] ?? $data['TinhTrang']) == 3 ? 'selected' : '' ?>>3 - Chờ xử lý vi phạm</option>
                                    <option value="4" <?= ($data['tinh_trang'] ?? $data['TinhTrang']) == 4 ? 'selected' : '' ?>>4 - Đã hủy/Từ chối</option>
                                </select>
                            </div>

                            
                            <div id="vi_pham_fields" class="vi-pham-card" style="display:none; border: 1px solid #fab1a0; background: #fff5f5; padding: 15px; border-radius: 8px;">
                                <div class="form-row" style="display: flex; gap: 15px;">
                                    <div class="form-group" style="flex: 1;">
                                        <label>Phạt trễ (VNĐ):</label>
                                        <input type="number" name="tien_phat_tre" id="tien_tre" class="form-input" 
                                            value="<?= $data['tien_phat_tre'] ?? 0 ?>" readonly>
                                        <small id="hint_tre" style="color: #e67e22;"></small>
                                        <p style="color:#c0392b; font-size:13px;">
                                            * Nếu có hư hỏng/mất sách, vui lòng thêm chi tiết tại mục Quản lý vi phạm.
                                        </p>

                                    </div>
                                    
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px; display: flex; gap: 10px;">
                        <button type="submit" class="btn-save" style="background: #3498db; color: white; border: none; padding: 10px 25px; border-radius: 4px; cursor: pointer; font-weight: bold;">LƯU THAY ĐỔI</button>
                        <a href="../index_tt.php?view=muontra" class="btn-back" style="background: #bdc3c7; color: #2c3e50; padding: 10px 25px; border-radius: 4px; text-decoration: none;">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
    document.getElementById('formUpdatePhieuMuon').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const formData = new FormData(this);


        fetch('/hocphp/pttkpm_QLTV moi/business/api/api_PhieuMuon.php?action=update_status', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Dữ liệu đã được cập nhật.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                   
                    window.location.href = '../index_tt.php?view=muontra';
                });
            } else {
                Swal.fire('Thất bại', data.message || 'Không tìm thấy phiếu hoặc lỗi hệ thống', 'error');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ', 'error');
        });
    });
    </script>

    <script>
    function toggleViPham() {
        const status = document.getElementById('tinh_trang').value;
        const viPhamDiv = document.getElementById('vi_pham_fields');
        if (status == "3") {
            viPhamDiv.style.display = 'block';
            tinhTienTre();
        } else {
            viPhamDiv.style.display = 'none';
        }
    }

    function tinhTienTre() {
        const ngayTraVal = document.getElementById('ngay_tra_tt').value;
        const ngayDkVal = document.getElementById('ngay_tra_dk').value;
        const soLuong = <?= (int)($data['so_luong'] ?? $data['SoLuong'] ?? 1) ?>;

        if(!ngayTraVal || !ngayDkVal) return;

        const ngayTra = new Date(ngayTraVal);
        const ngayDuKienMoi = new Date(ngayDkVal);
        const timeDiff = ngayTra - ngayDuKienMoi; 
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

        const hint = document.getElementById('hint_tre');
        const inputTre = document.getElementById('tien_tre');

        if (daysDiff > 0) {
            const tienPhat = daysDiff * 5000 * soLuong;
            hint.innerText = `Trễ ${daysDiff} ngày x ${soLuong} quyển (Gợi ý: ${tienPhat.toLocaleString()}đ)`;
            inputTre.value = tienPhat;
        } else {
            hint.innerText = "";
            inputTre.value = 0;
        }
    }

    window.onload = function() {
        toggleViPham();
    };

    </script>
</body>
</html>
