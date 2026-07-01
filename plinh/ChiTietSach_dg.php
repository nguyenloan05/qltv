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

<style>

    .back-link {
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 25px;
        display: inline-block;
        font-size: 15px;
    }
    .back-link:hover { color: #2563eb; }


    .detail-card {
        display: flex;
        align-items: flex-start;
        gap: 40px;
        background: #fff;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        width: 100%;
    }


    .detail-card img {
        width: 280px;
        height: 400px;
        object-fit: contain;
        background: #f3f4f6;
        padding: 10px;
        border-radius: 14px;
        flex-shrink: 0;
    }


    .detail-info { flex: 1; }
    .detail-info h1 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 34px;
        color: #111827;
    }
    .detail-info p {
        font-size: 17px;
        margin: 12px 0;
        color: #374151;
        line-height: 1.6;
    }
    .detail-info b { color: #111827; }


    .desc {
        margin-top: 22px;
        background: #f9fafb;
        padding: 18px;
        border-radius: 12px;
        line-height: 1.8;
        color: #4b5563;
    }


    @media(max-width:992px) {
        .detail-card {
            flex-direction: column;
            align-items: center;
        }
        .detail-card img {
            width: 220px;
            height: 320px;
        }
        .detail-info h1 { font-size: 28px; }
    }
</style>

    <div class="main-content" style="padding: 0;">
        <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=trangchu"
            class="back-link">

            <i class="fas fa-chevron-left"></i>
            QUAY LẠI DANH SÁCH

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
                </div>
            </div>

        <?php else: ?>
            <p>Không tìm thấy sách.</p>
        <?php endif; ?>

    </div>
