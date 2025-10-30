<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? '') ?>
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
                        <li class="breadcrumb-item"><a href="<?= site_url('teacher/curriculum') ?>">หน้าหลัก</a></li>
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
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">รายการแผนการสอนที่ส่งเข้ามา</h3>
                    <div class="mr-2">                      
                        <select name="CheckYearCheckPlan" id="CheckYearCheckPlan" class="form-control w-auto">
                            <?php foreach ($CheckYear as $v_CheckYear): ?>
                            <option
                                <?= ($current_year == $v_CheckYear->seplan_year && $current_term == $v_CheckYear->seplan_term) ? "selected":"" ?>
                                value="<?= esc($v_CheckYear->seplan_year.'/'.$v_CheckYear->seplan_term) ?>">
                                <?= esc($v_CheckYear->seplan_term.'/'.$v_CheckYear->seplan_year) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb_checkplan_head" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ปีการศึกษา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ระดับชั้น</th>
                                    <th>ผู้ส่ง</th>
                                    <th>ประเภทแผน</th>
                                    <th>ไฟล์</th>
                                    <th>สถานะ (หน.กลุ่มสาระ)</th>
                                    <th>สถานะ (หน.งาน)</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($plans as $plan): ?>
                                    <tr>
                                        <td><?= esc($plan->seplan_year . '/' . $plan->seplan_term) ?></td>
                                        <td><?= esc($plan->seplan_namesubject) ?> (<?= esc($plan->seplan_coursecode) ?>)</td>
                                        <td>ม.<?= esc($plan->seplan_gradelevel) ?></td>
                                        <td><?= esc($plan->pers_firstname . ' ' . $plan->pers_lastname) ?></td>
                                        <td><?= esc($plan->seplan_typeplan) ?></td>
                                        <td>
                                            <?php if ($plan->seplan_file): ?>
                                                <a href="<?= rtrim($upload_base_url, '/') .'/'. esc($plan->seplan_year) . '/' . esc($plan->seplan_term) . '/' . rawurlencode(esc($plan->seplan_namesubject)) . '/' . rawurlencode(esc($plan->seplan_file)) ?>" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> ดูไฟล์
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-danger">ยังไม่ส่ง</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $status_class = '';
                                                if ($plan->seplan_status1 == 'ผ่าน') {
                                                    $status_class = 'bg-success text-white';
                                                } elseif ($plan->seplan_status1 == 'ไม่ผ่าน') {
                                                    $status_class = 'bg-danger text-white';
                                                } elseif ($plan->seplan_status1 == 'รอตรวจ') {
                                                    $status_class = 'bg-warning';
                                                }
                                            ?>
                                            <select class="form-select form-select-sm seplan_status1 <?= $status_class ?>" data-plan-id="<?= esc($plan->seplan_ID) ?>">
                                                <option value="รอตรวจ" <?= $plan->seplan_status1 == 'รอตรวจ' ? 'selected' : '' ?>>รอตรวจ</option>
                                                <option value="ผ่าน" <?= $plan->seplan_status1 == 'ผ่าน' ? 'selected' : '' ?>>ผ่าน</option>
                                                <option value="ไม่ผ่าน" <?= $plan->seplan_status1 == 'ไม่ผ่าน' ? 'selected' : '' ?>>ไม่ผ่าน</option>
                                            </select>
                                        </td>
                                        <td>
                                            <span class="badge <?= $plan->seplan_status2 == 'ผ่าน' ? 'bg-success' : ($plan->seplan_status2 == 'ไม่ผ่าน' ? 'bg-danger' : 'bg-warning') ?>">
                                                <?= esc($plan->seplan_status2) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-comment" data-plan-id="<?= esc($plan->seplan_ID) ?>" data-comment-type="1">
                                                <i class="bi bi-chat-dots"></i> ความเห็น
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commentModalLabel">แสดงความคิดเห็น</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="comment-form">
          <input type="hidden" name="plan_id" id="plan_id">
          <input type="hidden" name="comment_type" id="comment_type">
          <div class="mb-3">
            <label for="comment-text" class="col-form-label">ความคิดเห็น:</label>
            <textarea class="form-control" id="comment-text" name="comment"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="save-comment">บันทึก</button>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#tb_checkplan_head').DataTable();

    $('#CheckYearCheckPlan').on('change', function() {
        var selectedYearTerm = $(this).val();
        window.location = "<?= site_url('curriculum/check-plan-head-detail/' . ($teacher_info->pers_id ?? '') . '/') ?>" + selectedYearTerm;
    });

    // Handle status change
    $('#tb_checkplan_head').on('change', '.seplan_status1', function() {
        const planId = $(this).data('plan-id');
        const status = $(this).val();

        $.ajax({
            url: '<?= site_url('curriculum/update_status1') ?>',
            method: 'POST',
            data: {
                plan_id: planId,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire('สำเร็จ!', 'อัปเดตสถานะเรียบร้อย', 'success');
                    const selectElement = $(`.seplan_status1[data-plan-id='${planId}']`);
                    selectElement.removeClass('bg-success bg-danger bg-warning text-white');
                    if (status === 'ผ่าน') {
                        selectElement.addClass('bg-success text-white');
                    } else if (status === 'ไม่ผ่าน') {
                        selectElement.addClass('bg-danger text-white');
                    } else if (status === 'รอตรวจ') {
                        selectElement.addClass('bg-warning');
                    }
                } else {
                    Swal.fire('ผิดพลาด!', 'ไม่สามารถอัปเดตสถานะได้', 'error');
                }
            }
        });
    });

    // Handle comment modal
    $('#tb_checkplan_head').on('click', '.btn-comment', function() {
        const planId = $(this).data('plan-id');
        const commentType = $(this).data('comment-type');
        
        const modal = $('#commentModal');
        modal.find('#plan_id').val(planId);
        modal.find('#comment_type').val(commentType);

        // Fetch existing comment
        $.ajax({
            url: '<?= site_url('curriculum/get_comment') ?>',
            method: 'POST',
            data: { plan_id: planId, comment_type: commentType },
            success: function(response) {
                modal.find('#comment-text').val(response.comment);
            }
        });

        modal.modal('show');
    });

    // Save comment
    $('#save-comment').on('click', function() {
        const planId = $('#plan_id').val();
        const commentType = $('#comment_type').val();
        const comment = $('#comment-text').val();

        $.ajax({
            url: '<?= site_url('curriculum/save_comment') ?>',
            method: 'POST',
            data: {
                plan_id: planId,
                comment_type: commentType,
                comment: comment
            },
            success: function(response) {
                if(response.success) {
                    $('#commentModal').modal('hide');
                    Swal.fire('สำเร็จ!', 'บันทึกความคิดเห็นเรียบร้อย', 'success');
                } else {
                    Swal.fire('ผิดพลาด!', 'ไม่สามารถบันทึกความคิดเห็นได้', 'error');
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
