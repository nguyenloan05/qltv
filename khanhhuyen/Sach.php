<?php

$keyword = $_GET['keyword'] ?? '';


$url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/SachAPI.php";


if (!empty($keyword)) {
    $url .= "?keyword=" . urlencode($keyword);
}


$url_encoded = str_replace(' ', '%20', $url);
$data = file_get_contents($url_encoded);
$list = json_decode($data, true);
?>

<div class="content-wrapper">
    
    <div class="header-section">
        <h2>
            <i class="fas fa-layer-group me-2" style="color: var(--primary-gold);"></i> Kho Sách Hệ Thống
        </h2>
        <div class="header-actions">
            <form method="GET" action="index_tt.php" class="search-form">
                <input type="hidden" name="view" value="SachAPI">

                <input type="text" id="searchBox" name="keyword" placeholder="Tìm kiếm sách..."
                    value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
            </form>
            <button class="btn-add-pro" onclick="location.href='index_tt.php?view=Sach_Them'">
                <i class="fas fa-plus"></i> THÊM SÁCH MỚI
            </button>
        </div>
    </div>

    
    <div class="table-container">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Bìa sách</th>
                    <th>Thông tin chi tiết</th>
                    <th style="text-align: center;">Tồn kho</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td width="110">
                                <div class="book-cover-wrapper">
                                    <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/<?php echo !empty($row['image']) ? $row['image'] : 'cover_default.png'; ?>" alt="Cover">


                                </div>
                            </td>
                            <td>
                                <div class="book-title"><?php echo htmlspecialchars($row['ten_sach']); ?></div>
                                <div class="book-meta">
                                    <span><i class="fas fa-bookmark"></i> <?php echo $row['ten_loai_sach'] ?? 'Chưa rõ loại'; ?></span>
                                    <span><i class="fas fa-pen-nib"></i> <?php echo $row['ten_tg'] ?? 'Chưa rõ tác giả'; ?></span>
                                </div>
                                <div style="margin-top: 8px; font-size: 12px; color: #94a3b8; font-weight: 600;">
                                    ID: #<?php echo $row['ma_sach']; ?> | NXB: <?php echo !empty($row['nha_xb']) ? $row['nha_xb'] : 'Chưa cập nhật'; ?>
                                </div>
                            </td>
                            <td align="center">
                                <span class="stock-badge"><?php echo $row['so_luong_hien_tai']; ?></span>
                                <div style="font-size: 11px; color: #94a3b8; font-weight: 700; margin-top: 4px; text-transform: uppercase;">Quyển</div>
                            </td>
                            <td>
                                <div class="action-btns" style="justify-content: flex-end;">
                                    <a href="index_tt.php?view=Sach_Sua&id=<?= $row['ma_sach'] ?>" class="btn-action btn-edit" data-title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button onclick="deletesach('<?php echo $row['ma_sach']; ?>')"
                                        class="btn-icon btn-delete" data-title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:#888;">Không có dữ liệu sách</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 
<script>
    function deletesach(id) {
        if (!confirm("Bạn có chắc chắn muốn xóa sách này không?")) return;

        let url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/SachAPI.php?ma_sach=" + encodeURIComponent(id);
        fetch(url.replace(/ /g, '%20'), {
                method: "DELETE"
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Xóa sách thành công!");
                    location.href = "index_tt.php?view=SachAPI"; 
                } else {
                    alert("Lỗi: " + (data.message || "Không thể xóa"));
                }
            })
            .catch(err => {
                alert("Lỗi kết nối API");
            });
    }
</script>
<script>
    searchBox.oninput = () => {
        clearTimeout(window.t);
        window.t = setTimeout(() => searchBox.form.submit(), 400);
    };
</script>
