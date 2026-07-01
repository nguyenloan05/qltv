<div class="container py-4">

    <h3>📚 Danh sách sách</h3>


    <div class="input-group mb-3">
        <input id="searchInput" class="form-control" placeholder="Tên sách / tác giả...">
        <button class="btn btn-primary" id="btnSearch">Tìm</button>
    </div>


    <div class="row" id="bookList"></div>

</div>

<script>
    const API = "/hocphp/pttkpm_QLTV moi/business/api/docgia/pd_docgia_api.php";

    window.onload = loadData;

    async function datSach(maSach) {

        try {
            let form = new URLSearchParams();
            form.append("action", "datSach");
            form.append("ma_sach", maSach);

            let res = await fetch(API, {
                method: "POST",
                body: form
            });

            let json = await res.json();

            alert(json.message);

            loadData(); // chỉ reload list
        } catch (err) {
            console.error(err);
            alert("Lỗi kết nối server");
        }
    }

    async function loadData() {

        let keyword = document.getElementById("searchInput").value || "";

        let res = await fetch(API + "?search=" + encodeURIComponent(keyword));

        let json = await res.json();

        let data = json.data || [];

        let html = "";

        data.forEach(book => {

            let conHang = book.so_luong_hien_tai > 0;

            let statusText = "";
            let btnHTML = "";

            switch (book.trang_thai) {

                case 0:
                    statusText = "⏳ Chờ duyệt";
                    btnHTML = `
        <button class="btn btn-danger w-100"
            onclick="huySach(${book.ma_pdt}, ${book.ma_sach})">
            ❌ Hủy đặt
        </button>
    `;
                    break;

                case 1:
                    statusText = "📦 Chờ lấy";
                    btnHTML = `<button class="btn btn-info w-100" disabled>Chờ lấy</button>`;
                    break;

                case 2:
                    statusText = "✅ Đã lấy";
                    btnHTML = `<button class="btn btn-success w-100" disabled>Đã nhận</button>`;
                    break;


                default:
                    statusText = "🆕 Chưa đặt";
                    btnHTML = conHang ?
                        `<button type="button"
        class="btn btn-primary w-100"
        onclick="datSach(${book.ma_sach})">
        📚 Đặt sách
    </button>` :
                        `<button class="btn btn-secondary w-100" disabled>
        ❌ Hết sách
    </button>`;
            }

            html += `
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">

                <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/${book.image}"
                     class="card-img-top"
                     style="height:180px; object-fit:contain; padding: 5px">

                <div class="card-body d-flex flex-column">

                    <h6>${book.ten_sach}</h6>
                    <small>${book.ten_tg}</small>

                    <p>Còn: <b>${book.so_luong_hien_tai}</b></p>

                    <p class="text-muted">${statusText}</p>

                    <div class="mt-auto">
                        ${btnHTML}
                    </div>

                </div>
            </div>
        </div>`;
        });

        document.getElementById("bookList").innerHTML = html;
    }

    async function huySach(maPdt, maSach) {
        if (!confirm("Bạn có chắc muốn hủy đặt sách này ??????????")) {
            return;
        }

        try {
            let form = new URLSearchParams();
            form.append("action", "huyDat");
            form.append("ma_pdt", maPdt);
            form.append("ma_sach", maSach);

            let res = await fetch(API, {
                method: "POST",
                body: form
            });

            let json = await res.json();

            alert(json.message);

            loadData();
        } catch (err) {
            console.log("[phieudat.php] Lỗi hủy đặt" + err);
            alert("Lỗi hủy đặt");
        }
    }

    document.getElementById("btnSearch").addEventListener("click", function() {
        loadData();
    });
</script>