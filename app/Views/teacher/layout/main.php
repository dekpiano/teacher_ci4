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
                        <span class="app-brand-text demo menu-text fw-bold ms-2">สกจ.9</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <li class="menu-item">
                        <a href="<?= base_url(); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bi bi-house-door-fill"></i>
                            <div data-i18n="Analytics">หน้าหลัก</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">งานวิชาการ</span>
                    </li>

                    <li class="menu-item">
                        <a href="<?= base_url('club') ?>" class="menu-link">
                            <i class="menu-icon tf-icons bi bi-people-fill"></i>
                            <div data-i18n="Club">ชุมนุม</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bi bi-file-earmark-ruled-fill"></i>
                            <div data-i18n="Layouts">งานวัดผล</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?= base_url('assessment/save-score-normal') ?>" class="menu-link" data-active-paths="assessment/save-score-add">
                                    <div data-i18n="Save Score Normal">บันทึกผลการเรียน(ปกติ)</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?= base_url('assessment/save-score-repeat') ?>" class="menu-link">
                                    <div data-i18n="Save Score Repeat">บันทึกผลการเรียน(ซ้ำ)</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bi bi-book-fill"></i>
                            <div data-i18n="Layouts">งานหลักสูตร</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?= base_url('curriculum/SendPlan') ?>" class="menu-link" data-active-paths="curriculum/,curriculum/SendPlan">
                                    <div data-i18n="Send Plan">ส่งแผนการสอน</div>
                                </a>
                            </li>
                            <?php if (session()->get('pers_groupleade') !== null && session()->get('pers_groupleade') !== '') : ?>
                                <li class="menu-item">
                                    <a href="<?= base_url('curriculum/check-plan-head') ?>" class="menu-link" data-active-paths="curriculum/check-plan-head,curriculum/check-plan-head-detail">
                                        <div data-i18n="Check Plan">ตรวจแผน (หน.กลุ่มสาระ)</div>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="menu-item">
                                <a href="<?= base_url('curriculum/download-plan') ?>" class="menu-link">
                                    <div data-i18n="Download Plan">ดาวโหลดแผน</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bi bi-clipboard-check"></i>
                            <div data-i18n="Layouts">งานประเมินนักเรียน</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?= base_url('teacher/reading_assessment') ?>" class="menu-link">
                                    <div data-i18n="Reading Assessment">แบบประเมินอ่านคิดวิเคราะห์</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?= base_url('teacher/desirable_assessment') ?>" class="menu-link">
                                    <div data-i18n="Desirable Assessment">คุณลักษณะอันพึงประสงค์</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon tf-icons bi bi-award-fill"></i>
                            <div data-i18n="Quality Assurance">งานประกันคุณภาพ</div>
                        </a>
                    </li>
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
                                <div class="card mb-4">
                                    <div class="card-header">
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
                                        </div>
                                    </div>
                                </div>
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

        // Active menu
        $(function() {
            var currentUrl = window.location.href.split('?')[0].split('#')[0];
            if (currentUrl.endsWith('/')) {
                currentUrl = currentUrl.slice(0, -1);
            }

            function activateMenu() {
                var bestMatch = null;
                var bestMatchLength = 0;

                $('.menu-inner .menu-item a').each(function() {
                    var link = $(this);
                    var linkHref = link.attr('href');

                    // Ignore links that are just placeholders or JS toggles
                    if (!linkHref || linkHref === '#' || linkHref.startsWith('javascript:')) {
                        return; // continue to next iteration
                    }

                    // Resolve the link's full URL properly
                    var linkUrl = new URL(linkHref, document.baseURI).href.split('?')[0].split('#')[0];
                    if (linkUrl.endsWith('/')) {
                        linkUrl = linkUrl.slice(0, -1);
                    }

                    // Check if the current URL starts with the link URL (longest prefix match)
                    if (currentUrl.startsWith(linkUrl)) {
                        if (linkUrl.length > bestMatchLength) {
                            bestMatch = link;
                            bestMatchLength = linkUrl.length;
                        }
                    }
                });

                // If no direct match, check for data-active-paths
                if (!bestMatch) {
                    $('.menu-inner .menu-item a').each(function() {
                        var link = $(this);
                        var activePaths = link.data('active-paths'); // Get data-active-paths attribute

                        if (activePaths) {
                            var paths = activePaths.split(','); // Split multiple paths if any
                            for (var i = 0; i < paths.length; i++) {
                                var path = paths[i].trim();
                                if (currentUrl.includes(path)) { // Check if currentUrl contains the path segment
                                    bestMatch = link;
                                    break;
                                }
                            }
                        }
                        if (bestMatch) return false; // Break outer loop if match found
                    });
                }


                if (bestMatch) {
                    // Remove active class from any other menu item to avoid duplicates
                    $('.menu-inner .menu-item.active').removeClass('active');
                    $('.menu-inner .menu-item.open').removeClass('open');
                    
                    // Add active class to the best matching link's li
                    bestMatch.closest('.menu-item').addClass('active');

                    // If it's in a sub-menu, open the parent tree
                    var parentSub = bestMatch.closest('.menu-sub');
                    if (parentSub.length) {
                        parentSub.closest('.menu-item').addClass('open active');
                    }
                }
            }

            activateMenu();
        });
    </script>

</body>

</html>