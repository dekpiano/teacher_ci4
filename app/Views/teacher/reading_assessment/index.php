<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'แบบประเมินการอ่าน คิดวิเคราะห์ และเขียน') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">แบบประเมินการอ่าน คิดวิเคราะห์ และเขียน (ปีการศึกษา <?= $academicYear ?>)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="window.print();"><i class="fas fa-print"></i> พิมพ์หน้านี้</button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($teacherClasses)) : ?>
                        <div class="row">
                            <?php foreach ($teacherClasses as $class) : ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="small-box text-bg-primary">
                                        <div class="inner">
                                            <h3><?= esc($class['Reg_Class']) ?></h3>
                                            <p>ประเมินและดูรายงาน</p>
                                        </div>
                                        <i class="fas fa-edit small-box-icon"></i>
                                        <a href="<?= base_url('teacher/reading_assessment/assess/' . $class['Reg_Class']) ?>" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            ดำเนินการ <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p>ไม่พบชั้นเรียนที่ท่านเป็นที่ปรึกษาในปีการศึกษาปัจจุบัน</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
