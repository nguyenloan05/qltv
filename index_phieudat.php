<link rel="stylesheet"
    href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/phieudat/index_phieudat.css">

<div class="page-container">
    <div class="list-container" id="phieudatList">
      
    </div>
</div>

<script>
    const API_URL = '/hocphp/pttkpm_QLTV moi/business/api/thuthu/phieudat_api.php';

    document.addEventListener('DOMContentLoaded', function() {
        loadData();
    });

    function loadData() {
        fetch(API_URL)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    renderList(res.data);
                }
            })
            .catch(err => console.error('Error loading data:', err));
    }

    function renderList(items) {
        const container = document.getElementById('phieudatList');
        if (!items || items.length === 0) {
            container.innerHTML = '<p>Không có phiếu đặt nào.</p>';
            return;
        }

        container.innerHTML = items.map(item => {
            const status = parseInt(item.trang_thai);
            const imgPath = item.image ?
                `/hocphp/pttkpm_QLTV moi/presentation/assets/images/${item.image}` :
                `/hocphp/pttkpm_QLTV moi/presentation/assets/images/default.png`;

            let actionHtml = '';
            if (status === 0) {
                actionHtml = `
                    <button class="btn btn-success" onclick="handleAction('approve', '${item.ma_pdt}')">✔ Duyệt</button>
                    <button class="btn btn-danger" onclick="handleAction('reject', '${item.ma_pdt}')">✖ Hủy</button>
                `;
            } else if (status === 1) {
                actionHtml = `
                    <button class="btn btn-primary" onclick="handleAction('success', '${item.ma_pdt}')">
                        📦 Đã nhận sách
                    </button>
                `;
            } else if (status === 2) {
                actionHtml = '';
            } else {
                actionHtml = '<span style="color: #000; font-weight: 600;">Đã hủy</span>';
            }

            const hanLaySach = item.han_lay_sach ?
                new Date(item.han_lay_sach).toLocaleDateString('vi-VN') :
                'Chờ duyệt';
            const ngayDat = new Date(item.ngay_dat).toLocaleDateString('vi-VN');

            return `
                <div class="card">
                    <div class="book-image">
                        <img src="${imgPath}" onerror="this.src='/hocphp/pttkpm_QLTV moi/presentation/assets/images/default.png'">
                    </div>
                    <div class="card-content">
                        <h3>${item.ten_sach}</h3>
                        <div class="info-row"><span>👤 Độc giả:</span> <b>${item.ho_ten}</b></div>
                        <div class="info-row"><span>📅 Ngày đặt:</span> <b>${ngayDat}</b></div>
                        <div class="info-row"><span>📅 Hạn trả sách:</span> <b>${hanLaySach}</b></div>
                        <div class="info-row"><span>📦 Còn trong kho:</span> <b>${item.so_luong_hien_tai}</b></div>
                    </div>
                    <div class="card-actions">${actionHtml}</div>
                </div>
            `;
        }).join('');
    }

    function handleAction(action, ma_pdt) {
        let confirmMsg = "";
        switch (action) {
            case 'approve': confirmMsg = "Duyệt phiếu này?"; break;
            case 'reject': confirmMsg = "Hủy phiếu này?"; break;
            case 'success': confirmMsg = "Xác nhận độc giả đã nhận sách?"; break;
        }

        if (!confirm(confirmMsg)) return;

        const formData = new FormData();
        formData.append('action', action);
        formData.append('ma_pdt', ma_pdt);

        fetch(API_URL, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(res => {
                alert(res.message);
                if (res.success) {
                    loadData(); // Reload only the list instead of page
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra!');
            });
    }
</script>
