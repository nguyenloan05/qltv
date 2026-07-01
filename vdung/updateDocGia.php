<?php
require_once __DIR__ . '/../../../business/services/DocGiaService.php';
$service = new DocGiaService();

$ma_dg = $_REQUEST['ma_docgia'] ?? null;
if (!$ma_dg) die("Lỗi: Không tìm thấy Mã độc giả!");
$data = $service->getById($ma_dg);

if (!$data) {
    die("Không tìm thấy thông tin độc giả!");
}
?>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="presentation/assets/css/AdminView/updateDocGia.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<div class="content-wrapper">
    <a href="index.php?action=admin_dashboard&view=docgia" class="back-link" style="text-decoration:none; color:#64748b; margin-bottom:20px; display:inline-block;">
        <i class="fas fa-chevron-left"></i> Quay lại danh sách
    </a>

    <div class="form-card">
        <h3>CHI TIẾT ĐỘC GIẢ</h3>
        
            <form id="updateDocGiaForm" method="POST" action="business/api/DocGiaAPI.php">
            <input type="hidden" name="is_update" value="1">
            <input type="hidden" name="redirect" value="1">
            <input type="hidden" name="user_id" value="<?= $data->getUserId() ?>">

            <label class="form-label">MÃ ĐỘC GIẢ</label>
            <input type="text" name="ma_docgia" class="form-control-custom form-control-readonly" 
                   value="<?= $data->getMaDocGia() ?>" readonly>

            <label class="form-label">HỌ VÀ TÊN</label>
            <input type="text" name="ho_ten" class="form-control-custom" 
                   value="<?= $data->getHoTen() ?>" required>

            <div class="row-grid">
                <div>
                    <label class="form-label">EMAIL</label>
                    <input type="email" name="email" class="form-control-custom" 
                           value="<?= $data->getEmail() ?>">
                </div>
                <!-- <div>
                    <label class="form-label">SỐ ĐIỆN THOẠI</label>
                    <input type="text" name="so_dien_thoai" class="form-control-custom" 
                           value="<?= $data->getSoDienThoai() ?>">
                </div>
            </div> -->

            <div class="row-grid">
                <div>
                    <label class="form-label">NGÀY SINH</label>
                    <input type="date" name="ngay_sinh" class="form-control-custom" 
                           value="<?= $data->getNgaySinh() ?>">
                </div>
                <div>
                    <label class="form-label">GIỚI TÍNH</label>
                    <select name="gioi_tinh" class="form-control-custom">
                        <option value="Nam" <?= $data->getGioiTinh() == 'Nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="Nữ" <?= $data->getGioiTinh() == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                        <option value="Khác" <?= $data->getGioiTinh() == 'Khác' ? 'selected' : '' ?>>Khác</option>
                    </select>
                </div>
            </div>

            <label class="form-label">ĐỊA CHỈ</label>
            <input type="text" name="dia_chi" class="form-control-custom" 
                   value="<?= $data->getDiaChi() ?>">
                   
            <button type="submit" class="btn-update">CẬP NHẬT THÔNG TIN</button>
        </form>
    </div>
</div>

