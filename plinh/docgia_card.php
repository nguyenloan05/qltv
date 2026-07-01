<link rel="stylesheet" href="/pttkpm_QLTV/presentation/assets/css/DocGiaView/card/docgia_card.css">

<div id="docgiaCardContainer" class="card-container">

</div>

<script>
    const API_URL = '/pttkpm_QLTV/business/api/docgia/docgia_api.php';

    document.addEventListener("DOMContentLoaded", function() {
        loadData();
    });

    async function loadData() {
        try {
            const res = await fetch(API_URL + '?user_id=10'); // Giả sử user_id = 10
            const json = await res.json();

            if (json.status === "success") {
                renderContent(json.data);
            } else {
                document.getElementById('docgiaCardContainer').innerHTML = `<p class="error">${json.message}</p>`;
            }
        } catch (err) {
            console.error('Error loading data:', err);
        }
    }

    function renderContent(data) {
        const container = document.getElementById('docgiaCardContainer');
        const thongTin = data.reader;
        const theInfo = data.card;

        let html = "";

        if (!theInfo || !theInfo.id) {
            // TRƯỜNG HỢP 1: CHƯA CÓ THẺ & CHƯA ĐĂNG KÝ
            html = `
                <div class="register-card">
                    <h2 class="form-title">Xác Nhận Đăng Ký Thẻ Thư Viện</h2>
                    <div class="preview-info">
                        <div class="preview-row"><strong>Mã độc giả:</strong> <span>${thongTin.ma_docgia}</span></div>
                        <div class="preview-row"><strong>Họ và tên:</strong> <span>${thongTin.ho_ten}</span></div>
                        <div class="preview-row"><strong>Ngày sinh:</strong> <span>${thongTin.ngay_sinh}</span></div>
                        <div class="preview-row"><strong>Giới tinh:</strong> <span>${thongTin.gioi_tinh}</span></div>
                        <div class="preview-row"><strong>Email:</strong> <span>${thongTin.email}</span></div>
                        <div class="preview-row"><strong>Số điện thoại:</strong> <span>${thongTin.so_dien_thoai}</span></div>
                        <div class="preview-row"><strong>Địa chỉ:</strong> <span>${thongTin.dia_chi}</span></div>
                    </div>
                    <form id="formRegister">
                        <input type="hidden" name="ma_docgia" value="${thongTin.ma_docgia}">
                        <div class="btn-container">
                            <button type="submit" class="btn-submit">Xác Nhận & Gửi Yêu Cầu</button>
                        </div>
                    </form>
                </div>
            `;
        } else if (parseInt(theInfo.trang_thai) === 0) {
            // TRƯỜNG HỢP 2: ĐANG CHỜ DUYỆT
            html = `
                <div class="status-waiting">
                    <div class="icon-clock">⏳</div>
                    <h2>Yêu Cầu Đang Chờ Duyệt</h2>
                    <p>Thông tin của bạn đã được gửi đến thủ thư.</p>
                    <div class="alert-orange">
                        Trạng thái: <strong>${theInfo.status_text}</strong>
                    </div>
                    <p class="sub-note">Vui lòng kiểm tra lại sau hoặc theo dõi thông báo từ hệ thống.</p>
                </div>
            `;
        } else if (parseInt(theInfo.trang_thai) === 1) {
            // TRƯỜNG HỢP 3: ĐÃ KÍCH HOẠT
            const ngayCap = new Date(theInfo.ngay_cap).toLocaleDateString('vi-VN');
            const ngayHetHan = new Date(theInfo.ngay_het_han).toLocaleDateString('vi-VN');
            html = `
                <div class="card-official">
                    <h2 style="color: green;">Thẻ Thư Viện Chính Thức</h2>
                    <div class="card-content">
                        <p>Mã thẻ: <strong>${theInfo.ma_the}</strong></p>
                        <p>Ngày cấp: ${ngayCap}</p>
                        <p>Ngày hết hạn: ${ngayHetHan}</p>
                        <div class="status-active">Trạng thái: ${theInfo.status_text}</div>
                    </div>
                </div>
            `;
        } else if (parseInt(theInfo.trang_thai) === 2) {
            // TRƯỜNG HỢP 4: BỊ KHÓA
            html = `
                <div class="status-locked">
                    <h2 style="color:red;">Thẻ đã bị khóa</h2>
                    <p>Mã thẻ: <strong>${theInfo.ma_the}</strong></p>
                    <div class="alert-red">Thẻ của bạn hiện không thể sử dụng.</div>
                    <div class="lock-reason">
                        <strong>Lý do khóa:</strong>
                        <span style="color:#c0392b;">${theInfo.ly_do_khoa || 'Không có thông tin'}</span>
                    </div>
                    <p class="status-locked-text">Trạng thái: ${theInfo.status_text}</p>
                    <p class="sub-note">Vui lòng liên hệ thủ thư.</p>
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

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                body: new FormData(form)
            });
            const data = await res.json();
            alert(data.message);
            if (data.status === "success") {
                loadData();
            }
        } catch (err) {
            alert("Lỗi gửi request");
        }
    }
</script>