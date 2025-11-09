<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'ชุมนุมที่ปรึกษา') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= esc($title ?? 'ชุมนุมที่ปรึกษา') ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createClubModal">
                            <i class="bi bi-plus"></i> สร้างชุมนุมใหม่
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($clubs) && is_array($clubs)): ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>ชื่อชุมนุม</th>
                                    <th>คำอธิบาย</th>
                                    <th style="width: 150px;">สถานะ</th>
                                    <th style="width: 150px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($clubs as $club): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($club->club_name) ?></td>
                                        <td><?= esc($club->club_description) ?></td>
                                        <td class="text-center">
                                            <?php $color =  $club->club_status === 'open' ? 'text-bg-success' : 'text-bg-danger' ?> 
                                            <?php if ($club->club_status === 'open'): ?>
                                               <span class="badge <?=$color?>"> เปิดรับสมัคร </span>
                                            <?php else: ?>
                                                ปิดรับสมัคร
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('club/manage/' . $club->club_id) ?>" class="btn btn-info btn-sm">
                                                <i class="bi bi-pencil-square"></i> จัดการ
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            ไม่พบชุมนุมที่คุณเป็นที่ปรึกษา
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Club Modal -->
<div class="modal fade" id="createClubModal" tabindex="-1" role="dialog" aria-labelledby="createClubModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('club/create') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="createClubModalLabel">สร้างชุมนุมใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="club_name">ชื่อชุมนุม</label>
                        <input type="text" class="form-control" id="club_name" name="club_name" placeholder="ระบุชื่อชุมนุม" required>
                    </div>
                    <div class="form-group">
                        <label for="club_description">คำอธิบายชุมนุม</label>
                        <textarea class="form-control" id="club_description" name="club_description" rows="3" placeholder="ระบุคำอธิบายโดยย่อ"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="club_max_participants">จำนวนรับสูงสุด (คน)</label>
                        <input type="number" class="form-control" id="club_max_participants" name="club_max_participants" value="50" required>
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
