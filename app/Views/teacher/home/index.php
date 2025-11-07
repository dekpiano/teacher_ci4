<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
หน้าแรก
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <!-- <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard v2</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard v2</li>
                    </ol>
                </div>
            </div> -->
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
<div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">

            <style>
                .dashboard-icon {
                    font-size: 3rem;
                    margin-bottom: 1rem;
                }
                .list-group-icon {
                    font-size: 1.5rem;
                }
            </style>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body text-center">
                            <i class="bi bi-person-square dashboard-icon"></i>
                            <h4>ยินดีต้อนรับ, ครู<?= session()->get('fullname')?></h4>
                            <p>ระบบบริหารจัดการข้อมูลสำหรับครู โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-clipboard-check"></i>
                                งานประเมินนักเรียน
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="<?= base_url('teacher/reading_assessment') ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><i class="bi bi-book-half list-group-icon"></i> แบบประเมินอ่านคิดวิเคราะห์</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">ประเมินความสามารถในการอ่าน คิดวิเคราะห์ และเขียนของนักเรียน</p>
                                </a>
                                <a href="<?= base_url('teacher/desirable_assessment') ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><i class="bi bi-check2-circle list-group-icon"></i> คุณลักษณะอันพึงประสงค์</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">ประเมินคุณลักษณะอันพึงประสงค์ 8 ประการของนักเรียน</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-file-earmark-plus"></i>
                                งานวัดผล
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="<?= base_url('assessment/save-score-normal') ?>"
                                    class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><i class="bi bi-file-earmark-text list-group-icon"></i> บันทึกผลการเรียน (ปกติ)</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">บันทึกคะแนนและผลการเรียนของนักเรียนในรายวิชาปกติ</p>
                                </a>
                                <a href="<?= base_url('assessment/save-score-repeat') ?>"
                                    class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><i class="bi bi-repeat list-group-icon"></i> บันทึกผลการเรียน (ซ้ำ)</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">บันทึกคะแนนและผลการเรียนของนักเรียนที่เรียนซ้ำ</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-book"></i>
                                งานหลักสูตร
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="<?= base_url('curriculum/SendPlan') ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><i class="bi bi-cloud-upload list-group-icon"></i> ส่งแผนการสอน</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">อัปโหลดและส่งแผนการสอนเพื่อขออนุมัติ</p>
                                </a>
                                <a href="<?= base_url('curriculum/download-plan') ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="bi bi-cloud-download list-group-icon"></i> ดาวน์โหลดแผน</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">ดาวน์โหลดแผนการสอนที่ได้รับอนุมัติแล้ว</p>
                                </a>
                                <?php if (session()->get('pers_groupleade') !== null && session()->get('pers_groupleade') !== ''): ?>
                                <a href="<?= base_url('curriculum/check-plan-head') ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="bi bi-clipboard-check list-group-icon"></i> ตรวจแผน (หน.กลุ่มสาระ)</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">ตรวจสอบและอนุมัติแผนการสอนของครูในกลุ่มสาระ</p>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-palette"></i>
                                อื่นๆ
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><i class="bi bi-shield-check list-group-icon"></i> งานประกันคุณภาพ</h5>
                                        <small><i class="bi bi-arrow-right-circle-fill list-group-icon"></i></small>
                                    </div>
                                    <p class="mb-1">จัดการข้อมูลและเอกสารที่เกี่ยวข้องกับงานประกันคุณภาพ</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>