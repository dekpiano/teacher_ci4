<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'ประเมินคุณลักษณะอันพึงประสงค์') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ประเมินคุณลักษณะอันพึงประสงค์ (ปีการศึกษา <?= $academicYear ?>)</h3>
                  
                </div>
                <div class="card-body">
                    <?php if (!empty($teacherClasses)) : ?>
                        <div class="row">
                            <?php foreach ($teacherClasses as $class) : ?>
                                <?php
                                    $status = $class['status'] ?? ['total' => 0, 'assessed' => 0];
                                    $statusText = 'ยังไม่ได้ประเมิน';
                                    $boxColor = 'text-bg-secondary';

                                    if ($status['assessed'] > 0) {
                                        if ($status['assessed'] >= $status['total']) {
                                            $statusText = 'ประเมินครบแล้ว (' . $status['total'] . ' คน)';
                                            $boxColor = 'text-bg-success';
                                        } else {
                                            $statusText = 'ประเมินบางส่วน (' . $status['assessed'] . '/' . $status['total'] . ' คน)';
                                            $boxColor = 'text-bg-warning';
                                        }
                                    }
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="small-box <?= $boxColor ?>">
                                        <div class="inner">
                                            <h3><?= esc($class['Reg_Class']) ?></h3>
                                            <p><?= $statusText ?></p>
                                        </div>
                                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                                        </svg>
                                        <a href="<?= base_url('teacher/desirable_assessment/assess/' . $class['Reg_Class']) ?>" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            ดำเนินการ <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="small-box text-bg-info">
                                        <div class="inner">
                                            <h3><?= esc($class['Reg_Class']) ?></h3>
                                            <p>พิมพ์รายงานสรุป</p>
                                        </div>
                                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M6 12a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H6.75A.75.75 0 016 12z" />
                                            <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.25c0 1.036.84 1.875 1.875 1.875h.375a3 3 0 013 3v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V9a3 3 0 013-3h.375c1.035 0 1.875-.84 1.875-1.875v-2.25C21 2.34 20.16 1.5 19.125 1.5h-11.25zM9 9.375c0-1.036.84-1.875 1.875-1.875h2.25C14.16 7.5 15 8.34 15 9.375V15a1.5 1.5 0 01-1.5 1.5h-3A1.5 1.5 0 019 15v-5.625z" clip-rule="evenodd" />
                                            <path d="M4.125 18.375c0-1.035.84-1.875 1.875-1.875h12c1.035 0 1.875.84 1.875 1.875v.375a3 3 0 01-3 3H7.125a3 3 0 01-3-3v-.375z" />
                                        </svg>
                                        <a href="<?= base_url('teacher/desirable_assessment/print_report/' . $class['Reg_Class']) ?>" target="_blank" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            พิมพ์ <i class="fas fa-arrow-circle-right"></i>
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
