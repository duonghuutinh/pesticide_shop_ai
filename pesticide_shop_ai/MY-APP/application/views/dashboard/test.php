<?php
$current_page = $this->uri->segment(1);
$sub_page = $this->uri->segment(2);

$sidebar_menu = [
    'dashboard' => [
        'label' => 'Dashboard',
        'icon' => 'fa-home',
        'url' => 'dashboard',
    ],
    'revenue' => [
        'label' => 'Báo cáo',
        'icon' => 'fa-bar-chart',
        'children' => [
            ['label' => 'Doanh thu', 'url' => 'revenueReport', 'current' => 'revenueReport'],
            ['label' => 'Lô hàng', 'url' => 'revenueBatches', 'current' => 'revenueBatches'],
        ]
    ],
    'brand' => [
        'label' => 'Quản lý thương hiệu',
        'icon' => 'fa-tags',
        'children' => [
            ['label' => 'Thêm thương hiệu', 'url' => 'brand/create', 'sub' => 'create'],
            ['label' => 'Danh sách thương hiệu', 'url' => 'brand/list', 'sub' => 'list'],
        ]
    ],
    'category' => [
        'label' => 'Quản lý danh mục',
        'icon' => 'fa-folder',
        'children' => [
            ['label' => 'Thêm danh mục', 'url' => 'category/create', 'sub' => 'create'],
            ['label' => 'Danh sách danh mục', 'url' => 'category/list', 'sub' => 'list'],
        ]
    ],
    'product' => [
        'label' => 'Quản lý sản phẩm',
        'icon' => 'fa-box',
        'children' => [
            ['label' => 'Thêm sản phẩm', 'url' => 'product/create', 'sub' => 'create'],
            ['label' => 'Danh sách sản phẩm', 'url' => 'product/list', 'sub' => 'list'],
        ]
    ],
    'order_admin' => [
        'label' => 'Quản lý đơn hàng',
        'icon' => 'fa-shopping-cart',
        'children' => [
            ['label' => 'Danh sách đơn hàng', 'url' => 'order_admin/listOrder', 'sub' => 'listOrder'],
        ]
    ],
    'slider' => [
        'label' => 'Quản lý banner',
        'icon' => 'fa-image',
        'children' => [
            ['label' => 'Thêm Banner mới', 'url' => 'slider/create', 'sub' => 'create'],
            ['label' => 'Danh sách Banner', 'url' => 'slider/list', 'sub' => 'list'],
        ]
    ],
    'customer' => [
        'label' => 'Quản lý người dùng',
        'icon' => 'fa-users',
        'children' => [
            ['label' => 'Thêm người dùng mới', 'url' => 'customer/create', 'sub' => 'create'],
            ['label' => 'Danh sách người dùng', 'url' => 'customer/list', 'sub' => 'list'],
        ]
    ],
    'warehouse' => [
        'label' => 'Quản lý kho hàng',
        'icon' => 'fa-warehouse',
        'children' => [
            ['label' => 'Nhập kho', 'url' => 'warehouse/receive-goods', 'sub' => 'create'],
            ['label' => 'Danh sách phiếu nhập', 'url' => 'warehouse/receive-goods-list', 'sub' => 'list'],
            ['label' => 'DS sản phẩm trong kho', 'url' => 'warehouse/list', 'sub' => 'list'],
        ]
    ],
    'comment' => [
        'label' => 'Quản lý bình luận',
        'icon' => 'fa-comments',
        'children' => [
            ['label' => 'Danh sách bình luận', 'url' => 'comment', 'current' => 'comment'],
        ]
    ],
];
?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img width="50" height="50" class="img-circle"
                             src="<?php echo base_url('uploads/user/1743060974cabybara.jpg') ?>" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold">Huu Thuan</strong></span>
                            <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Contacts</a></li>
                        <li><a href="#">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('logout_admin'); ?>">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">IN+</div>
            </li>

            <?php foreach ($sidebar_menu as $key => $menu): ?>
                <?php
                    // Kiểm tra active
                    $is_active = false;
                    if (!empty($menu['children'])) {
                        foreach ($menu['children'] as $child) {
                            if (
                                (isset($child['sub']) && $current_page === $key && $sub_page === $child['sub']) ||
                                (isset($child['current']) && $current_page === $child['current'])
                            ) {
                                $is_active = true;
                                break;
                            }
                        }
                    } else {
                        $is_active = $current_page === $key;
                    }
                ?>

                <li class="<?php echo $is_active ? 'active' : ''; ?>">
                    <a href="<?php echo isset($menu['url']) ? base_url($menu['url']) : '#'; ?>">
                        <i class="fa <?php echo $menu['icon']; ?>"></i>
                        <span class="nav-label"><?php echo $menu['label']; ?></span>
                        <?php if (!empty($menu['children'])): ?>
                            <span class="fa arrow"></span>
                        <?php endif; ?>
                    </a>

                    <?php if (!empty($menu['children'])): ?>
                        <ul class="nav nav-second-level <?php echo $is_active ? 'in' : ''; ?>">
                            <?php foreach ($menu['children'] as $child): ?>
                                <?php
                                    $child_active =
                                        (isset($child['sub']) && $current_page === $key && $sub_page === $child['sub']) ||
                                        (isset($child['current']) && $current_page === $child['current']);
                                ?>
                                <li class="<?php echo $child_active ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url($child['url']); ?>"><?php echo $child['label']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
