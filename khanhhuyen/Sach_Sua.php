<?php
require_once __DIR__ . '/../../../data/models/SachModel.php';
require_once __DIR__ . '/../../../business/services/SachService.php';
require_once __DIR__ . '/../../../business/services/TacGiaService.php';
require_once __DIR__ . '/../../../business/services/TheLoaiService.php';

$service = new SachService();
$tacGiaService = new TacGiaService();
$theLoaiService = new TheLoaiService();

$listTacGia = $tacGiaService->getAll();
$listTheLoai = $theLoaiService->getAll();


$id = $_GET['id'] ?? null;
if (!$id) {
    die("Thiếu ID sách");
}

$sach = $service->getById($id);
if (!$sach) {
    die("Không tìm thấy sách");
}


if (isset($_POST['btnLuu'])) {
    try {
        $soLuongTong = $_POST['so_luong_tong'] ?? 0;
        $tinhTrang = ($soLuongTong == 0) ? 0 : 1;

        $updateSach = new SachModel(
            $id,
            $_POST['ten_sach'],
            $_POST['ma_loai_sach'],
            $_POST['nha_xb'] ?? '',
            $_POST['nam_xb'] ?? '',
            $tinhTrang,
            $_POST['mo_ta'] ?? '',
            $sach->getImage(), 
            $_POST['ma_tg'],
            $soLuongTong,
            $_POST['so_luong_hien_tai'] ?? $soLuongTong,
            $_POST['vi_tri'] ?? ''
        );

        $service->update($updateSach, $_FILES);

        header("Location: index_tt.php?view=SachAPI&update=1");
        exit;
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

?>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-blue: #2563eb;
        --soft-bg: #f8fafc;
        --main-font: 'Be Vietnam Pro', sans-serif;
        --border-color: #e2e8f0;
    }

    .content-wrapper {
        padding: 40px;
        background: var(--soft-bg);
        min-height: 100vh;
        font-family: var(--main-font);
    }

    .form-card {
        max-width: 900px;
       
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid var(--border-color);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
    }

 
    .row-custom {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }

    .col-custom {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 15px;
        box-sizing: border-box;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        font-family: var(--main-font);
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        border-radius: 14px;
        background: var(--primary-blue);
        color: white;
        font-weight: 700;
        font-size: 16px;
        border: none;
        cursor: pointer;
        margin-top: 20px;
        transition: opacity 0.3s;
    }

    .btn-submit:hover {
        opacity: 0.9;
    }

    .upload-area {
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        padding: 20px;
        border-radius: 18px;
        text-align: center;
    }

    textarea.form-control-custom {
        resize: vertical;
    }

    @media (max-width: 768px) {
        .col-custom {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .content-wrapper {
            margin-left: 0;
            padding: 20px;
        }
    }
</style>
<div class="content-wrapper">
    <a href="index_tt.php?view=sach" style="text-decoration: none; color: #64748b; font-weight: 600; margin-bottom: 20px; display: inline-block;">
        <i class="fas fa-chevron-left"></i> QUAY LẠI DANH SÁCH
    </a>
    <div class="form-card">

        <h2 style="text-align:center;">SỬA SÁCH</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="row-custom">

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">TÊN SÁCH</label>
                    <input type="text" name="ten_sach" class="form-control-custom"
                        value="<?= htmlspecialchars($sach->getTenSach()) ?>" readonly>
                </div>

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">TÁC GIẢ</label>
                    <select name="ma_tg" class="form-control-custom">
                        <?php foreach ($listTacGia as $tg): ?>
                            <option value="<?= $tg->getMaTG() ?>"
                                <?= $tg->getMaTG() == $sach->getMaTG() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tg->getTenTG()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">NHÀ XUẤT BẢN</label>
                    <input type="text" name="nha_xb" class="form-control-custom"
                        value="<?= htmlspecialchars($sach->getNhaXB()) ?>">
                </div>

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">NĂM XUẤT BẢN</label>
                    <input type="number" name="nam_xb" class="form-control-custom"
                        value="<?= $sach->getNamXB() ?>">
                </div>

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">SỐ LƯỢNG TỔNG</label>
                    <input type="number" name="so_luong_tong" class="form-control-custom" readonly
                        value="<?= $sach->getSoLuongTong() ?>" min="0">
                </div>
                <div class="col-custom form-group-custom">
                    <label class="form-label">SỐ LƯỢNG HIỆN TẠI</label>
                    <input type="number" name="so_luong_hien_tai" class="form-control-custom" readonly
                        value="<?= $sach->getSoLuongHienTai() ?>" min="0">
                </div>

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">THỂ LOẠI</label>
                    <select name="ma_loai_sach" class="form-control-custom">
                        <?php foreach ($listTheLoai as $loai): ?>
                            <option value="<?= $loai->getMaLoaiSach() ?>"
                                <?= $loai->getMaLoaiSach() == $sach->getMaLoaiSach() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($loai->getTenLoaiSach()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">TÌNH TRẠNG</label>
                    <select name="tinh_trang" class="form-control-custom" readonly>
                        <option value="1" <?= $sach->getTinhTrang() == 1 ? 'selected' : '' ?>>Còn</option>
                        <option value="0" <?= $sach->getTinhTrang() == 0 ? 'selected' : '' ?>>Hết</option>
                    </select>
                </div>

                
                <div class="col-custom form-group-custom">
                    <label class="form-label">VỊ TRÍ</label>
                    <input type="text" name="vi_tri" class="form-control-custom"
                        value="<?= htmlspecialchars($sach->getViTri()) ?>">
                </div>

            </div>

            
            <div class="form-group-custom">
                <label class="form-label">MÔ TẢ</label>
                <textarea name="mo_ta" class="form-control-custom" rows="3"><?= htmlspecialchars($sach->getMoTa()) ?></textarea>
            </div>

            <div class="form-group-custom">
                <label class="form-label">ẢNH BÌA</label>
                <div class="upload-area">
                    <input type="file" name="image" id="image-input"
                        accept="image/*"
                        onchange="previewImage(this)"
                        style="opacity:0; position:absolute; z-index:-1;">
                    <label for="image-input" style="cursor: pointer;">
                        <i class="fas fa-cloud-upload-alt fa-2x mb-2" style="color: var(--primary-blue);"></i><br>
                        <span style="color: var(--primary-blue); font-weight: 700;">Nhấn để chọn ảnh</span>
                    </label>
                    <div id="image-preview-container" style="margin-top: 15px;">
                        <img id="img-show"
                            src="<?= $sach->getImage() ? '/hocphp/pttkpm_QLTV moi/presentation/assets/images/' . $sach->getImage() : '#' ?>"
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 15px;">
                    </div>

                </div>
            </div>

            <button type="submit" name="btnLuu" class="btn-submit">
                CẬP NHẬT SÁCH
            </button>
        </form>

    </div>
</div>
<script>
    function previewImage(input) {
        var preview = document.getElementById('img-show');
        var container = document.getElementById('image-preview-container');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;

                container.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
