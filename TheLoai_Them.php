<?php

function generateCategoryCode()
{
    $prefix = "LS";
    $timePart = substr(time(), -4);
    $randomPart = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    return $prefix . $timePart . $randomPart;
}

$auto_ma = generateCategoryCode();
?>

<style>
        :root {
            --primary-blue: #2563eb;
            --error-red: #ef4444;
            --soft-bg: #f8fafc;
            --text-dark: #1e293b;
            --main-font: 'Be Vietnam Pro', sans-serif;
        }

        .content-wrapper {
            padding: 40px;
            background: var(--soft-bg);
            min-height: 100vh;
            font-family: var(--main-font);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 25px;
            transition: 0.2s;
            font-size: 14px;
        }

        .back-link:hover {
            color: var(--primary-blue);
        }

        .form-card {
            max-width: 550px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            padding: 45px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }

        .icon-box {
            width: 64px;
            height: 64px;
            background: #eff6ff;
            color: var(--primary-blue);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 26px;
        }

        .form-card h3 {
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            font-size: 24px;
            letter-spacing: -0.5px;
        }

        .form-label {
            font-weight: 700;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            display: block;
        }

        .form-control-custom {
            width: 100%;
            padding: 15px 20px;
            border-radius: 16px;
            border: 2px solid #f1f5f9;
            background: #f8fafc;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 15px;
            font-family: var(--main-font);
        }

        .form-control-custom:focus {
            border-color: var(--primary-blue);
            background: white;
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-control-readonly {
            background: #f1f5f9;
            cursor: not-allowed;
            color: #94a3b8;
            font-family: 'Monaco', monospace;
        }

        .error-text {
            color: var(--error-red);
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            background: var(--primary-blue);
            color: white;
            border: none;
            font-weight: 700;
            font-size: 15px;
            margin-top: 35px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
            font-family: var(--main-font);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(37, 99, 235, 0.4);
        }
    </style>

    <div class="content-wrapper">
        <a href="index_tt.php?view=theloai" class="back-link">
            <i class="fas fa-chevron-left"></i> Quay lại danh sách
        </a>

        <div class="form-card">
            <div class="text-center mb-5">
                <div class="icon-box"><i class="fas fa-tags"></i></div>
                <h3>Thêm Thể Loại</h3>
                <p style="color:#94a3b8;font-size:14px;margin-top:8px;">Nhập thông tin để hệ thống tạo danh mục mới</p>
            </div>

            <form id="formAdd" autocomplete="off">
                <div class="mb-4">
                    <label class="form-label">Mã Loại Sách</label>
                    <input type="text" name="ma_loai_sach" class="form-control-custom form-control-readonly" value="<?php echo $auto_ma; ?>" readonly>
                </div>

                <div class="mb-2">
                    <label class="form-label">Tên thể loại sách</label>
                    <input type="text" name="ten_loai_sach" class="form-control-custom" placeholder="VD: Công nghệ thông tin, Văn học..." required autofocus>
                    <div id="errorBox" class="error-text" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i> <span id="errorMsg"></span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Xác nhận lưu thể loại</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('formAdd').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch("http://localhost/hocphp/pttkpm_QLTV moi/business/api/TheLoaiAPI.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Thêm thể loại thành công!");
                        location.href = "index_tt.php?view=theloai";

                    } else {
                        document.getElementById('errorBox').style.display = 'flex';
                        document.getElementById('errorMsg').textContent = data.message || "Có lỗi xảy ra";
                    }
                })
                .catch(err => {
                    document.getElementById('errorBox').style.display = 'flex';
                    document.getElementById('errorMsg').textContent = "Lỗi kết nối API";
                });
        });
    </script>

