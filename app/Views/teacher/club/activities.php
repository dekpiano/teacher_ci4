<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'รายงานกิจกรรมชุมนุม') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= esc($title ?? 'รายงานกิจกรรมชุมนุม') ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createActivityModal">
                            <i class="bi bi-plus"></i> เพิ่มกิจกรรมใหม่
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($activities) && is_array($activities)): ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>วันที่</th>
                                    <th>หัวข้อกิจกรรม</th>
                                    <th>คำอธิบาย</th>
                                    <th style="width: 150px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($activities as $activity): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($activity->activity_date) ?></td>
                                        <td><?= esc($activity->activity_title) ?></td>
                                        <td><?= esc($activity->activity_description) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm edit-activity-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editActivityModal"
                                                    data-activityid="<?= esc($activity->activity_id) ?>"
                                                    data-activitydate="<?= esc($activity->activity_date) ?>"
                                                    data-activitytitle="<?= esc($activity->activity_title) ?>"
                                                    data-activitydescription="<?= esc($activity->activity_description) ?>">
                                                <i class="bi bi-pencil-square"></i> แก้ไข
                                            </button>
                                            <form action="<?= site_url('club/deleteActivity/' . $club->club_id . '/' . $activity->activity_id) ?>" method="post" class="d-inline delete-activity-form">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> ลบ
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            ไม่พบกิจกรรมสำหรับชุมนุมนี้
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Activity Modal -->
<div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog" aria-labelledby="createActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('club/createActivity/' . $club->club_id) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="createActivityModalLabel">เพิ่มกิจกรรมใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="activity_date">วันที่</label>
                        <input type="date" class="form-control" id="activity_date" name="activity_date" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="activity_title">หัวข้อกิจกรรม</label>
                        <input type="text" class="form-control" id="activity_title" name="activity_title" placeholder="ระบุหัวข้อกิจกรรม" required>
                    </div>
                    <div class="form-group">
                        <label for="activity_description">คำอธิบายกิจกรรม</label>
                        <textarea class="form-control" id="activity_description" name="activity_description" rows="3" placeholder="ระบุคำอธิบายโดยย่อ"></textarea>
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

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1" role="dialog" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editActivityForm" action="" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editActivityModalLabel">แก้ไขกิจกรรม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="activity_id" id="edit_activity_id">
                    <div class="form-group">
                        <label for="edit_activity_date">วันที่</label>
                        <input type="date" class="form-control" id="edit_activity_date" name="activity_date" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_activity_title">หัวข้อกิจกรรม</label>
                        <input type="text" class="form-control" id="edit_activity_title" name="activity_title" placeholder="ระบุหัวข้อกิจกรรม" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_activity_description">คำอธิบายกิจกรรม</label>
                        <textarea class="form-control" id="edit_activity_description" name="activity_description" rows="3" placeholder="ระบุคำอธิบายโดยย่อ"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Handle Edit Activity Modal data population
        $('#editActivityModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var activityId = button.data('activityid');
            var activityDate = button.data('activitydate');
            var activityTitle = button.data('activitytitle');
            var activityDescription = button.data('activitydescription');

            var modal = $(this);
            modal.find('#edit_activity_id').val(activityId);
            modal.find('#edit_activity_date').val(activityDate);
            modal.find('#edit_activity_title').val(activityTitle);
            modal.find('#edit_activity_description').val(activityDescription);

            // Update form action URL
            var clubId = <?= esc($club->club_id) ?>;
            modal.find('#editActivityForm').attr('action', '<?= site_url('club/updateActivity/') ?>' + clubId + '/' + activityId);
        });

        // Handle Delete Activity confirmation
        $('.delete-activity-form').submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            var form = this;
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการลบกิจกรรมนี้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
