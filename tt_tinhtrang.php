<div class="stats-container" style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
    <?php
    $active_filter = $_GET['btn_tinhtrang'] ?? 'all';
    $current_search = isset($_GET['tu_khoa']) ? $_GET['tu_khoa'] : '';

    function getFilterUrl($status, $search) {
        return "index_tt.php?view=muontra&tu_khoa=" . urlencode($search) . "&btn_tinhtrang=" . $status;
    }
    ?>
    
    <a href="<?= getFilterUrl('all', $current_search) ?>" class="stat-card <?= $active_filter == 'all' ? 'active' : '' ?>" style="text-decoration: none; color: inherit;">
        <i class="fas fa-list-ul"></i>
        <div class="stat-info">
            <span>TẤT CẢ</span>
            <strong id="stat-all"><?= $total_records ?? 0 ?></strong>
        </div>
    </a>

    <a href="<?= getFilterUrl('0', $current_search) ?>" class="stat-card <?= $active_filter == '0' ? 'active' : '' ?>" style="--color: #f1c40f; text-decoration: none; color: inherit;">
        <i class="fas fa-clock"></i>
        <div class="stat-info">
            <span>CHỜ DUYỆT</span>
            <strong id="stat-pending"><?= $count_pending ?? 0 ?></strong>
        </div>
    </a>

    <a href="<?= getFilterUrl('1', $current_search) ?>" class="stat-card <?= $active_filter == '1' ? 'active' : '' ?>" style="--color: #3498db; text-decoration: none; color: inherit;">
        <i class="fas fa-book-reader"></i>
        <div class="stat-info">
            <span>ĐANG MƯỢN</span>
            <strong id="stat-borrowing"><?= $count_borrowing ?? 0 ?></strong>
        </div>
    </a>

    <a href="<?= getFilterUrl('2', $current_search) ?>" class="stat-card <?= $active_filter == '2' ? 'active' : '' ?>" style="--color: #2ecc71; text-decoration: none; color: inherit;">
        <i class="fas fa-check-circle"></i>
        <div class="stat-info">
            <span>ĐÃ TRẢ</span>
            <strong id="stat-returned"><?= $count_returned ?? 0 ?></strong>
        </div>
    </a>

    <a href="<?= getFilterUrl('3', $current_search) ?>" class="stat-card <?= $active_filter == '3' ? 'active' : '' ?>" style="--color: #e74c3c; text-decoration: none; color: inherit;">
        <i class="fas fa-exclamation-triangle"></i>
        <div class="stat-info">
            <span>CHỜ XỬ LÝ</span>
            <strong id="stat-issue"><?= $count_violation ?? 0 ?></strong>
        </div>
    </a>

    <a href="<?= getFilterUrl('4', $current_search) ?>" class="stat-card <?= $active_filter == '4' ? 'active' : '' ?>" style="--color: #95a5a6; text-decoration: none; color: inherit;">
        <i class="fas fa-times-circle"></i>
        <div class="stat-info">
            <span>ĐÃ HỦY</span>
            <strong id="stat-cancelled"><?= $count_cancelled ?? 0 ?></strong>
        </div>
    </a>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const searchKeyword = urlParams.get('tu_khoa') || '';

    fetch(`api_PhieuMuon.php?action=get_stats&search=${encodeURIComponent(searchKeyword)}`)
    .then(res => res.json())
    .then(result => {
        if(result.status === 'success'){
            document.getElementById('stat-all').innerText = result.data.all;
            document.getElementById('stat-pending').innerText = result.data.pending;
            document.getElementById('stat-borrowing').innerText = result.data.borrowing;
            document.getElementById('stat-returned').innerText = result.data.returned;
            document.getElementById('stat-issue').innerText = result.data.violation; 
            document.getElementById('stat-cancelled').innerText = result.data.cancelled;
        }
    })
    .catch(err => console.error("Lỗi cập nhật thống kê:", err));
</script>