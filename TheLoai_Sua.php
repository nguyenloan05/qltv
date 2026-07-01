<?php

$ma_loai = $_GET['ma_loai_sach'] ?? '';
$ten_loai = $_GET['ten_loai_sach'] ?? '';
?>

<style>
        .content-wrapper {
            padding: 40px;
            background: #f8fafc;
            min-height: 100vh;
            font-family: 'Be Vietnam Pro', sans-serif;
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
            color: #2563eb;
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
            color: #2563eb;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 26px;
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
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        .form-control-custom:focus {
            border-color: #2563eb;
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

        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            background: #2563eb;
            color: white;
            border: none;
            font-weight: 700;
            font-size: 15px;
            margin-top: 35px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(37, 99, 235, 0.4);
        }

        .error-text {
            color: #ef4444;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>

    <div class="content-wrapper">
        <a href="index_tt.php?view=theloai" class="back-link">
            <i class="fas fa-chevron-left"></i> Quay lại danh sách
        </a>

        <div class="form-card">
            <div class="text-center mb-5">
                <div class="icon-box"><i class="fas fa-edit"></i></div>
                <h3>Sửa Thể Loại</h3>
                <p style="color:#94a3b8;font-size:14px;margin-top:8px;">Chỉnh sửa thông tin thể loại</p>
            </div>

            <form id="formEdit" autocomplete="off">
                <div class="mb-4">
                    <label class="form-label">Mã định danh hệ thống</label>
                    <input type="text" name="ma_loai_sach" class="form-control-custom form-control-readonly" value="<?php echo htmlspecialchars($ma_loai); ?>" readonly>
                </div>

                <div class="mb-2">
                    <label class="form-label">Tên thể loại sách</label>
                    <input type="text" name="ten_loai_sach" class="form-control-custom" value="<?php echo htmlspecialchars($ten_loai); ?>" required>
                    <div id="errorBox" class="error-text" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i> <span id="errorMsg"></span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Xác nhận cập nhật</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('formEdit').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            let params = new URLSearchParams();
            for (let pair of formData.entries()) {
                params.append(pair[0], pair[1]);
            }

            fetch("http://localhost/hocphp/pttkpm_QLTV moi/business/api/TheLoaiAPI.php", {
                    method: "PUT",
                    body: params
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Cập nhật thể loại thành công!");
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

