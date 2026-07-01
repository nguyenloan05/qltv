<?php

$url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/TheLoaiAPI.php";
$url_encoded = str_replace(' ', '%20', $url);
$data = file_get_contents($url_encoded);
$list = json_decode($data, true);
?>

<div class="content-wrapper">
    <div class="header-section">
        <h2><i class="fas fa-tags me-2 text-primary"></i> Quản lý Thể loại</h2>
        <a href="index_tt.php?view=TheLoai_Them" class="btn-add">
            <i class="fas fa-plus-circle"></i> THÊM THỂ LOẠI
        </a>


    </div>

    <div class="data-card">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="150">Mã loại</th>
                    <th>Tên thể loại sách</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>

                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td>
                                <span class="id-text">
                                    #<?php echo htmlspecialchars($row['ma_loai_sach']); ?>
                                </span>
                            </td>

                            <td>
                                <span class="cate-badge">
                                    <i class="fas fa-folder-open me-2" style="font-size: 12px;"></i>
                                    <?php echo htmlspecialchars($row['ten_loai_sach']); ?>
                                </span>
                            </td>

                            <td>
                                <div class="action-group">

                                    
                                    <a href="index_tt.php?view=TheLoai_Sua&ma_loai_sach=<?php echo $row['ma_loai_sach']; ?>&ten_loai_sach=<?php echo urlencode($row['ten_loai_sach']); ?>"
                                        class="btn-circle btn-edit"
                                        data-title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    
                                    <a href="#"
                                        onclick="deleteLoaiSach('<?php echo $row['ma_loai_sach']; ?>')"
                                        class="btn-circle btn-delete"
                                        data-title="Xóa thể loại">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>


                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align:center; padding:20px;">
                            Không có dữ liệu
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>
<script>
    function deleteLoaiSach(ma_loai) {
        if (!confirm("Bạn có chắc chắn muốn xóa thể loại này không?")) return;

        let url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/TheLoaiAPI.php?ma_loai_sach=" + encodeURIComponent(ma_loai);
        fetch(url.replace(/ /g, '%20'), {
                method: "DELETE"
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Xóa thể loại thành công!");
                    location.href = "index_tt.php?view=TheLoaiAPI"; 
                } else {
                    alert("Lỗi: " + (data.message || "Không thể xóa"));
                }
            })
            .catch(err => {
                alert("Lỗi kết nối API");
            });
    }
</script>
