<?php

$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Cookie: PHPSESSID=" . session_id() . "\r\n"
    ]
];
$context = stream_context_create($opts);

$keyword = $_GET['keyword'] ?? '';
$url = "http://localhost/hocphp/pttkpm_QLTV%20moi/business/api/DocGiaAPI.php";
if ($keyword) {
    $url .= "?keyword=" . urlencode($keyword);
}

$data = @file_get_contents($url, false, $context);
$list = $data ? json_decode($data, true) : [];
?>

<head>
    <link rel="stylesheet" href="presentation/assets/css/AdminView/DocGia.css">
</head>

<div class="content-wrapper">
    <div class="header-section">
        <h2>
            <i class="fas fa-users-viewfinder me-2" style="color: var(--primary-gold);"></i> Hệ thống Độc giả
        </h2>
        <div class="header-actions">
            <form method="GET" action="DocGia.php" class="search-form" onsubmit="return false;">
                <input type="text" id="searchInput" name="keyword" placeholder="Tìm kiếm độc giả..."
                    value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
            </form>
            <button class="btn-add-pro" onclick="location.href='index.php?action=admin_dashboard&view=addDocGia'">
                <i class="fas fa-plus"></i> THÊM ĐỘC GIẢ MỚI
            </button>
        </div>
    </div>

    <div class="table-container">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Ảnh chân dung</th>
                    <th>Thông tin chi tiết</th>
                    <th style="text-align: center;">Liên hệ</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody id="docGiaTableBody">
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td width="110">
                                <div class="book-cover-wrapper">
                                    <img src="presentation/assets/images/<?php echo !empty($row['anh_chan_dung']) ? $row['anh_chan_dung'] : 'dd1.jfif'; ?>" 
                                         alt="Avatar" 
                                         onerror="this.src='presentation/assets/images/dd1.jfif'">
                                </div>
                            </td>
                            <td>
                                <div class="book-title"><?php echo htmlspecialchars($row['ho_ten']); ?></div>
                                <div class="book-meta">
                                    <span><i class="fas fa-id-card"></i> Mã: <?php echo $row['ma_docgia']; ?></span>
                                    <span><i class="fas fa-map-marker-alt"></i> <?php echo $row['dia_chi'] ?: 'Chưa có địa chỉ'; ?></span>
                                </div>
                                <div style="margin-top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">
                                    ID hệ thống: #<?php echo $row['ma_docgia']; ?>
                                </div>
                            </td>
                            <td align="center">
                                <div style="font-size: 11px; color: #94a3b8; font-weight: 700; margin-top: 4px; text-transform: lowercase;">
                                    <?php echo $row['email'] ?: 'Chưa cập nhật email'; ?>
                                </div>
                            </td>
                            <td>
                                <div class="action-btns" style="justify-content: flex-end;">
                                   <a href="index.php?action=admin_dashboard&view=updateDocGia&ma_docgia=<?php echo $row['ma_docgia']; ?>" 
                                    class="btn-icon btn-edit" data-title="Xem hồ sơ chi tiết">
                                    <i class="fas fa-eye"></i>
                                   </a>
                                    <button onclick="if(confirm('Xóa độc giả này?')) location.href='presentation/views/AdminView/deleteDocGia.php?ma_docgia=<?php echo $row['ma_docgia']; ?>'"
                                        class="btn-icon btn-delete" data-title="Xóa khỏi hệ thống">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:#888;">Không có dữ liệu độc giả</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const keyword = this.value.trim(); 
    const tableBody = document.getElementById('docGiaTableBody');
    
    let apiUrl = "http://localhost/hocphp/pttkpm_QLTV%20moi/business/api/DocGiaAPI.php";
    if (keyword !== "") { 
        apiUrl += "?keyword=" + encodeURIComponent(keyword);
    }

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = ""; 

            if (!data || data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" style="text-align:center; color:#888;">Không tìm thấy độc giả</td></tr>';
                return;
            }

            data.forEach(row => {
                const avatar = row.anh_chan_dung ? row.anh_chan_dung : 'dd1.jfif';
                const diaChi = row.dia_chi ? row.dia_chi : 'Chưa có địa chỉ';
                const email = row.email ? row.email : 'Chưa cập nhật email';
                
                const tr = `
                    <tr>
                        <td width="110">
                            <div class="book-cover-wrapper">
                                <img src="presentation/assets/images/${avatar}" onerror="this.src='presentation/assets/images/dd1.jfif'">
                            </div>
                        </td>
                        <td>
                            <div class="book-title">${row.ho_ten}</div>
                            <div class="book-meta">
                                <span><i class="fas fa-id-card"></i> Mã: ${row.ma_docgia}</span>
                                <span><i class="fas fa-map-marker-alt"></i> ${diaChi}</span>
                            </div>
                            <div style="margin-top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">
                                ID hệ thống: #${row.ma_docgia}
                            </div>
                        </td>
                        <td align="center">
                            <div style="font-size: 11px; color: #94a3b8; font-weight: 700; margin-top: 4px;">${email}</div>
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content: flex-end;">
                                <a href="index.php?action=admin_dashboard&view=updateDocGia&ma_docgia=${row.ma_docgia}" class="btn-icon btn-edit"><i class="fas fa-eye"></i></a>
                                <button onclick="if(confirm('Xóa độc giả này?')) location.href='presentation/views/AdminView/deleteDocGia.php?ma_docgia=${row.ma_docgia}'" class="btn-icon btn-delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', tr);
            });
        })
        .catch(error => console.error('Lỗi:', error));
});
</script>