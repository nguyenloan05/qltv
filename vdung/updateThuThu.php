<?php 

require_once __DIR__ . '/../../../data/connect.php'; 
require_once __DIR__ . '/../../../data/repositories/ThuThuRepository.php';


$ma_thuthu = $_GET['id'] ?? null;

if (!$ma_thuthu) {
    echo "<script>alert('Không tìm thấy thủ thư!'); window.location='index.php?action=admin_dashboard&view=thuthu';</script>";
    exit();
}


$db = new Database();
$conn = $db->getConnection();
$repo = new ThuThuRepository($conn);
$tt = $repo->getById($ma_thuthu); 

if (!$tt) {
    echo "<script>alert('Dữ liệu không tồn tại!'); window.location='index.php?action=admin_dashboard&view=thuthu';</script>";
    exit();
}
?>

<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="presentation/assets/css/AdminView/updateThuThu.css">

<div class="content-wrapper">
    <a href="index.php?action=admin_dashboard&view=thuthu" class="btn-back">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>

    <div class="form-card">
        <div class="form-header">
            <h2><i class="fas fa-user-edit" style="color: var(--primary);"></i> CHỈNH SỬA THÔNG TIN THỦ THƯ</h2>
        </div>

        <form action="business/api/ThuThuAPI.php" method="POST">
            
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="ma_thuthu" value="<?php echo $tt->getMaThuthu(); ?>">
            <input type="hidden" name="user_id" value="<?php echo $tt->getUserId(); ?>">

            <input type="hidden" name="ngay_sinh" value="<?php echo $tt->getNgaySinh(); ?>">
            <input type="hidden" name="ngay_vao_lam" value="<?php echo $tt->getNgayVaoLam(); ?>">
            <input type="hidden" name="chuc_vu" value="<?php echo $tt->getChucVu(); ?>">

            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="ho_ten" class="form-control" value="<?php echo htmlspecialchars($tt->getHoTen()); ?>" required>
            </div>

            <div class="form-group">
                <label>Email làm việc</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($tt->getEmail()); ?>" required>
            </div>

            <div class="row-grid">
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control" value="<?php echo htmlspecialchars($tt->getSoDienThoai()); ?>">
                </div>
                <div class="form-group">
                    <label>Giới tính</label>
                    <select name="gioi_tinh" class="form-control">
                        <option value="Nam" <?php echo ($tt->getGioiTinh() == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                        <option value="Nữ" <?php echo ($tt->getGioiTinh() == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                        <option value="Khác" <?php echo ($tt->getGioiTinh() == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" name="dia_chi" class="form-control" value="<?php echo htmlspecialchars($tt->getDiaChi()); ?>">
            </div>

            <div class="row-grid">
                <div class="form-group">
                    <label>Phòng ban</label>
                    <input type="text" name="phong_ban" class="form-control" value="<?php echo htmlspecialchars($tt->getPhongBan()); ?>">
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="trang_thai" class="form-control">
                        <option value="Đang làm" <?php echo ($tt->getTrangThai() == 'Đang làm') ? 'selected' : ''; ?>>Đang làm</option>
                        <option value="Nghỉ việc" <?php echo ($tt->getTrangThai() == 'Nghỉ việc') ? 'selected' : ''; ?>>Nghỉ việc</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save me-2"></i> XÁC NHẬN CẬP NHẬT
            </button>
        </form>
    </div>
</div>
