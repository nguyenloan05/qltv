<?php
require_once __DIR__ . '/../../../data/models/TacGiaModel.php';
require_once __DIR__ . '/../../../business/services/TacGiaService.php';

if (isset($_POST['btnLuu'])) {
    try {
        $tg = new TacGiaModel(
            null,
            $_POST['ten_tg'],
            $_POST['gioi_tinh'] ?? 0,
            !empty($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : null,
            $_POST['que'] ?? null,
            $_POST['tieu_su'] ?? null,
            null
        );

        $service = new TacGiaService();
        $service->add($tg, $_FILES);

        header("Location: index_tt.php?view=tacgia&success=1");
        exit;
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

?>

<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-blue: #2563eb;
        --soft-bg: #f8fafc;
        --main-font: 'Be Vietnam Pro', sans-serif;
    }

    .content-wrapper {
        padding: 40px;
        background: var(--soft-bg);
        min-height: 100vh;
        font-family: var(--main-font);
    }

    .form-card {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
    }

    .form-group-custom {
        margin-bottom: 30px;
    }

    .title-system {
        font-weight: 800;
        color: #1e293b;
        font-size: 26px;
        margin-top: 15px;
    }

    .form-label {
        font-weight: 700;
        color: #1e293b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 14px 18px;
        border-radius: 14px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        transition: 0.3s;
        font-weight: 500;
        font-family: var(--main-font);
    }

    .form-control-custom:focus {
        border-color: var(--primary-blue);
        background: white;
        outline: none;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .btn-submit {
        width: 100%;
        padding: 18px;
        border-radius: 14px;
        background: var(--primary-blue);
        color: white;
        border: none;
        font-weight: 800;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 10px;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        font-family: var(--main-font);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        background: #1d4ed8;
    }

    .upload-area {
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        padding: 30px;
        border-radius: 18px;
        text-align: center;
    }
</style>

<div class="content-wrapper">
    <a href="index_tt.php?view=tacgia" style="text-decoration: none; color: #64748b; font-weight: 600; margin-bottom: 20px; display: inline-block;">
        <i class="fas fa-chevron-left"></i> QUAY LẠI DANH SÁCH
    </a>

    <div class="form-card">
        <div class="text-center mb-5">
            <div style="background: #eff6ff; width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <i class="fas fa-user-pen" style="color: var(--primary-blue); font-size: 24px;"></i>
            </div>
            <h2 class="title-system">Thêm Tác Giả</h2>
            <p class="text-muted small">Vui lòng điền thông tin tác giả sách mới</p>
        </div>

        <form method="POST" enctype="multipart/form-data">


            <div class="form-group-custom">
                <label class="form-label">HỌ VÀ TÊN TÁC GIẢ (*)</label>
                <input type="text" name="ten_tg" class="form-control-custom"
                    placeholder="Nhập tên đầy đủ..." required>
            </div>

            <div class="row">
                <div class="col-md-6 form-group-custom">
                    <label class="form-label">NGÀY SINH</label>
                    <input type="date" name="ngay_sinh" class="form-control-custom">
                </div>
                <div class="col-md-6 form-group-custom">
                    <label class="form-label">QUÊ QUÁN</label>
                    <input type="text" name="que" class="form-control-custom"
                        placeholder="VD: Hà Nội...">
                </div>
            </div>
            <div class="form-group-custom">
                <label class="form-label">GIỚI TÍNH</label>
                <select name="gioi_tinh" class="form-control-custom">
                    <option value="1">Nam</option>
                    <option value="0">Nữ</option>
                </select>
            </div>

            <div class="form-group-custom">
                <label class="form-label">TIỂU SỬ</label>
                <textarea name="tieu_su" class="form-control-custom" rows="6"
                    placeholder="Nhập tiểu sử tác giả..."></textarea>
            </div>
            <div class="form-group-custom">
                <label class="form-label">ẢNH ĐẠI DIỆN</label>
                <div class="upload-area">
                    <input type="file" name="hinh" id="hinh-input" class="d-none" accept="image/*" onchange="previewImage(this)" style="display: none;">
                    <label for="hinh-input" style="cursor: pointer;">
                        <i class="fas fa-cloud-upload-alt fa-2x mb-2" style="color: var(--primary-blue);"></i><br>
                        <span style="color: var(--primary-blue); font-weight: 700;">Nhấn để chọn ảnh</span>
                    </label>
                    <div id="image-preview-container" style="display: none; margin-top: 15px;">
                        <img id="img-show" style="width: 100px; height: 100px; object-fit: cover; border-radius: 15px; border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>


            <button type="submit" name="btnLuu" class="btn-submit">
                XÁC NHẬN LƯU TÁC GIẢ
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