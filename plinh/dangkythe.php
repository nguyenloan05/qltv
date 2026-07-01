<div id="docgiaCardContainer" class="card-container">
    <div style="text-align:center; padding:40px;">
        <i class="fas fa-spinner fa-spin fa-2x" style="color:#7c3aed;"></i>
        <p style="margin-top:15px; color:#6b7280;">Đang tải thông tin...</p>
    </div>
</div>

<script>
    const API_URL = '/hocphp/pttkpm_QLTV moi/business/api/docgia/docgia_api.php';

    document.addEventListener("DOMContentLoaded", function() {
        loadData();
    });

    async function loadData() {
        try {
            const res = await fetch(API_URL);
            const json = await res.json();

            if (json.status === "success") {
                renderContent(json.data);
            } else {
                document.getElementById('docgiaCardContainer').innerHTML = `
                    <div class="register-card" style="text-align:center;">
                        <i class="fas fa-exclamation-triangle fa-3x" style="color:#e74c3c; margin-bottom:15px;"></i>
                        <h3>Lỗi tải dữ liệu</h3>
                        <p class="sub-note">${json.message || 'Không thể tải thông tin độc giả.'}</p>
                        <button class="btn-submit" onclick="loadData()" style="max-width:200px; margin:15px auto;">
                            <i class="fas fa-redo me-2"></i> Thử lại
                        </button>
                    </div>`;
            }
        } catch (err) {
            console.error('Error loading data:', err);
            document.getElementById('docgiaCardContainer').innerHTML = `
                <div class="register-card" style="text-align:center;">
                    <i class="fas fa-wifi fa-3x" style="color:#e74c3c; margin-bottom:15px;"></i>
                    <h3>Lỗi kết nối</h3>
                    <p class="sub-note">Không thể kết nối đến máy chủ. Vui lòng kiểm tra lại.</p>
                    <button class="btn-submit" onclick="loadData()" style="max-width:200px; margin:15px auto;">
                        <i class="fas fa-redo me-2"></i> Thử lại
                    </button>
                </div>`;
        }
    }

    function renderContent(data) {
        const container = document.getElementById('docgiaCardContainer');
        const thongTin = data.reader;
        const theInfo = data.card;

        let html = "";

        if (!theInfo || !theInfo.id) {
            // TRƯỜNG HỢP 1: CHƯA CÓ THẺ → HIỆN FORM XÁC NHẬN ĐĂNG KÝ
            html = `
                <div class="register-card">
                    <h2 class="form-title" style="text-align:center; color:#2c3e50; margin-bottom:20px;">
                        <i class="fas fa-id-card-alt" style="color:#7c3aed;"></i> Xác Nhận Đăng Ký Thẻ Thư Viện
                    </h2>
                    <p style="text-align:center; color:#6b7280; margin-bottom:20px;">Vui lòng kiểm tra thông tin bên dưới trước khi gửi yêu cầu</p>
                    <div class="preview-info">
                        <div class="preview-row"><strong>Mã độc giả:</strong> <span>${thongTin.ma_docgia}</span></div>
                        <div class="preview-row"><strong>Họ và tên:</strong> <span>${thongTin.ho_ten}</span></div>
                        <div class="preview-row"><strong>Ngày sinh:</strong> <span>${thongTin.ngay_sinh || '---'}</span></div>
                        <div class="preview-row"><strong>Giới tính:</strong> <span>${thongTin.gioi_tinh || '---'}</span></div>
                        <div class="preview-row"><strong>Email:</strong> <span>${thongTin.email || '---'}</span></div>
                        <div class="preview-row"><strong>Số điện thoại:</strong> <span>${thongTin.so_dien_thoai || '---'}</span></div>
                        <div class="preview-row"><strong>Địa chỉ:</strong> <span>${thongTin.dia_chi || '---'}</span></div>
                    </div>
                    <form id="formRegister">
                        <input type="hidden" name="ma_docgia" value="${thongTin.ma_docgia}">
                        <div class="btn-container">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Xác Nhận & Gửi Yêu Cầu
                            </button>
                        </div>
                    </form>
                </div>
            `;
        } else if (parseInt(theInfo.trang_thai) === 0) {
            // TRƯỜNG HỢP 2: ĐANG CHỜ DUYỆT
            html = `
                <div class="status-waiting">
                    <div class="icon-clock">⏳</div>
                    <h2 style="color:#d48806; margin-bottom:10px;">Yêu Cầu Đang Chờ Duyệt</h2>
                    <p style="color:#595959;">Thông tin của bạn đã được gửi đến thủ thư.</p>
                    <div class="alert-orange">
                        Trạng thái: <strong>${theInfo.status_text}</strong>
                    </div>
                    <p class="sub-note">Vui lòng kiểm tra lại sau hoặc theo dõi thông báo từ hệ thống.</p>
                </div>
            `;
        } else if (parseInt(theInfo.trang_thai) === 1) {
            // TRƯỜNG HỢP 3: ĐÃ KÍCH HOẠT → HIỂN THỊ THẺ THƯ VIỆN CHÍNH THỨC (Giao diện đơn giản)
            const ngayCap = theInfo.ngay_cap ? new Date(theInfo.ngay_cap).toLocaleDateString('vi-VN') : '---';
            const ngayHetHan = theInfo.ngay_het_han ? new Date(theInfo.ngay_het_han).toLocaleDateString('vi-VN') : '---';
            html = `
                <div class="card-official-simple">
                    <h2 class="official-title">THẺ THƯ VIỆN CHÍNH THỨC</h2>
                    <div class="card-details">
                        <p><strong>Mã thẻ:</strong> ${theInfo.ma_the}</p>
                        <p><strong>Ngày cấp:</strong> ${ngayCap}</p>
                        <p><strong>Ngày hết hạn:</strong> ${ngayHetHan}</p>
                        <p><strong>Trạng thái:</strong> ${theInfo.status_text}</p>
                    </div>
                </div>
            `;
        } else if (parseInt(theInfo.trang_thai) === 2) {
            // TRƯỜNG HỢP 4: BỊ KHÓA
            html = `
                <div class="status-locked">
                    <div style="text-align:center; margin-bottom:15px;">
                        <i class="fas fa-lock fa-3x" style="color:#e74c3c;"></i>
                    </div>
                    <h2 style="color:#e74c3c; text-align:center;">Thẻ Đã Bị Khóa</h2>
                    <p style="text-align:center; color:#666;">Mã thẻ: <strong>${theInfo.ma_the || '---'}</strong></p>
                    <div class="alert-red" style="background:#fef2f2; border-left:5px solid #ef4444; padding:12px; margin:15px 0; border-radius:4px; color:#991b1b;">
                        <i class="fas fa-exclamation-triangle"></i> Thẻ của bạn hiện không thể sử dụng.
                    </div>
                    <div class="lock-reason" style="background:#f8f9fa; padding:12px; border-radius:8px; margin:10px 0;">
                        <strong>Lý do khóa:</strong>
                        <span style="color:#c0392b;">${theInfo.ly_do_khoa || 'Không có thông tin'}</span>
                    </div>
                    <p class="sub-note" style="text-align:center;">Vui lòng liên hệ thủ thư để được hỗ trợ.</p>
                </div>
            `;
        }

        container.innerHTML = html;

        const form = document.getElementById("formRegister");
        if (form) {
            form.addEventListener("submit", handleRegister);
        }
    }

    async function handleRegister(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('.btn-submit');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                body: new FormData(form)
            });
            const data = await res.json();
            
            if (data.status === "success") {
                alert('✅ ' + data.message);
                loadData(); 
            } else {
                alert('❌ ' + (data.message || 'Có lỗi xảy ra'));
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Xác Nhận & Gửi Yêu Cầu';
            }
        } catch (err) {
            alert("❌ Lỗi kết nối đến máy chủ");
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Xác Nhận & Gửi Yêu Cầu';
        }
    }
</script>

