<?php

$current_view = $_GET['view'] ?? 'trangchu';
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>THƯ VIỆN ABC</h2>
    </div>
    
    <ul class="sidebar-menu">
        <li class="<?= ($current_view === 'trangchu') ? 'active' : '' ?>">
            <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=trangchu">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </li>

        <li class="<?= ($current_view === 'muonsach') ? 'active' : '' ?>">
            <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=muonsach">
                <i class="fas fa-book"></i> Yêu cầu mượn sách
            </a>
        </li>

        <li class="<?= ($current_view === 'dattruoc') ? 'active' : '' ?>">
            <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=dattruoc">
                <i class="fas fa-clock"></i> Đặt trước
            </a>
        </li>

        <li class="<?= ($current_view === 'dangkythe') ? 'active' : '' ?>">
            <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=dangkythe">
                <i class="fas fa-id-card"></i> Đăng ký thẻ
            </a>
        </li>

        <li class="<?= ($current_view === 'lichsu') ? 'active' : '' ?>">
            <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=lichsu">
                <i class="fas fa-history"></i> Lịch sử mượn - trả
            </a>
        </li>

        <li class="<?= ($current_view === 'taikhoan') ? 'active' : '' ?>">
            <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=taikhoan">
                <i class="fas fa-user-cog"></i> Thông tin tài khoản
            </a>
        </li>

        <li class="<?= ($current_view === 'doimkDocGia') ? 'active' : '' ?>">
            <a href="/hocphp/pttkpm_QLTV moi/index.php?action=trangchu_sv&view=doimkDocGia">
                <i class="fas fa-key"></i> Đổi mật khẩu
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="/hocphp/pttkpm_QLTV moi/index.php?action=logout" class="logout-btn" 
           onclick="return confirm('Xác nhận đăng xuất khỏi hệ thống?')">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</aside>
