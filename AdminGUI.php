<?php

$sql_top_books = "SELECT s.ten_sach, tg.ten_tg, s.image, COUNT(m.ma_sach) as luot_muon 
                  FROM sach s 
                  JOIN tac_gia tg ON s.ma_tg = tg.ma_tg
                  LEFT JOIN phieu_muon m ON s.ma_sach = m.ma_sach 
                  GROUP BY s.ma_sach 
                  ORDER BY luot_muon DESC 
                  LIMIT 10";
$result_top_books = $conn->query($sql_top_books);
?>


<style>
    :root { --primary: #4318ff; --bg: #f4f7fe; --white: #ffffff; --text-dark: #1b2559; --text-grey: #a3aed0; }
    .dashboard-wrapper { width: 100%; }

    .chart-card { background: var(--white); padding: 30px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .chart-card h4 { margin-top: 0; margin-bottom: 25px; color: var(--text-dark); font-size: 20px; font-weight: 700; }
    .chart-card h4 i { color: var(--primary); margin-right: 10px; }

    .books-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(450px, 1fr)); gap: 15px; }
    .book-item { display: flex; align-items: center; gap: 15px; padding: 15px 20px; border-radius: 14px; background: #f8fafc; border: 1px solid #f0f0f0; transition: 0.2s; }
    .book-item:hover { background: #eef2ff; border-color: #c7d2fe; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(67, 24, 255, 0.08); }
    .book-img { width: 50px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .book-info { flex: 1; }
    .book-info h5 { margin: 0 0 5px 0; font-size: 15px; color: var(--text-dark); font-weight: 600; }
    .book-info p { margin: 0; font-size: 13px; color: var(--text-grey); }
    .book-count { font-size: 14px; font-weight: bold; color: var(--primary); white-space: nowrap; }
</style>


<div class="dashboard-wrapper">
    <div class="chart-card">
        <h4><i class="fas fa-crown"></i>Top sách mượn nhiều nhất</h4>
        <div class="books-grid">
            <?php if ($result_top_books && $result_top_books->num_rows > 0): ?>
                <?php while($row = $result_top_books->fetch_assoc()): ?>
                <div class="book-item">
                    <img src="presentation/assets/images/<?= htmlspecialchars($row['image']) ?>" class="book-img" onerror="this.src='https://via.placeholder.com/50x70?text=No+Img'">
                    <div class="book-info">
                        <h5><?= htmlspecialchars($row['ten_sach']) ?></h5>
                        <p><i class="fas fa-user-edit" style="margin-right:5px;"></i><?= htmlspecialchars($row['ten_tg']) ?></p>
                    </div>
                    <div class="book-count"><i class="fas fa-chart-line" style="margin-right:5px;"></i><?= $row['luot_muon'] ?> lượt</div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center; color:#999; padding-top:20px;">Chưa có dữ liệu</p>
            <?php endif; ?>
        </div>
    </div>
</div>