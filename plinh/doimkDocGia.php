<?php
$user_id = $_SESSION['user_id'] ?? ($_SESSION['user']['id'] ?? 0);
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/doimkDocGia.css">

<div class="content-wrapper">
    <div class="profile-card" style="max-width: 550px;">
        <div class="profile-header">
            <h3><i class="fas fa-key"></i> ĐỔI MẬT KHẨU TÀI KHOẢN</h3>
        </div>
        
        <form action="/hocphp/pttkpm_QLTV moi/business/api/DocGiaAPI.php" method="POST">
            <input type="hidden" name="action" value="change_password">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
            
            <div class="profile-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger" style="background-color: #fef2f2; border: 1px solid #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success" style="background-color: #f0fdf4; border: 1px solid #dcfce7; color: #166534; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-check-circle" style="margin-right: 8px;"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <label>Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" placeholder="Nhập mật khẩu cũ" required>
                </div>
                
                <div class="input-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="new_password" placeholder="Nhập mật khẩu mới (6-20 ký tự gồm chữ & số)" required>
                </div>
                
                <div class="input-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                </div>

                <div class="btn-group" style="margin-top: 30px;">
                    <button type="submit" class="btn-save">CẬP NHẬT MẬT KHẨU</button>
                    <button type="button" class="btn-cancel" onclick="location.href='index_dg.php?view=trangchu'">HỦY BỎ</button>
                </div>
            </div>
        </form>
    </div>
</div>