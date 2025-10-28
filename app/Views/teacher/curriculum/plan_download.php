<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'ดาวน์โหลดแผน') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= esc($title ?? '') ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($title ?? '') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr class="table-active">
                                <th >ชื่อ - นามสกุล</th>
                                <th >คำสั่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($teacher)): ?>
                            <?php foreach ($teacher as $v_teacher) : ?>
                            <tr>
                                <td >
                                    <?= esc($v_teacher->pers_prefix . $v_teacher->pers_firstname . ' ' . $v_teacher->pers_lastname) ?>
                                </td>
                                <td ><a href="<?= site_url('curriculum/download-plan-zip/' . $v_teacher->pers_id) ?>">Download</a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">ไม่พบข้อมูลครูผู้สอน</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
