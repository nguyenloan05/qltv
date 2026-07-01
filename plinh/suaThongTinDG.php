<?php
$user_id = $_SESSION['user_id'] ?? ($_SESSION['user']['id'] ?? 0);
$sql = "SELECT dg.*, u.username 
        FROM docgia dg 
        LEFT JOIN user u ON dg.user_id = u.id 
        WHERE dg.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$dg = $stmt->get_result()->fetch_assoc();

if (!$dg) {
    $dg = [
        'anh_chan_dung' => 'default_avatar.png',
        'ho_ten' => '',
        'username' => '',
        'ma_docgia' => '',
        'user_id' => $user_id,
        'ngay_sinh' => null,
        'gioi_tinh' => 'Khác',
        'email' => '',
        'so_dien_thoai' => '',
        'dia_chi' => ''
    ];
}
?>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="presentation/assets/css/DocGiaView/doimkDocGia.css">

<div class="content-wrapper">
    <div class="profile-card">
        <div class="profile-header">
            <h3><i class="fas fa-user-edit"></i> CHỈNH SỬA HỒ SƠ ĐỘC GIẢ</h3>
        </div>
        
        <form action="business/api/DocGiaAPI.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update_profile">
            <input type="hidden" name="ma_docgia" value="<?= htmlspecialchars($dg['ma_docgia']) ?>">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($dg['user_id']) ?>">
            
            <div class="profile-body">
                <div class="info-group-title">Thông tin cơ bản</div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label>Họ và tên</label>
                        <input type="text" name="ho_ten" value="<?= htmlspecialchars($dg['ho_ten'] ?? '') ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Ngày sinh</label>
                        <input type="date" name="ngay_sinh" value="<?= htmlspecialchars($dg['ngay_sinh'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label>Giới tính</label>
                        <select name="gioi_tinh" class="form-control-custom" style="width: 100%; padding: 12px; border-radius: 12px; border: 2px solid #f1f5f9;">
                            <option value="Nam" <?= ($dg['gioi_tinh'] ?? '') == 'Nam' ? 'selected' : '' ?>>Nam</option>
                            <option value="Nữ" <?= ($dg['gioi_tinh'] ?? '') == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                            <option value="Khác" <?= ($dg['gioi_tinh'] ?? '') == 'Khác' ? 'selected' : '' ?>>Khác</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($dg['so_dien_thoai'] ?? '') ?>">
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($dg['email'] ?? '') ?>">
                    </div>
                    <div class="input-group">
                        <label>Địa chỉ hiện tại</label>
                        <input type="text" name="dia_chi" value="<?= htmlspecialchars($dg['dia_chi'] ?? '') ?>">
                    </div>
                </div>

                <div class="btn-group" style="margin-top: 30px;">
                    <button type="submit" class="btn-save">LƯU THAY ĐỔI</button>
                    <button type="button" class="btn-cancel" onclick="location.href='index.php?action=trangchu_sv&view=taikhoan'">HỦY BỎ</button>
                </div>
            </div>
        </form>
    </div>
</div>
