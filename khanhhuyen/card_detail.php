<link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/card/card_detail.css">

<div id="cardDetailContainer" class="content-wrapper">
    
</div>

<script>
    const API_URL = '../../../business/api/thuthu/card_api.php';

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        if (id) {
            loadCardDetail(id);
        } else {
            document.getElementById('cardDetailContainer').innerHTML = '<p>ID không hợp lệ</p>';
        }
    });

    async function loadCardDetail(id) {
        try {
            const res = await fetch(`${API_URL}?id=${id}`);
            const json = await res.json();
            if (json.success) {
                renderDetail(json.data);
            } else {
                document.getElementById('cardDetailContainer').innerHTML = `<p>${json.message}</p>`;
            }
        } catch (err) {
            console.error('Error loading card detail:', err);
        }
    }

    function renderDetail(card) {
        const container = document.getElementById('cardDetailContainer');
        const avatar = card.anh_chan_dung ? card.anh_chan_dung : 'user.png';
        const ngayCap = card.ngay_cap ? new Date(card.ngay_cap).toLocaleDateString('vi-VN') : '--';
        const ngayHetHan = card.ngay_het_han ? new Date(card.ngay_het_han).toLocaleDateString('vi-VN') : '--';

        container.innerHTML = `
            <a href="index_tt.php?view=card" class="btn-back">← Quay lại</a>
            <div class="card-detail">
                <div class="detail-sidebar">
                    <img class="avatar-large" src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/${avatar}">
                    <h3>${card.ho_ten || '---'}</h3>
                    <p>${card.email || '---'}</p>
                </div>
                <div class="detail-main">
                    <div class="info-group">
                        <span class="info-label">Mã độc giả</span>
                        <div class="info-value">${card.ma_docgia || '---'}</div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Mã thẻ</span>
                        <div class="info-value">${card.ma_the || 'Chưa có'}</div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Trạng thái</span>
                        <div class="info-value">
                            <span class="status st-${parseInt(card.trang_thai)}">
                                
                                ${card.status_text}
                            </span>
                        </div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Ngày cấp</span>
                        <div class="info-value">${ngayCap}</div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Hạn thẻ</span>
                        <div class="info-value">${ngayHetHan}</div>
                    </div>
                </div>
            </div>
        `;
    }
</script>
