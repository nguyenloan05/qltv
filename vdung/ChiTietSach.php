<?php

$ma_sach = $_GET['ma_sach'] ?? null;
$book = null;

if ($ma_sach) {
    $url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/SachAPI.php?ma_sach=" . $ma_sach;
    $url_encoded = str_replace(' ', '%20', $url);
    $data = file_get_contents($url_encoded);
    $result = json_decode($data, true);

    if ($result) {
        $book = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết sách</title>
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/KhachView/khachGUI.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/KhachView/menuKhach.css?v=<?php echo time(); ?>">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f9;
        }

        .main-content {
            margin-left: 240px;
            padding: 30px;
        }

        .detail-card {
            display: flex;
            gap: 30px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .detail-card img {
            width: 300px;
            height: 420px;
            object-fit: cover;
            border-radius: 8px;
        }

        .detail-info h1 {
            margin: 0 0 15px;
            font-size: 26px;
        }

        .detail-info p {
            font-size: 16px;
            margin: 8px 0;
        }

        .detail-info .desc {
            margin-top: 15px;
            font-size: 15px;
            line-height: 1.6;
        }

        .detail-info button {
            margin-top: 20px;
            padding: 12px 25px;
            border: none;
            background: #2980b9;
            color: white;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
        }

        .detail-info button:hover {
            background: #3498db;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/menuKhach.php'; ?>

    <div class="main-content">
        <a href="index.php?view=SachAPI" style="text-decoration: none; color: #64748b; font-weight: 600; margin-bottom: 20px; display: inline-block;">
            <i class="fas fa-chevron-left"></i> QUAY LẠI DANH SÁCH
        </a>

        <?php if ($book): ?>
            <div class="detail-card">
                <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/<?php echo $book['image']; ?>" alt="Bìa sách">

                <div class="detail-info">
                    <h1><?php echo $book['ten_sach']; ?></h1>

                    <p><b>Tác giả:</b> <?php echo $book['ten_tg']; ?></p>
                    <p><b>Nhà xuất bản:</b> <?php echo $book['nha_xb']; ?> (<?php echo $book['nam_xb']; ?>)</p>
                    <p><b>Số lượng:</b> <?php echo $book['so_luong_hien_tai']; ?> cuốn</p>

                    <p><b>Tình trạng:</b>
                        <?php echo ($book['tinh_trang'] == 1) ? "Còn sách" : "Hết sách"; ?>
                        </p>

                    <div class="desc">
                        <b>Mô tả:</b><br>
                        <?php echo nl2br($book['mo_ta']); ?>
                    </div>

                    <button onclick="alert('Hãy đăng ký thẻ thư viện để được mượn sách!')">
                        Mượn sách
                    </button>
                </div>
            </div>

        <?php else: ?>
            <p>Không tìm thấy sách.</p>
        <?php endif; ?>

    </div>
</body>

</html>

