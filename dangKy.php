<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên - UTT Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="presentation/assets/css/KhachView/menuKhach.css">
    
    <link rel="stylesheet" href="presentation/assets/css/KhachView/dangKy.css">
</head>
<body>
    <?php include __DIR__ . '/KhachView/menuKhach.php'; ?>

    <div class="main-content">
        <div class="form-card">
            <div class="hero">
                <i class="fas fa-user-plus fa-3x mb-2"></i>
                <h2 class="fw-bold">ĐĂNG KÝ TÀI KHOẢN</h2>
                <p class="mb-0 opacity-75">Vui lòng điền chính xác thông tin để được cấp thẻ</p>
            </div>

            <div class="form-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form action="index.php?action=dangKy_submit" method="POST" id="regForm" novalidate>
                    
                    <div class="section-title mt-0">Thông tin tài khoản</div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Tên tài khoản (Username)</label>
                            <input type="text" class="form-control" name="username" id="username"
                                   placeholder="Ví dụ: nva_99 (Không dấu, không khoảng trắng)">
                            <small class="error-label" id="err-username">Tên tài khoản từ 3-20 ký tự, không dấu, không khoảng trắng.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" required>
                                <span class="input-group-text toggle-pass" data-target="password"><i class="fas fa-eye"></i></span>
                            </div>
                            <div id="meter" class="strength-meter"></div>
                            <small id="meter-text" class="text-muted" style="font-size: 0.75rem;"></small>
                            <!-- <small class="error-label" id="err-password">Mật khẩu phải từ 6 ký tự trở lên.</small> -->
                            <small class="error-label" id="err-password">Mật khẩu phải từ 6 ký tự trở lên, không chứa dấu tiếng Việt, không khoảng trắng.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" required>
                                <span class="input-group-text toggle-pass" data-target="confirm_password"><i class="fas fa-eye"></i></span>
                            </div>
                            <small class="error-label" id="err-confirm">Mật khẩu xác nhận không trùng khớp!</small>
                        </div>
                    </div>

                    <div class="section-title">Thông tin cá nhân</div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Họ và tên</label>
                            <input type="text" class="form-control" name="ho_ten" id="ho_ten" placeholder="Nguyễn Văn A" required>
                            <small class="error-label" id="err-hoten">Vui lòng nhập họ và tên của bạn.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Ngày sinh</label>
                            <input type="date" class="form-control" name="ngay_sinh" id="dob" required>
                            <small class="error-label" id="err-dob">Vui lòng chọn ngày sinh hợp lệ.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Giới tính</label>
                            <select class="form-select" name="gioi_tinh" id="gioi_tinh" required>
                                <option value="">Chọn...</option>
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                                <option value="Khác">Khác</option>
                            </select>
                            <small class="error-label" id="err-gioitinh">Vui lòng chọn giới tính.</small>
                        </div>
                    </div>

                    <div class="section-title">Thông tin liên lạc</div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com" required>
                            <small class="error-label" id="err-email">Email không đúng định dạng.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Số điện thoại</label>
                            <input type="text" class="form-control" name="so_dien_thoai" id="so_dien_thoai"
                                   placeholder="Từ 10 - 12 chữ số" required>
                            <small class="error-label" id="err-sdt">Số điện thoại phải từ 10 - 12 chữ số.</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Địa chỉ (Không bắt buộc)</label>
                            <input type="text" class="form-control" name="dia_chi" placeholder="Địa chỉ thường trú">
                        </div>
                    </div>

                    <div class="alert alert-secondary small border-0 bg-light mb-4">
                        <i class="fas fa-info-circle me-1"></i> Sau khi hoàn tất, vui lòng đăng nhập để yêu cầu <strong>Kích hoạt thẻ thư viện</strong>.
                    </div>

                    <button type="submit" class="btn btn-submit">XÁC NHẬN ĐĂNG KÝ</button>

                    <div class="text-center mt-3">
                        <a href="index.php?action=login" class="text-decoration-none text-muted small"><i class="fas fa-arrow-left"></i> Quay lại Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    const form = document.getElementById('regForm');
    const dob = document.getElementById('dob');
    
    dob.max = new Date().toISOString().split("T")[0];

    document.querySelectorAll('.toggle-pass').forEach(btn => {
        btn.onclick = function() {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        };
    });

    const rules = {
        username: val => /^[a-zA-Z0-9_]{3,20}$/.test(val),
        //password: val => val.length >= 6,
        password: val => /^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,}$/.test(val),
        confirm_password: val => val === document.getElementById('password').value && val !== "",
        ho_ten: val => val.trim() !== "",
        email: val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
        so_dien_thoai: val => /^[0-9]{10,12}$/.test(val),
        gioi_tinh: val => val !== "",
        dob: val => val !== ""
    };

    const errorMap = {
        username: 'err-username',
        password: 'err-password',
        confirm_password: 'err-confirm',
        ho_ten: 'err-hoten',
        email: 'err-email',
        so_dien_thoai: 'err-sdt',
        gioi_tinh: 'err-gioitinh',
        dob: 'err-dob'
    };

    function validateField(id) {
        const input = document.getElementById(id);
        const errEl = document.getElementById(errorMap[id]);
        if (!input || !errEl) return true;

        const isValid = rules[id](input.value);
        if (isValid) {
            input.classList.remove('is-invalid');
            errEl.style.display = 'none';
        } else {
            input.classList.add('is-invalid');
            errEl.style.display = 'block';
        }
        return isValid;
    }

    Object.keys(rules).forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.oninput = () => validateField(id);
            if (el.tagName === 'SELECT') el.onchange = () => validateField(id);
        }
    });

    form.onsubmit = function(e) {
        let isFormValid = true;
        Object.keys(rules).forEach(id => {
            if (!validateField(id)) isFormValid = false;
        });

        if (!isFormValid) {
            e.preventDefault();
            const firstErr = document.querySelector('.is-invalid');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    };
</script>
</body>
</html>