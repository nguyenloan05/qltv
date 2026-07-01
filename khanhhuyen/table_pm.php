<?php

if (!function_exists('formatDateView')) {
    function formatDateView($date, $default = "---") {
        if (empty($date) || $date == '0000-00-00' || $date == 'NULL' || $date == null) {
            return '<span style="color:#bdc3c7; font-style:italic;">' . $default . '</span>';
        }
        return date('d/m/Y', strtotime($date));
    }
}


$status_map = [
    0 => ['label' => 'Chờ duyệt', 'color' => '#f39c12', 'icon' => 'fa-hourglass-half'],
    1 => ['label' => 'Đang mượn', 'color' => '#3498db', 'icon' => 'fa-book-open'],
    2 => ['label' => 'Đã trả',    'color' => '#2ecc71', 'icon' => 'fa-check'],
    3 => ['label' => 'Vi phạm',   'color' => '#e67e22', 'icon' => 'fa-gavel'], 
    4 => ['label' => 'Đã hủy',    'color' => '#e74c3c', 'icon' => 'fa-ban']
];
?>

<table width="100%" style="border-collapse: collapse; table-layout: fixed; background: white;">
    <thead>
        <tr style="text-align: left; background: #fcfcfc; border-bottom: 2px solid #f1f1f1; color: #7f8c8d; font-size: 14px;">
            <th style="padding: 18px; width: 12%;">Mã PM</th>
            <th style="width: 16%;">Độc giả</th>
            <th style="width: 22%;">Sách mượn</th>
            <th style="width: 12%;">Tổng phí mượn</th>
            <th style="width: 10%;">Hình thức</th>
            <th style="width: 10%;">Ngày mượn</th>
            <th style="width: 10%;">Hạn trả</th>
            <th style="width: 12%;">Trạng thái</th>
            <th style="text-align: center; width: 100px;">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        if (!empty($dsPhieuMuon)): 
            foreach ($dsPhieuMuon as $pm): 
                $st = $status_map[$pm['tinh_trang']] ?? ['label' => 'N/A', 'color' => '#95a5a6', 'icon' => 'fa-question'];
        ?>
            <tr style="border-bottom: 1px solid #f9f9f9; transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                
                
                <td style="padding: 18px; font-weight: bold; color: #2c3e50; font-size: 13px;">
                    <?= $pm['ma_pm'] ?>
                </td>

                <td>
                    <div style="font-weight: 600; color: #2c3e50; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= htmlspecialchars($pm['ho_ten']) ?>
                    </div>
                    <small style="color: #95a5a6;">Mã: <?= $pm['ma_docgia'] ?></small> 
                </td>

                
                <td>
                    <div style="color: #34495e; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($pm['ten_sach']) ?>">
                        <?= htmlspecialchars($pm['ten_sach']) ?>
                    </div>
                    <small style="color: #95a5a6;">Số lượng: <?= $pm['so_luong'] ?></small>
                </td>

                <td style="font-size: 13px; font-weight: 600; color: #27ae60;">
                    <?php 
                        $tong_phi = $pm['so_luong'] * 3000; 
                        echo number_format($tong_phi, 0, ',', '.') . ' đ'; 
                    ?>
                </td>

                
                <td style="font-size: 13px;">
                    <span style="color: <?= $pm['hinh_thuc'] == 0 ? '#8e44ad' : '#2980b9' ?>;">
                        <?= $pm['hinh_thuc'] == 0 ? 'Online' : 'Tại quầy' ?>
                    </span>
                </td>
                
                
                <td style="font-size: 13px;"><?= formatDateView($pm['ngay_muon']) ?></td>
                <td style="font-size: 13px; color: #e67e22; font-weight: 500;"><?= formatDateView($pm['ngay_tra_du_kien']) ?></td>

                
                <td>
                    <span class="badge" style="background: <?= $st['color'] ?>15; color: <?= $st['color'] ?>; padding: 5px 12px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block;">
                        <i class="fas <?= $st['icon'] ?>" style="font-size: 9px; margin-right: 4px;"></i> <?= $st['label'] ?>
                    </span>
                    
                </td>

                
                <td style="text-align: center; white-space: nowrap;">
                    <a href="qlpm/update_pm.php?id=<?= $pm['ma_pm'] ?>" 
                       style="color: #3498db; margin: 0 5px; text-decoration: none;" title="Cập nhật">
                        <i class="fas fa-edit"></i>
                    </a>

                    
                    <button onclick="deletePhieuMuon('<?= $pm['ma_pm'] ?>')" 
                            style="color: #e74c3c; margin: 0 5px; background: none; border: none; cursor: pointer;" 
                            title="Xóa">
                        <i class="fas fa-trash"></i>
                    </button>

                    <a href="qlvp/add_vp.php?ma_pm=<?= $pm['ma_pm'] ?>" 
                        style="color: #e67e22; margin: 0 5px; text-decoration: none;" title="Xử lý vi phạm">
                            <i class="fas fa-gavel"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="8" style="padding: 80px 20px; text-align: center; color: #95a5a6;">
                    <div style="font-size: 40px; opacity: 0.2; margin-bottom: 10px;"><i class="fas fa-folder-open"></i></div>
                    <strong style="letter-spacing: 1px;">KHÔNG CÓ PHIẾU MƯỢN NÀO</strong>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>