<?php


$url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/TacGiaAPI.php?action=getAll";
$url_encoded = str_replace(' ', '%20', $url);
$data = file_get_contents($url_encoded);
$list = json_decode($data, true);
?>

<div class="content-wrapper">

        
        <div class="header-section">
            <h2><i class="fas fa-pen-nib"></i> Danh sách Tác giả</h2>

            <a href="index_tt.php?view=TacGia_Them" class="btn-add-custom">
                <i class="fas fa-plus-circle"></i> THÊM TÁC GIẢ
            </a>
        </div>

        
        <div class="data-card">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Thông tin tác giả</th>
                        <th>Quê quán</th>
                        <th>Ngày sinh</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($list)): ?>
                        <?php foreach ($list as $row): ?>
                            <tr>
                                <td>
                                    <div class="author-info">
                                        <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/<?php echo !empty($row['hinh']) ? $row['hinh'] : 'author_default.png'; ?>" class="author-avatar">

                                        <div>
                                            <p class="author-name"><?= htmlspecialchars($row['ten_tg']) ?></p>
                                            <span class="author-id">Mã: #<?= $row['ma_tg'] ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="loc-badge">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= !empty($row['que']) ? $row['que'] : '<span class="not-updated">Chưa cập nhật</span>' ?>
                                    </div>
                                </td>

                                <td>
                                    <?php
                                    if (empty($row['ngay_sinh']) || $row['ngay_sinh'] == '0000-00-00') {
                                        echo '<span class="not-updated">Chưa cập nhật</span>';
                                    } else {
                                        echo date('d/m/Y', strtotime($row['ngay_sinh']));
                                    }
                                    ?>
                                </td>

                                <td>
                                    <div class="action-group" style="justify-content: center;">

                                        
                                        <a href="index_tt.php?view=TacGia_Sua&id=<?= $row['ma_tg'] ?>" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        
                                        <button class="btn-action btn-delete" onclick="deleteTG(<?= $row['ma_tg'] ?>)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center;">Không có dữ liệu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    
    <script>
        function deleteTG(id) {
            if (!confirm("Bạn có chắc chắn muốn xóa tác giả này không?")) return;

            let url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/TacGiaAPI.php?ma_tg=" + encodeURIComponent(id);
            fetch(url.replace(/ /g, '%20'), {
                    method: "DELETE"
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Xóa tác giả thành công!");
                        location.href = "index_tt.php?view=TacGiaAPI";
                    } else {
                        alert("Lỗi: " + (data.message || "Không thể xóa"));
                    }
                })
                .catch(err => {
                    alert("Lỗi kết nối API");
                });
        }
    </script>

