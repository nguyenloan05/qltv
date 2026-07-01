<?php
require_once __DIR__ . '/../../../business/services/DocGiaService.php';
$service = new DocGiaService();


$ma_dg = $_GET['ma_docgia'] ?? null;

if ($ma_dg) {
    
    $result = $service->delete($ma_dg);

    if ($result) {
        
        header("Location: ../../../index.php?action=admin_dashboard&view=docgia&status=deleted");
    } else {
        echo "<script>
                alert('Lỗi: Không thể xóa độc giả này!');
                window.location.href = '../../../index.php?action=admin_dashboard&view=docgia';
              </script>";
    }
} else {
    header("Location: ../../../index.php?action=admin_dashboard&view=docgia");
}
exit();