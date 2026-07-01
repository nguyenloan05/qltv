<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống - UTT Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    
    <link rel="stylesheet" href="presentation/assets/css/KhachView/menuKhach.css">
    <link rel="stylesheet" href="presentation/assets/css/login.css">
</head>
<body>
    
    <?php include __DIR__ . '/KhachView/menuKhach.php'; ?>

    <div class="main-content">
        <div class="login-container">
            <div class="login-header">
                <a href="index.php?action=khach">
                    
                    <img src="presentation/assets/images/book_icon.jfif" alt="Logo thư viện" class="college-logo" 
                        onerror="this.src='https://via.placeholder.com/80?text=ABC+Logo'">
                </a>
                <h2>CỔNG ĐĂNG NHẬP</h2>
                <p>Sử dụng tài khoản thủ thư/độc giả để truy cập thư viện</p>
            </div>

            
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div class="alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; border-left: 5px solid #28a745;">
                    <i class="fas fa-check-circle"></i> Đăng ký tài khoản thành công! Mời bạn đăng nhập.
                </div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; border-left: 5px solid #dc3545;">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=login_submit" method="POST" class="login-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user-graduate"></i> Tên đăng nhập</label>
                    <input type="text" id="username" name="username" placeholder="Tên đăng nhập hoặc Email" required>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-key"></i> Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                    </label>
                    <a href="#" class="forgot-pass">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn-login">ĐĂNG NHẬP TRUY CẬP</button>

            </form>

            <div class="login-footer">
                <p>Bạn là Khách? <a href="index.php?action=dangKy">Đăng ký tài khoản mới</a></p>
                <div class="support-info">
                    <span><i class="fas fa-envelope"></i> thuvien@abc.edu.vn</span>
                    <span><i class="fas fa-phone"></i> (024) 3.552.1234</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>