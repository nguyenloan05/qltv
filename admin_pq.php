<?php
$update_msg = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_save_pq'])) {
    $update_msg = "success";
}

$sql_stats = "SELECT role, COUNT(*) as total FROM user GROUP BY role";
$res_stats = mysqli_query($conn, $sql_stats);
$stats = [0 => 0, 1 => 0, 2 => 0];
if($res_stats) {
    while($row = mysqli_fetch_assoc($res_stats)) {
        $stats[$row['role']] = $row['total'];
    }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
    :root { --primary-color: #4318ff; --dark-blue: #1b2559; }
    .pq-container { padding: 10px; font-family: 'Segoe UI', sans-serif; }
    .card-custom { background: white; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 25px; margin-bottom: 25px; }
    .pq-table thead th { background-color: #f7f9fb; color: #a3aed0; font-size: 0.85rem; text-transform: uppercase; border: none; padding: 15px; }
    .pq-table tbody td { padding: 15px; vertical-align: middle; color: var(--dark-blue); font-weight: 600; border-bottom: 1px solid #f1f4f9; }
    .permission-title { color: var(--dark-blue); font-weight: 800; font-size: 1.2rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .permission-title i { color: var(--primary-color); }
    .pq-table .form-check-input:checked { background-color: var(--primary-color); border-color: var(--primary-color); }
    .badge-count { background: #e2e8f0; color: #475569; font-size: 0.7rem; padding: 3px 8px; border-radius: 6px; }
    .btn-update-pq { background: var(--primary-color); border-radius: 15px; padding: 12px 30px; font-weight: 700; color: white; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;}
    .btn-update-pq:hover { background: #3311db; color: white;}
</style>

<div class="pq-container">
    <form id="formPQ" method="POST">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 style="color: var(--dark-blue); font-weight: 800;">Phân quyền hệ thống</h2>
                <p class="text-muted">Thiết lập quyền hạn cho từng vai trò trong thư viện</p>
            </div>
            <button type="button" onclick="confirmSavePQ()" class="btn-update-pq">
                <i class="fas fa-shield-alt"></i> Cập nhật quyền
            </button>
            <input type="hidden" name="btn_save_pq" value="1">
        </div>

        <div class="card-custom">
            <div class="permission-title"><i class="fas fa-users-cog"></i> Chi tiết quyền hạn</div>
            <div class="table-responsive">
                <table class="table pq-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Chức năng hệ thống</th>
                            <th class="text-center">Khách</th>
                            <th class="text-center">Độc giả <span class="badge-count"><?= $stats[2] ?></span></th>
                            <th class="text-center">Thủ thư <span class="badge-count"><?= $stats[1] ?></span></th>
                            <th class="text-center">Admin <span class="badge-count"><?= $stats[0] ?></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-light"><td colspan="5" class="fw-bold" style="color: var(--primary-color);">QUẢN LÝ SÁCH & DANH MỤC</td></tr>
                        <tr>
                            <td>Xem thông tin sách</td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked disabled></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked disabled></td>
                        </tr>
                        <tr>
                            <td>Thêm/Sửa/Xóa sách</td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" disabled></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox"></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked disabled></td>
                        </tr>

                        <tr class="table-light"><td colspan="5" class="fw-bold" style="color: var(--primary-color);">MƯỢN TRẢ & XỬ LÝ VI PHẠM</td></tr>
                        <tr>
                            <td>Đăng ký mượn sách Online</td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" disabled></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked disabled></td>
                        </tr>
                        <tr>
                            <td>Phê duyệt phiếu mượn/trả</td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" disabled></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox"></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked disabled></td>
                        </tr>

                        <tr class="table-light"><td colspan="5" class="fw-bold" style="color: var(--primary-color);">QUẢN TRỊ HỆ THỐNG</td></tr>
                        <tr>
                            <td>Cấu hình chính sách & Nội quy</td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" disabled></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox"></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox"></td>
                            <td class="text-center"><input class="form-check-input" type="checkbox" checked disabled></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmSavePQ() {
    Swal.fire({
        title: 'Xác nhận cập nhật phân quyền?',
        text: "Thay đổi sẽ ảnh hưởng đến khả năng truy cập của các thành viên!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4318ff',
        cancelButtonColor: '#707eae',
        confirmButtonText: 'Đồng ý cập nhật',
        cancelButtonText: 'Xem lại'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPQ').submit();
        }
    });
}
</script>

<?php if ($update_msg == "success"): ?>
    <script>Swal.fire('Thành công', 'Quyền hạn đã được cập nhật!', 'success');</script>
<?php endif; ?>
