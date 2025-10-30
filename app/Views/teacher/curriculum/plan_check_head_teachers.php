<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'เลือกครูเพื่อตรวจแผน') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= esc($title ?? 'เลือกครูเพื่อตรวจแผน') ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= site_url('teacher/home') ?>">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            ตรวจสอบแผนการสอน
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <?php if (empty($teachers)): ?>
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            ไม่พบข้อมูลครูในกลุ่มสาระของท่าน
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($teacher->pers_img) ?>" 
                                         alt="<?= esc($teacher->pers_firstname) ?>" 
                                         class="rounded-circle img-fluid mb-3" 
                                         style="width: 100px; height: 100px; object-fit: cover;"
                                         onerror="this.onerror=null;this.src='https://placehold.co/100x100/EFEFEF/AAAAAA&text=No+Image';">
                                    <h5 class="card-title"><?= esc($teacher->pers_prefix . $teacher->pers_firstname . ' ' . $teacher->pers_lastname) ?></h5>
                                    <a href="<?= site_url('curriculum/check-plan-head-detail/' . $teacher->pers_id) ?>" class="btn btn-primary btn-sm">ดูแผนการสอน</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
