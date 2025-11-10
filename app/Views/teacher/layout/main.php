<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $this->renderSection('title') ?> | ระบบงานครู สกจ.9</title>

    <meta name="description" content="ระบบบริหารจัดการข้อมูลสำหรับครู โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ช่วยในการจัดการงานวิชาการ งานวัดผล และงานหลักสูตร" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets/sneat/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/assets/sneat/css/demo.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/assets/sneat/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/assets/sneat/vendor/libs/apex-charts/apex-charts.css') ?>" />

    <style>
        body,
        .menu-link,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        div,
        span,
        input,
        textarea,
        select,
        button,
        .form-control,
        .btn,
        .breadcrumb-item {
            font-family: 'K2D', sans-serif;
        }
    </style>

    <!-- Helpers -->
    <script src="<?= base_url('public/assets/sneat/vendor/js/helpers.js') ?>"></script>
    <script src="<?= base_url('public/assets/sneat/js/config.js') ?>"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/main.min.css' rel='stylesheet' />

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="<?= base_url() ?>" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="LogoSKJ_4" style="height: 35px;" />
                        </span>
                        <span class="app-brand-text demo menu-text  ms-2">งานครู สกจ.9</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

<?php
    $currentUri = service('uri');
    $currentPath = $currentUri->getPath();
    $currentPath = trim($currentPath, '/');

    // Function to check if a menu item is active
    function isActiveMenuItem($href, $currentPath, $activePaths = '') {
        $linkPath = trim(str_replace(base_url(), '', $href), '/');

        // Direct match (most specific)
        if ($currentPath === $linkPath) {
            return true;
        }

        // data-active-paths match
        if (!empty($activePaths)) {
            $paths = explode(',', $activePaths);
            foreach ($paths as $path) {
                $path = trim($path, '/'); // Trim slashes from path for consistent comparison

                // Option 1: Exact match of the path segment
                if ($currentPath === $path) {
                    return true;
                }
                // Option 2: Current path starts with the active path segment, followed by a slash
                // This handles cases like 'curriculum/SendPlan' matching 'curriculum'
                if (strpos($currentPath . '/', $path . '/') === 0) {
                    return true;
                }
            }
        }
        return false;
    }

    $menuItems = [
        [
            'label' => 'หน้าหลัก',
            'icon' => 'bi-house-door-fill',
            'href' => base_url(),
            'active_paths' => 'home', // Assuming 'home' is the controller for the home page
        ],
        [
            'type' => 'header',
            'label' => 'งานวิชาการ',
        ],
        [
            'label' => 'ชุมนุม',
            'icon' => 'bi-people-fill',
            'href' => base_url('club'),
            'active_paths' => '',
        ],
        [
            'label' => 'งานวัดผล',
            'icon' => 'bi-file-earmark-ruled-fill',
            'submenu' => [
                [
                    'label' => 'บันทึกผลการเรียน(ปกติ)',
                    'href' => base_url('assessment/save-score-normal'),
                    'active_paths' => 'assessment/save-score-add',
                ],
                [
                    'label' => 'บันทึกผลการเรียน(ซ้ำ)',
                    'href' => base_url('assessment/save-score-repeat'),
                    'active_paths' => '',
                ],
            ],
        ],
        [
            'label' => 'งานหลักสูตร',
            'icon' => 'bi-book-fill',
            'submenu' => [
                [
                    'label' => 'ส่งแผนการสอน',
                    'href' => base_url('curriculum/SendPlan'),
                    'active_paths' => 'curriculum/,curriculum/SendPlan',
                ],
                // Conditional menu item
                (session()->get('pers_groupleade') !== null && session()->get('pers_groupleade') !== '') ? [
                    'label' => 'ตรวจแผน (หน.กลุ่มสาระ)',
                    'href' => base_url('curriculum/check-plan-head'),
                    'active_paths' => 'curriculum/check-plan-head,curriculum/check-plan-head-detail',
                ] : null,
                [
                    'label' => 'ดาวโหลดแผน',
                    'href' => base_url('curriculum/download-plan'),
                    'active_paths' => '',
                ],
            ],
        ],
        [
            'label' => 'งานประเมินนักเรียน',
            'icon' => 'bi-clipboard-check',
            'submenu' => [
                [
                    'label' => 'แบบประเมินอ่านคิดวิเคราะห์',
                    'href' => base_url('teacher/reading_assessment'),
                    'active_paths' => '',
                ],
                [
                    'label' => 'คุณลักษณะอันพึงประสงค์',
                    'href' => base_url('teacher/desirable_assessment'),
                    'active_paths' => '',
                ],
            ],
        ],
        [
            'label' => 'งานประกันคุณภาพ',
            'icon' => 'bi-award-fill',
            'href' => '#',
            'active_paths' => '',
        ],
    ];

    // Filter out null items from conditional menu
    $menuItems = array_filter($menuItems);

    // Recursive function to render menu
    function renderMenu($items, $currentPath) {
        $html = '';
        foreach ($items as $item) {
            if (isset($item['type']) && $item['type'] === 'header') {
                $html .= '<li class="menu-header small text-uppercase"><span class="menu-header-text">' . esc($item['label']) . '</span></li>';
                continue;
            }

            $isActive = false;
            $isParentActive = false;

            if (isset($item['submenu'])) {
                // Check if any submenu item is active
                foreach ($item['submenu'] as $subItem) {
                    // Ensure subItem is not null (from conditional rendering)
                    if ($subItem && isActiveMenuItem($subItem['href'], $currentPath, $subItem['active_paths'])) {
                        $isParentActive = true;
                        break;
                    }
                }
                $itemClass = 'menu-item ' . ($isParentActive ? 'open' : '');
                $linkClass = 'menu-link menu-toggle';
                $href = 'javascript:void(0);';
            } else {
                $isActive = isActiveMenuItem($item['href'], $currentPath, $item['active_paths']);
                $itemClass = 'menu-item ' . ($isActive ? 'active' : '');
                $linkClass = 'menu-link';
                $href = esc($item['href']);
            }

            $html .= '<li class="' . $itemClass . '">';
            $html .= '<a href="' . $href . '" class="' . $linkClass . '">';
            if (isset($item['icon'])) {
                $html .= '<i class="menu-icon tf-icons ' . esc($item['icon']) . '"></i>';
            }
            $html .= '<div data-i18n="' . esc($item['label']) . '">' . esc($item['label']) . '</div>';
            $html .= '</a>';

            if (isset($item['submenu'])) {
                $html .= '<ul class="menu-sub">';
                foreach ($item['submenu'] as $subItem) {
                    // Ensure subItem is not null (from conditional rendering)
                    if ($subItem) {
                        $subIsActive = isActiveMenuItem($subItem['href'], $currentPath, $subItem['active_paths']);
                        $html .= '<li class="menu-item ' . ($subIsActive ? 'active' : '') . '">';
                        $html .= '<a href="' . esc($subItem['href']) . '" class="menu-link">';
                        $html .= '<div data-i18n="' . esc($subItem['label']) . '">' . esc($subItem['label']) . '</div>';
                        $html .= '</a>';
                        $html .= '</li>';
                    }
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
        return $html;
    }
?>
                <ul class="menu-inner py-1">
                    <?= renderMenu($menuItems, $currentPath) ?>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= session()->get('person_img') ?>" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= session()->get('person_img') ?>" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">ครู<?= session()->get('fullname') ?></span>
                                                    <small class="text-muted">กำลังใช้งาน</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-12">
                              
<!--                                     
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0"><?= esc($title ?? 'หน้าหลัก') ?></h5>
                                            <nav aria-label="breadcrumb">
                                                <ol class="breadcrumb mb-0">
                                                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าหลัก</a></li>
                                                    <?php if (strpos(current_url(), 'club') !== false) : ?>
                                                        <li class="breadcrumb-item"><a href="<?= base_url('club') ?>">ชุมนุม</a></li>
                                                    <?php endif; ?>
                                                    <li class="breadcrumb-item active" aria-current="page"><?= esc($title ?? 'หน้าหลัก') ?></li>
                                                </ol>
                                            </nav>
                                        </div> -->
                                    
                               
                            </div>
                        </div>
                        <?= $this->renderSection('content') ?>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                <strong>
                                    Copyright &copy; 2025
                                    <a href="https://facebook.com/dekpiano" target="_blank" class="footer-link fw-bolder">Dekpiano</a>.
                                </strong>
                                ผู้พัฒนาระบบ
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="<?= base_url('public/assets/sneat/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('public/assets/sneat/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('public/assets/sneat/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('public/assets/sneat/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('public/assets/sneat/vendor/js/menu.js') ?>"></script>

    <!-- Vendors JS -->
    <script src="<?= base_url('public/assets/sneat/vendor/libs/apex-charts/apexcharts.js') ?>"></script>

    <!-- Main JS -->
    <script src="<?= base_url('public/assets/sneat/js/main.js') ?>"></script>

    <!-- Page JS -->
    <script src="<?= base_url('public/assets/sneat/js/dashboards-analytics.js') ?>"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>

    <?= $this->renderSection('scripts') ?>

    <script>
        $(function() {
            <?php if (session()->getFlashdata('success')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: '<?= session()->getFlashdata('success') ?>',
                    showConfirmButton: false,
                    timer: 1500
                });
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด!',
                    text: '<?= session()->getFlashdata('error') ?>'
                });
            <?php endif; ?>
        });


    </script>

</body>

</html>