<?php 

require_once __DIR__ . '/../../../data/connect.php'; 

$db = new Database();
$conn = $db->getConnection(); 

if (!$conn) {
    die("Lỗi: Không thể kết nối Database.");
}

$userId = 1;


$sql = "SELECT * FROM thu_thu WHERE user_id = '$userId'";
$res = mysqli_query($conn, $sql);

if (!$res) {
    die("Lỗi truy vấn SQL: " . mysqli_error($conn));
}

$tt = mysqli_fetch_assoc($res);


if (!$tt) {
    $tt = [
        'ho_ten' => 'Chưa cập nhật',
        'chuc_vu' => 'Thủ thư',
        'email' => 'Chưa cập nhật',
        'so_dien_thoai' => 'Chưa cập nhật',
        'gioi_tinh' => 'Chưa xác định',
        'dia_chi' => 'Hà Nội, Việt Nam'
    ];
}
?>


<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="presentation/assets/css/AdminView/ThuThu.css">

<div class="content-wrapper">
    <div class="profile-card">
        
        <div class="profile-banner"></div>
        
        <div class="profile-body">
            
            <div class="avatar-wrapper">
                <img src="presentation/assets/images/default_avatar.png" 
                     onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=random'" 
                     class="profile-avatar" alt="User Avatar">
                <span class="status-badge">ONLINE</span>
            </div>

            
            <h3 class="profile-name"><?php echo htmlspecialchars($tt['ho_ten']); ?></h3>
            <p class="profile-role"><?php echo htmlspecialchars($tt['chuc_vu'] ?: 'Thủ thư hệ thống'); ?></p>

            
            <div class="info-container">
                <div class="info-box">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <span class="info-label">Email làm việc</span>
                        <span class="info-data"><?php echo htmlspecialchars($tt['email']); ?></span>
                    </div>
                </div>
                
                <div class="info-box">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <span class="info-label">Số điện thoại</span>
                        <span class="info-data"><?php echo htmlspecialchars($tt['so_dien_thoai']); ?></span>
                    </div>
                </div>
                
                <div class="info-box">
                    <i class="fas fa-venus-mars"></i>
                    <div>
                        <span class="info-label">Giới tính</span>
                        <span class="info-data"><?php echo htmlspecialchars($tt['gioi_tinh']); ?></span>
                    </div>
                </div>
                
                <div class="info-box">
                    <i class="fas fa-map-marked-alt"></i>
                    <div>
                        <span class="info-label">Địa chỉ hiện tại</span>
                        <span class="info-data"><?php echo htmlspecialchars($tt['dia_chi']); ?></span>
                    </div>
                </div>
            </div>

            
            <button class="btn-edit-profile" 
                  onclick="location.href='index.php?action=admin_dashboard&view=updateThuThu&id=<?php echo $tt['ma_thuthu']; ?>'">
                  <i class="fas fa-pen-nib me-2"></i> CHỈNH SỬA THÔNG TIN
            </button>
        </div>
    </div>
</div>
