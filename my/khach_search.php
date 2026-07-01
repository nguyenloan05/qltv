<?php

if (isset($_GET['ma_sach'])) {
    $ma_sach = $_GET['ma_sach'];
    $sql = "SELECT sach.*, tac_gia.ten_tg 
            FROM sach 
            LEFT JOIN tac_gia ON sach.ma_tg = tac_gia.ma_tg 
            WHERE sach.ma_sach = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ma_sach);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $book = mysqli_fetch_assoc($result);
}
else {
    
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";
    $limit = 12;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT sach.*, tac_gia.ten_tg 
            FROM sach 
            LEFT JOIN tac_gia ON sach.ma_tg = tac_gia.ma_tg 
            WHERE sach.ten_sach LIKE ? 
               OR tac_gia.ten_tg LIKE ? 
               OR sach.ma_sach LIKE ?
            LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($conn, $sql);
    $searchTerm = "%$keyword%";
    mysqli_stmt_bind_param($stmt, "sssii", $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $sqlCount = "SELECT COUNT(*) AS total 
                 FROM sach 
                 LEFT JOIN tac_gia ON sach.ma_tg = tac_gia.ma_tg 
                 WHERE sach.ten_sach LIKE ? 
                    OR tac_gia.ten_tg LIKE ? 
                    OR sach.ma_sach LIKE ?";
    $stmtCount = mysqli_prepare($conn, $sqlCount);
    mysqli_stmt_bind_param($stmtCount, "sss", $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmtCount);
    $countResult = mysqli_stmt_get_result($stmtCount);
    $totalRow = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRow / $limit);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tìm kiếm sách - Thư Viện ABC</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="presentation/assets/css/KhachView/menuKhach.css">
<link rel="stylesheet" href="presentation/assets/css/KhachView/khachGUI.css">
<style>

.search-hero {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    text-align: center;
}
.search-hero h1 {
    font-size: 24px;
    color: #2c3e50;
    margin-bottom: 20px;
}
.search-bar-modern {
    display: flex;
    justify-content: center;
    max-width: 600px;
    margin: 0 auto;
}
.search-bar-modern input {
    flex: 1;
    padding: 15px 20px;
    border: 1px solid #ddd;
    border-radius: 30px 0 0 30px;
    outline: none;
    font-size: 16px;
}
.search-bar-modern button {
    padding: 15px 30px;
    border: none;
    background: #3498db;
    color: white;
    border-radius: 0 30px 30px 0;
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    transition: 0.3s;
}
.search-bar-modern button:hover {
    background: #2980b9;
}
.detail-card { display:flex; gap:30px; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); }
.detail-card img { width:250px; height:350px; object-fit:cover; border-radius:8px; border:1px solid #eee; }
.detail-info h1 { margin:0 0 15px; font-size:26px; color:#2c3e50; }
.detail-info p { font-size:15px; margin:8px 0; color:#555;}
.detail-info .desc { margin-top:15px; font-size:15px; line-height:1.6; color:#444; }
.detail-info button { margin-top:20px; padding:12px 25px; border:none; background:#f1c40f; color:#2c3e50; border-radius:25px; cursor:pointer; font-weight:bold; font-size:15px; }
.detail-info button:hover { background:#f39c12; }
</style>
</head>
<body>

<?php include 'presentation/views/KhachView/menuKhach.php'; ?>

<div class="main-content">
    <?php if(isset($book)): ?>
        
        <a href="javascript:history.back()" style="display:inline-block; margin-bottom:20px; color:#3498db; text-decoration:none;"><i class="fas fa-arrow-left"></i> Quay lại</a>
        <div class="detail-card">
            <img src="<?= !empty($book['image']) ? "presentation/assets/images/".$book['image'] : "https://via.placeholder.com/250x350?text=Bìa+sách" ?>" alt="Bìa sách">
            <div class="detail-info">
                <h1><?= htmlspecialchars($book['ten_sach']) ?></h1>
                <p><b>Tác giả:</b> <?= htmlspecialchars($book['ten_tg'] ?? 'Đang cập nhật') ?></p>
                <p><b>Nhà xuất bản:</b> <?= htmlspecialchars($book['nha_xb']) ?> (<?= htmlspecialchars($book['nam_xb']) ?>)</p>
                <p><b>Số lượng:</b> <?= htmlspecialchars($book['so_luong']) ?> cuốn</p>
                <p><b>Tình trạng:</b> <?= ($book['tinh_trang']==1) ? "<span style='color:#2ecc71;font-weight:bold'>Còn sách</span>" : "<span style='color:#e74c3c;font-weight:bold'>Hết sách</span>" ?></p>
                <div class="desc"><b>Mô tả:</b><br><?= nl2br(htmlspecialchars($book['mo_ta'])) ?></div>
                <button onclick="alert('Hãy đăng ký thẻ thư viện hoặc đăng nhập để mượn sách!')">Đăng ký mượn sách</button>
            </div>
        </div>
    <?php else: ?>
        
        <div class="search-hero">
            <h1>Tra cứu tài liệu thư viện</h1>
            <form class="search-bar-modern" method="get" action="index.php">
                <input type="hidden" name="action" value="khach_search">
                <input type="text" name="keyword" placeholder="Nhập tên sách, mã sách hoặc tác giả..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
            </form>
        </div>

        <?php if(isset($keyword) && $keyword !== ''): ?>
            <div class="section-title">Kết quả tìm kiếm cho "<?= htmlspecialchars($keyword) ?>"</div>
        <?php else: ?>
            <div class="section-title">Tất cả tài liệu</div>
        <?php endif; ?>

        <div class="book-grid">
            <?php if($result && mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="book-card">
                        <img src="<?= !empty($row['image']) ? "presentation/assets/images/".$row['image'] : "https://via.placeholder.com/200x250?text=Bìa+sách" ?>" alt="Bìa sách" onerror="this.src='https://via.placeholder.com/200x250?text=Bìa+sách'">
                        <div class="book-info">
                            <div class="book-title"><?= htmlspecialchars($row['ten_sach']) ?></div>
                            <div class="book-author">Tác giả: <?= htmlspecialchars($row['ten_tg'] ?? 'Đang cập nhật') ?></div>
                            <div style="margin-top:10px;">
                                <a href="index.php?action=khach_search&ma_sach=<?= urlencode($row['ma_sach']) ?>" style="color:#3498db; text-decoration:none; font-size:14px; font-weight:bold;">Xem chi tiết <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="width:100%; text-align:center; padding:50px; background:white; border-radius:8px;">
                    <i class="fas fa-search" style="font-size:40px; color:#ccc; margin-bottom:15px;"></i>
                    <p style="color:#7f8c8d;">Không tìm thấy kết quả nào cho từ khóa "<b><?= htmlspecialchars($keyword ?? '') ?></b>"</p>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if(isset($totalPages) && $totalPages > 1): ?>
        <div class="pagination-modern">
            <?php for($i=1; $i<=$totalPages; $i++): ?>
                <a href="index.php?action=khach_search&keyword=<?= urlencode($keyword ?? '') ?>&page=<?= $i ?>" class="page-btn <?= ($i==$page)?'active':'' ?>" <?= ($i==$page)?'style="background:#3498db;color:white;"':'' ?>>
                    <?= $i ?>
                </a>
                &nbsp;
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>