<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'ตารางกิจกรรมชุมนุม') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= esc($title ?? 'ตารางกิจกรรมชุมนุม') ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createScheduleModal">
                            <i class="bi bi-plus"></i> สร้างตารางกิจกรรมใหม่
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($schedules) && is_array($schedules)): ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>หัวข้อกิจกรรม</th>
                                    <th>วันที่</th>
                                    <th>ปีการศึกษา/ภาคเรียน</th>
                                    <th style="width: 150px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($schedules as $schedule): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($schedule->schedule_title) ?></td>
                                        <td><?= esc($schedule->schedule_date) ?></td>
                                        <td><?= esc($schedule->academic_year) ?>/<?= esc($schedule->term) ?></td>
                                        <td>
                                            <a href="<?= site_url('club/recordAttendance/' . $club->club_id . '/' . $schedule->schedule_id) ?>" class="btn btn-info btn-sm">
                                                <i class="bi bi-clipboard-check"></i> บันทึกการเข้าเรียน
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            ไม่พบตารางกิจกรรมสำหรับชุมนุมนี้
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Schedule Modal -->
<div class="modal fade" id="createScheduleModal" tabindex="-1" role="dialog" aria-labelledby="createScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('club/createSchedule/' . $club->club_id) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="createScheduleModalLabel">สร้างตารางกิจกรรมใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="schedule_title" name="schedule_title" placeholder="เช่น กิจกรรมสัปดาห์ที่ 1" required>
                        <label for="schedule_title">หัวข้อกิจกรรม</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="schedule_date" name="schedule_date" value="<?= date('Y-m-d') ?>" required>
                        <label for="schedule_date">วันที่</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
