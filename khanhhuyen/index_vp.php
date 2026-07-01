<?php
require_once __DIR__ . '/../../../../data/connect.php'; 
require_once __DIR__ . '/../../../../data/repositories/ViPhamRepo.php';

$db = (new Database())->getConnection();
$repo = new ViPhamRepo($db);



$tu_khoa = $_GET['tu_khoa'] ?? '';


$limit = 10; 

if (isset($_GET['page'])) {
    
    $page = (int)$_GET['page']; 
} else {
    
    $page = 1;
}
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit; 


$data = $repo->searchVP($tu_khoa, $offset, $limit);


$total_rows = $repo->countTotal($tu_khoa); 
$total_pages = ceil($total_rows / $limit); 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Vi phạm</title>
    <link rel="stylesheet" href="../../../assets/css/ThuThuView/qlvp/index_vp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php if (isset($_GET['status'])): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            window.onload = function() {
                const urlParams = new URLSearchParams(window.location.search);
                const status = urlParams.get('status'); 

                if (status) {
                    if (status === 'success') {
                        Swal.fire({ icon: 'success', title: 'Thành công', text: 'Đã thêm biên bản vi phạm!' });
                    } else if (status === 'deleted') {
                        Swal.fire({ icon: 'success', title: 'Đã xóa', text: 'Biên bản đã được xóa thành công!' });
                    } else if (status === 'error') {
                        Swal.fire({ icon: 'error', title: 'Lỗi', text: 'Có lỗi xảy ra, vui lòng thử lại!' });
                    }

                    const url = new URL(window.location);
                    url.searchParams.delete('status');
                    window.history.replaceState({}, document.title, url);
                }
            }
        </script>
    <?php endif; ?>
    <div class="qlvp-wrapper">
        <div class="header-action" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2><i class="fas fa-gavel"></i> Danh sách vi phạm</h2>

            <div class="search-box">
                <form action="" method="GET" style="display: flex; gap: 5px;">
                    <input type="hidden" name="view" value="qlvp"> 
                    <input type="text" name="tu_khoa" value="<?= htmlspecialchars($tu_khoa) ?>" 
                           placeholder="Tìm mã độc giả, tên..." 
                           style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <button type="submit" style="padding: 8px 15px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            
        </div>

        <table class="vp-table" width="100%" style="border-collapse: collapse; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #f8f9fa; text-align: left; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 15px;">Mã VP</th>
                    <th>Mã PM</th>
                    <th>Độc giả</th>
                    <th>Lý do</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data)): ?>
                    <tr><td colspan="7" style="text-align: center; padding: 20px;">Không tìm thấy dữ liệu vi phạm.</td></tr>
                <?php else: ?>
                    <?php foreach($data as $row): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">#<?= $row['ma_vp'] ?></td>
                        <td style="font-weight: 500; color: #7f8c8d;"><?= $row['ma_pm'] ?></td>
                        <td>
                            <b><?= htmlspecialchars($row['ho_ten']) ?></b><br>
                            <small style="color: #667085;"><?= $row['ma_docgia'] ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['ly_do']) ?></td>
                        <td style="color: #e74c3c; font-weight: bold;">
                            <?= number_format($row['tong_tien_phat']) ?>đ
                        </td>
                        <td>
                            <?php if($row['trang_thai'] == 'Đã nộp' || $row['trang_thai'] == '1'): ?>
                                <span style="color: #2ecc71;"><i class="fas fa-check-circle"></i> Đã nộp</span>
                            <?php else: ?>
                                <span style="color: #f39c12;"><i class="fas fa-clock"></i> Chờ nộp</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="qlvp/update_vp.php?ma_vp=<?= $row['ma_vp'] ?>" 
                               style="color: #3498db; margin-right: 15px; font-size: 18px;" title="Sửa">
                               <i class="fas fa-edit"></i>
                            </a>
                            <a href="/hocphp/pttkpm_QLTV moi/business/api/api_vp.php?action=delete&id=<?= $row['ma_vp'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này?')" 
                               style="color: #e74c3c; font-size: 18px;" title="Xóa">
                               <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="pagination" style="margin-top: 20px; display: flex; justify-content: center; align-items: center; gap: 10px;">
            
            <?php if ($page > 1): ?>
                <a href="?view=qlvp&tu_khoa=<?= urlencode($tu_khoa) ?>&page=<?= $page - 1 ?>" 
                   style="padding: 8px 12px; background: #f8f9fa; border: 1px solid #ddd; text-decoration: none; border-radius: 4px; color: #333;">
                   <i class="fas fa-chevron-left"></i> Trước
                </a>
            <?php endif; ?>

            <span style="padding: 8px 15px; background: #3498db; color: white; border-radius: 4px; font-weight: bold;">
                Trang <?= $page ?> / <?= $total_pages ?>
            </span>

            <?php if ($page < $total_pages): ?>
                <a href="?view=qlvp&tu_khoa=<?= urlencode($tu_khoa) ?>&page=<?= $page + 1 ?>" 
                   style="padding: 8px 12px; background: #f8f9fa; border: 1px solid #ddd; text-decoration: none; border-radius: 4px; color: #333;">
                   Sau <i class="fas fa-chevron-right"></i>
                </a>
            <?php endif; ?>
            
        </div>
    </div>
</body>
</html>
