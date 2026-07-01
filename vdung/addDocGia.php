<head>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="presentation/assets/css/AdminView/addDocGia.css">
</head>

<div class="content-wrapper">
    <a href="index.php?action=admin_dashboard&view=docgia" class="back-link" style="text-decoration:none; color:#64748b; margin-bottom:20px; display:inline-block;">
        <i class="fas fa-chevron-left"></i> Quay lại danh sách
    </a>

    <div class="form-card">
        <h3 style="text-align:center; font-weight:800; margin-bottom:30px;">THÊM ĐỘC GIẢ MỚI</h3>

        <?php if (isset($_GET['error'])): ?>
            <div style="background-color: #fee2e2; color: #dc2626; padding: 15px; border-radius: 12px; border: 1px solid #fecaca; margin-bottom: 25px; font-weight: 600; font-size: 14px; display: flex; align-items: center;">
                <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        
        <form action="business/api/DocGiaAPI.php" method="POST">
            <input type="hidden" name="action" value="add">

            <label style="font-weight:700; font-size:12px; color:#475569;">MÃ ĐỘC GIẢ</label>
            <input type="text" name="ma_docgia" class="form-control-custom" placeholder="Nhập mã độc giả..." required>

            <label style="font-weight:700; font-size:12px; color:#475569;">HỌ VÀ TÊN</label>
            <input type="text" name="ho_ten" class="form-control-custom" placeholder="Nhập họ và tên..." required>

            <div class="row-grid">
                <div>
                    <label style="font-weight:700; font-size:12px; color:#475569;">EMAIL</label>
                    <input type="email" name="email" class="form-control-custom" placeholder="example@gmail.com" required
                           oninvalid="this.setCustomValidity('Vui lòng nhập định dạng email hợp lệ (Ví dụ: abc@gmail.com)')"
                           oninput="this.setCustomValidity('')">
                </div>
                
            </div>

            <div class="row-grid">
                <div>
                    <label style="font-weight:700; font-size:12px; color:#475569;">NGÀY SINH</label>
                    <input type="date" name="ngay_sinh" class="form-control-custom">
                </div>
                <div>
                    <label style="font-weight:700; font-size:12px; color:#475569;">GIỚI TÍNH</label>
                    <select name="gioi_tinh" class="form-control-custom">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
            </div>

            <label style="font-weight:700; font-size:12px; color:#475569;">ĐỊA CHỈ</label>
            <input type="text" name="dia_chi" class="form-control-custom" placeholder="Nhập địa chỉ cư trú...">

            <label style="font-weight:700; font-size:12px; color:#475569;">Username</label>
            <input type="text" name="username" class="form-control-custom" placeholder="Nhập username" required>

            <label style="font-weight:700; font-size:12px; color:#475569;">Password</label>
            <input type="password" name="password" class="form-control-custom" placeholder="Nhập mật khẩu..." required
                   pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,20}$"
                   oninvalid="this.setCustomValidity('Mật khẩu phải từ 6 đến 20 ký tự, bao gồm cả chữ cái và chữ số, không chứa khoảng trắng hay dấu')"
                   oninput="this.setCustomValidity('')">

            <button type="submit" class="btn-submit">XÁC NHẬN LƯU</button>
        </form>
    </div>
</div>