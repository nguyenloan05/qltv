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
        'ho_ten' => 'Chưa cập nhật',
        'username' => 'Chưa xác định',
        'ma_docgia' => 'Chưa xác định',
        'ngay_sinh' => null,
        'gioi_tinh' => 'Chưa xác định',
        'email' => 'Chưa cập nhật',
        'so_dien_thoai' => 'Chưa cập nhật',
        'dia_chi' => 'Chưa cập nhật'
    ];
}
?>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="presentation/assets/css/DocGiaView/CanhanDG.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="content-wrapper">
    <div class="profile-card">
        <div class="profile-banner"></div>
        
        <div class="profile-body">
            <div class="avatar-wrapper">
               <img src="presentation/assets/images/<?= $dg['anh_chan_dung'] ?: 'default_avatar.png' ?>" class="profile-avatar" alt="User Avatar" onerror="this.src='https://ui-avatars.com/api/?name=Reader&background=random'">
            </div>

            <h3 class="profile-name"><?= htmlspecialchars($dg['ho_ten'] ?: 'Chưa cập nhật') ?></h3>
            <p class="profile-role">@<?= htmlspecialchars($dg['username']) ?></p>

            <div class="info-container">
                <div class="info-box">
                    <i class="fas fa-id-card"></i>
                    <div>
                        <span class="info-label">Mã độc giả</span>
                        <span class="info-data">#<?= htmlspecialchars($dg['ma_docgia']) ?></span>
                    </div>
                </div>
                <div class="info-box">
                    <i class="fas fa-birthday-cake"></i>
                    <div>
                        <span class="info-label">Ngày sinh</span>
                        <span class="info-data">
                            <?= ($dg['ngay_sinh'] && $dg['ngay_sinh'] != '0000-00-00') ? date('d/m/Y', strtotime($dg['ngay_sinh'])) : 'Chưa cập nhật' ?>
                        </span>
                    </div>
                </div>

                <div class="info-box">
                    <i class="fas fa-venus-mars"></i>
                    <div>
                        <span class="info-label">Giới tính</span>
                        <span class="info-data"><?= htmlspecialchars($dg['gioi_tinh'] ?: 'Chưa xác định') ?></span>
                    </div>
                </div>
                
                <div class="info-box">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <span class="info-label">Email</span>
                        <span class="info-data"><?= htmlspecialchars($dg['email'] ?: 'Chưa cập nhật') ?></span>
                    </div>
                </div>
                
                <div class="info-box">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <span class="info-label">Số điện thoại</span>
                        <span class="info-data"><?= htmlspecialchars($dg['so_dien_thoai'] ?: 'Chưa cập nhật') ?></span>
                    </div>
                </div>
                
                <div class="info-box">
                    <i class="fas fa-map-marked-alt"></i>
                    <div>
                        <span class="info-label">Địa chỉ hiện tại</span>
                        <span class="info-data"><?= htmlspecialchars($dg['dia_chi'] ?: 'Chưa cập nhật') ?></span>
                    </div>
                </div>

                <div class="info-box account-highlight">
                    <i class="fas fa-user-circle"></i>
                    <div>
                        <span class="info-label">Tên đăng nhập</span>
                        <span class="info-data" style="color: #2563eb;"><?= htmlspecialchars($dg['username']) ?></span>
                    </div>
                </div>

                <div class="info-box account-highlight">
                    <i class="fas fa-key"></i>
                    <div>
                        <span class="info-label">Mật khẩu</span>
                        <span class="info-data">••••••••</span>
                    </div>
                </div>
            </div>

            <button class="btn-edit-profile" 
                  onclick="location.href='index.php?action=trangchu_sv&view=doimkDocGia'">
                  <i class="fas fa-user-edit me-2"></i> CHỈNH SỬA THÔNG TIN CÁ NHÂN
            </button>
        </div>
    </div>
</div>