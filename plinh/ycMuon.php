<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ma_dg = $_SESSION['ma_dg'] ?? 'DG0001'; 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Yêu cầu mượn sách Online</title>
    <link rel="stylesheet" href="presentation/assets/css/DocGiaView/ycMuon.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container-yc">
    <div class="card-header">
        <h2><i class="fas fa-book-reader"></i> Đăng ký mượn sách Online</h2>
        <p>Tìm kiếm và đăng ký mượn cuốn sách yêu thích của bạn</p>
    </div>

    <div class="main-layout">
        <div class="booking-section">
            <form id="formYcMuon" class="styled-form">
                <input type="hidden" name="ma_docgia" value="<?= $ma_dg ?>">
                
                <div class="form-group">
                    <label><i class="fas fa-search"></i> Tìm và chọn sách:</label>
                    <div class="search-wrapper">
                        <input type="text" id="searchSach" placeholder="Nhập tên sách, tác giả...">
                        <i class="fas fa-filter search-icon"></i>
                    </div>
                    <div class="select-container">
                        <select name="ma_sach" id="selectSach" size="8" required>
                            <option value="">-- Đang tải dữ liệu... --</option>
                        </select>
                        <div id="book-detail" class="book-detail-box" style="display:none; margin-top: 10px; padding: 10px; border: 1px dashed #3498db; border-radius: 5px; background: #f0f7ff;">
                            <h4 id="det-ten" style="color: #2c3e50; margin: 0;"></h4>
                            <p id="det-tg" style="margin: 5px 0; font-size: 0.9em;"></p>
                            <p id="det-vitri" style="margin: 5px 0; font-size: 0.9em; color: #e67e22;"></p>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Ngày hẹn lấy:</label>
                        <input type="date" name="ngay_tra_dk" id="ngay_lay" required>
                    </div>
                    <div class="form-group">
                        <label>Số lượng (tối đa 5):</label>
                        <input type="number" name="so_luong" id="so_luong" value="1" min="1" max="5" class="styled-input" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Xác nhận đăng ký
                </button>
            </form>
        </div>

        <div class="policy-section">
            <h3><i class="fas fa-info-circle"></i> Lưu ý mượn sách</h3>
            <ul class="policy-list">
                <li><i class="fas fa-check"></i> Sách được giữ tại quầy trong <b>24h</b>.</li>
                <li><i class="fas fa-check"></i> Tối đa mượn tổng 5 cuốn/lần yêu cầu online.</li>
                <li><i class="fas fa-check"></i> Xuất trình mã yêu cầu hoặc thẻ thư viện khi nhận.</li>
            </ul>
        </div>
    </div>
</div>

<script>
let allBooks = [];

fetch('/hocphp/pttkpm_QLTV moi/business/api/api_PhieuMuon.php?action=get_sach_available')
    .then(res => res.json())
    .then(data => {
        allBooks = data;
        renderBooks(allBooks);
    });


document.getElementById('selectSach').addEventListener('change', function() {
    const maSach = this.value;
    const book = allBooks.find(b => b.ma_sach == maSach);
    const detailBox = document.getElementById('book-detail');
    
    if(book) {
        detailBox.style.display = 'block';
        document.getElementById('det-ten').innerText = book.ten_sach;
        document.getElementById('det-tg').innerText = "Tác giả: " + (book.tac_gia || 'Chưa cập nhật');
        document.getElementById('det-vitri').innerText = "Vị trí kệ: " + (book.vi_tri || 'Khu vực chung');
    }
});


function renderBooks(books) {
    const select = document.getElementById('selectSach');
    if(books.length === 0) {
        select.innerHTML = '<option disabled>❌ Không tìm thấy sách nào</option>';
        return;
    }
    
    let html = '';
    books.forEach(s => {
        const icon = s.so_luong_hien_tai > 0 ? '📖' : '❌';
        const isDisabled = s.so_luong_hien_tai <= 0 ? 'disabled' : '';

        html += `<option value="${s.ma_sach}" ${isDisabled}>
                    ${icon} ${s.ten_sach} [${s.tac_gia || 'N/A'}]
                 </option>`;
    });
    select.innerHTML = html;
}


document.getElementById('searchSach').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase().trim();
    const filtered = allBooks.filter(s => {
        const ten = (s.ten_sach || "").toLowerCase();
        const tg = (s.tac_gia || "").toLowerCase();
        const ma = (s.ma_sach || "").toLowerCase();
        return ten.includes(term) || tg.includes(term) || ma.includes(term);
    });
    renderBooks(filtered);
});

document.getElementById('ngay_lay').valueAsDate = new Date();

document.getElementById('formYcMuon').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('hinh_thuc', 0); 
    
    Swal.fire({
        title: 'Đang xử lý...',
        didOpen: () => { Swal.showLoading() }
    });

    fetch('/hocphp/pttkpm_QLTV moi/business/api/api_PhieuMuon.php?action=add', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            Swal.fire({ icon: 'success', title: 'Thành công!', text: 'Yêu cầu đã được gửi. Bạn có 24h để đến nhận sách.' })
                .then(() => { window.location.reload(); });
        } else {
            Swal.fire({ icon: 'warning', title: 'Chú ý', text: res.message });
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Lỗi', 'Kết nối server thất bại!', 'error');
    });
});
</script>
