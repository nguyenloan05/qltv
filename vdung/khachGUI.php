<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tra cứu sách - UTT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/KhachView/khachGUI.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/KhachView/menuKhach.css?v=<?php echo time(); ?>">

</head>

<body>
    <?php include __DIR__ . '/menuKhach.php'; ?>


    <div class="main-content">
        <div class="header-title">
            <h2>Hệ thống Tra cứu Tài liệu Trực tuyến</h2>
        </div>

        <form id="searchForm" class="search-section">
            <input type="text" id="searchInput" placeholder="Nhập tên sách">
            <button type="submit" class="btn-search">TÌM KIẾM</button>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Ảnh bìa</th>
                        <th>Thông tin Sách</th>
                        <th>Thể loại</th>
                        <th>Năm XB</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="bookTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const form = document.getElementById('searchForm');
        const input = document.getElementById('searchInput');
        const tbody = document.getElementById('bookTableBody');

        function loadBooks(keyword = "") {
            let url = '/hocphp/pttkpm_QLTV moi/business/api/SachAPI.php';
            if (keyword) url += '?keyword=' + encodeURIComponent(keyword);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    let html = "";
                    if (!data || data.length === 0) {
                        html = `<tr><td colspan="5" style="text-align:center; padding:30px">Không tìm thấy tài liệu nào phù hợp.</td></tr>`;
                    } else {
                        data.forEach(sach => {
                            html += `
                                <tr>
                                    <td style="text-align:center">
                                        <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/${sach.image}" class="book-img"
                                             onerror="this.src='https://via.placeholder.com/60x85?text=No+Img'">
                                    </td>
                                    <td>
                                        <div style="font-weight:bold; color:#2c3e50; font-size:1.1rem">${sach.ten_sach}</div>
                                        <small style="color:#7f8c8d">Mã: ${sach.ma_sach}</small>
                                    </td>
<td><span class="tag-loai">${sach.ten_loai_sach || 'Chưa rõ'}</span></td>
                                    <td>${sach.nam_xb}</td>
                                    <td>
                                        <a href="/hocphp/pttkpm_QLTV moi/index.php?action=chi_tiet&ma_sach=${sach.ma_sach}" class="btn-detail">
                                        <i class="fas fa-info-circle"></i> Chi tiết
                                    </a>

                                    </td>
                                </tr>`;
                        });
                    }
                    tbody.innerHTML = html;
                })
                .catch(err => {
                    console.error("Lỗi API:", err);
                    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding:30px">Lỗi tải dữ liệu.</td></tr>`;
                });
        }

        
        loadBooks();
        form.addEventListener('submit', e => {
            e.preventDefault();
            loadBooks(input.value.trim());
        });
    </script>
</body>

</html>