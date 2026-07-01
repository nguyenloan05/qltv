<link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/ThuThuView/card/index_card.css">

<div id="cardGrid" class="card-grid">

</div>

<script>
    const API_URL = '/hocphp/pttkpm_QLTV moi/business/api/thuthu/card_api.php';

    document.addEventListener('DOMContentLoaded', function() {
        loadCards();
    });

    async function loadCards() {
        try {
            const res = await fetch(API_URL);
            const json = await res.json();
            if (json.success) {
                renderCards(json.data);
            }
        } catch (err) {
            console.error('Error loading cards:', err);
        }
    }

    function renderCards(cards) {
        const container = document.getElementById('cardGrid');
        if (!cards || cards.length === 0) {
            container.innerHTML = '<p>Không có thẻ nào.</p>';
            return;
        }

        container.innerHTML = cards.map(row => {
            const status = parseInt(row.trang_thai ?? 0);
            const avatar = row.anh_chan_dung ? row.anh_chan_dung : 'user.png';
            const maThe = row.ma_the ? row.ma_the : '<i style="color:gray">Đang chờ cấp...</i>';

            let actionHtml = `
                <a href="index_tt.php?view=card_detail&id=${row.id}" class="btn-circle" title="Xem chi tiết">
                    <i class="fas fa-eye"></i>
                </a>
            `;

            if (status === 0) {
                actionHtml += `
                    <button class="btn btn-blue" onclick="handleApproveAuto('${row.id}')">
                        Duyệt & Cấp mã tự động
                    </button>
                `;
            } else if (status === 1) {
                actionHtml += `
                    <button class="btn btn-red" onclick="handleLockCard('${row.id}')">
                        Khóa thẻ
                    </button>
                `;
            } else if (status === 2) {
                actionHtml += `
                    <button class="btn btn-blue" onclick="handleUnlock('${row.id}')">
                        Mở khóa
                    </button>
                `;
            }

            return `
                <div class="card-item">
                    <div style="display:flex; gap:15px; align-items:center;">
                        <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/${avatar}" class="avatar">
                        <div>
                            <b>${row.ho_ten}</b><br>
                            <small>${row.email}</small>
                        </div>
                    </div>
                    <hr>
                    <p><b>Mã thẻ:</b> ${maThe}</p>
                    <p>
                        <b>Trạng thái:</b>
                        <span class="status st-${status}">    
                             ${row.status_text}
                        </span>
                    </p>
                    <div style="display: flex; gap: 5px; align-items: center; flex-wrap: wrap;">
                        ${actionHtml}
                    </div>
                </div>
            `;
        }).join('');
    }

    function handleApproveAuto(id) {
        if (!confirm("Hệ thống sẽ tự động tạo mã thẻ LIBxxxxxx và kích hoạt. Xác nhận?")) return;
        callApi({
            action: 'activate_auto',
            id: id
        });
    }

    function handleLockCard(id) {
        let lyDo = prompt("Nhập lý do khóa thẻ:", "");
        if (!lyDo) {
            alert("Bạn chưa nhập lý do khóa thẻ!");
            return;
        }

        callApi({
            action: 'lock',
            id: id,
            ly_do_khoa: lyDo
        });
    }

    function handleUnlock(id) {
        if (!confirm("Mở khóa thẻ này?")) return;
        callApi({
            action: 'unlock',
            id: id
        });
    }

    function callApi(data) {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }

        fetch(API_URL, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(res => {
                alert(res.message);
                if (res.success) {
                    loadCards(); // Reload only the grid
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra!');
            });
    }
</script>