<?php

$url = "http://localhost/hocphp/pttkpm_QLTV moi/business/api/SachAPI.php";
$url_encoded = str_replace(' ', '%20', $url);
$api_data = @file_get_contents($url_encoded);
$list_sach = $api_data ? json_decode($api_data, true) : [];
$list_sach = $list_sach ?? [];
$keyword = trim($_GET['keyword'] ?? '');

if ($keyword !== '') {

    $list_sach = array_filter($list_sach, function ($sach) use ($keyword) {

        return stripos(
            $sach['ten_sach'] ?? '',
            $keyword
        ) !== false;
    });
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="/hocphp/pttkpm_QLTV moi/presentation/assets/css/DocGiaView/TrangChu_Dg.css">
<div class="main-content">

    
    <div class="search-box">
        <h4 class="section-title">
            <span class="greeting">
                Xin chào, <?php echo htmlspecialchars($ten_dg ?? $_SESSION['ten_doc_gia'] ?? 'Độc giả'); ?>
            </span>

        </h4>


        <form method="GET" action="/hocphp/pttkpm_QLTV moi/index.php">

            
            <input type="hidden" name="action" value="trangchu_sv">
            <input type="hidden" name="view" value="trangchu">

            <div class="input-group">

                <input type="text"
                    class="form-control"
                    name="keyword"
                    placeholder="Nhập tên sách..."
                    value="<?php echo htmlspecialchars($keyword); ?>">

                <button class="btn btn-primary">

                    <i class="fas fa-search"></i> Tìm kiếm

                </button>

            </div>

        </form>
    </div>

    
    <div class="policy-box mb-5">
        <h4 class="section-title">
            <i class="fas fa-book me-2"></i>Quy định thư viện
        </h4>

        <ul class="mb-0">
            <li>
                Mỗi độc giả được mượn tối đa
                <strong><?php echo (int)($setting['so_sach_toi_da'] ?? 5); ?></strong>
                quyển sách.
            </li>

            <li>
                Thời gian mượn tối đa:
                <strong><?php echo (int)($setting['so_ngay_muon_toi_da'] ?? 15); ?></strong>
                ngày.
            </li>

            <li>
                Phí phạt quá hạn:
                <strong>
                    <?php echo number_format((float)($setting['phi_phat_ngay'] ?? 2000), 0, ',', '.'); ?>đ
                </strong>
                / ngày.
            </li>
        </ul>
    </div>


    
    <h4 class="section-title">
        <i class="fas fa-book-open me-2"></i>Danh sách sách
    </h4>

    <div class="row g-4">

        <?php if (!empty($list_sach)): ?>

            <?php foreach ($list_sach as $sach): ?>



                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="card-book position-relative text-center">

                        
                        <img src="/hocphp/pttkpm_QLTV moi/presentation/assets/images/<?php echo htmlspecialchars($sach['image'] ?? 'default_book.png'); ?>"
                            class="book-image mb-3"
                            onerror="this.src='/hocphp/pttkpm_QLTV moi/presentation/assets/images/default_book.png'">
                        
                        <h6 class="fw-bold mb-1 text-truncate">
                            <?php echo htmlspecialchars($sach['ten_sach'] ?? ''); ?>
                        </h6>

                        
                        <p class="text-muted small mb-3">
                            Số lượng:
                            <?php echo (int)($sach['so_luong_hien_tai'] ?? 0); ?>
                        </p>

                        
                        <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=chitietsach&ma_sach=<?php echo (int)$sach['ma_sach']; ?>"
                            class="btn-detail">

                            Xem chi tiết

                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="col-12">

                <div class="alert alert-warning text-center">

                    Không tìm thấy sách phù hợp.

                </div>

            </div>

        <?php endif; ?>

    </div>
</div>
