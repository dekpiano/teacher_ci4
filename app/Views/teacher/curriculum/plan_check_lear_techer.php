<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? '') ?><?= esc($lean[0]->lear_namethai ?? '') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= esc($title ?? '') ?><?= esc($lean[0]->lear_namethai ?? '') ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= site_url('curriculum/check-plan') ?>">กลุ่มสาระ</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('curriculum/check-plan-lear/' . esc($lean[0]->lear_id ?? '')) ?>"><?= esc($lean[0]->lear_namethai ?? '') ?></a></li>
                        <li class="breadcrumb-item active"><?= esc($planNew[0]->pers_prefix ?? '') ?><?= esc($planNew[0]->pers_firstname ?? '') ?> <?= esc($planNew[0]->pers_lastname ?? '') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="articles card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="h3">ส่งแผนของ <?= esc($planNew[0]->pers_prefix ?? '') ?><?= esc($planNew[0]->pers_firstname ?? '') ?> <?= esc($planNew[0]->pers_lastname ?? '') ?> </h4>
                    <div class="mr-2">                      
                            <select name="CheckYearCheckPlan" id="CheckYearCheckPlan" class="form-control w-auto">
                                <?php foreach ($CheckYear as $v_CheckYear): ?>
                                <option
                                    <?= (service('uri')->getSegment(5) == $v_CheckYear->seplan_year && service('uri')->getSegment(6) == $v_CheckYear->seplan_term) ? "selected":"" ?>
                                    value="<?= esc($v_CheckYear->seplan_year.'/'.$v_CheckYear->seplan_term) ?>">
                                    <?= esc($v_CheckYear->seplan_term.'/'.$v_CheckYear->seplan_year) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                </div>
                
            </div>

            <?php  $typeplan = array('บันทึกตรวจใช้แผน','แบบตรวจแผนการจัดการเรียนรู้','โครงการสอน','แผนการสอนหน้าเดียว','บันทึกหลังสอน'); ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb_checkplan" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="w-auto">ปีการศึกษา</th>
                                    <th class="w-25">รหัสชื่อวิชา</th>
                                    <th class="w-auto">ระดับ</th>
                                    <th class="w-auto">ผู้ส่ง</th>
                                    <th class="w-auto">แบบตรวจแผน</th>
                                    <th class="w-auto">บันทึกตรวจใช้แผน</th>
                                    <th class="w-auto">โครงการสอน</th>
                                    <th class="w-auto">แผนการสอนหน้าเดียว</th>
                                    <th class="w-auto">บันทึกหลังสอน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  foreach ($planNew as $v_planNew): ?>
                                <tr>
                                    <td scope="row"><?= esc($v_planNew->seplan_year) ?>/<?= esc($v_planNew->seplan_term) ?></td>
                                    <td><?= esc($v_planNew->seplan_coursecode) ?> <?= esc($v_planNew->seplan_namesubject) ?>
                                        (<?= esc($v_planNew->seplan_typesubject) ?>)</td>
                                    <td>ม.<?= esc($v_planNew->seplan_gradelevel) ?></td>
                                    <td><?= esc($v_planNew->pers_prefix) ?><?= esc($v_planNew->pers_firstname) ?> <?= esc($v_planNew->pers_lastname) ?>
                                    </td>

                                    <?php foreach($typeplan as $v_typeplan): ?>
                                    <?php 
                                        $found_plan = null;
                                        foreach($checkplan as $v_plan) {
                                            if($v_plan->seplan_coursecode == $v_planNew->seplan_coursecode && $v_plan->seplan_typeplan == $v_typeplan && $v_planNew->pers_id == $v_plan->seplan_usersend) {
                                                $found_plan = $v_plan;
                                                break;
                                            }
                                        }
                                    ?>
                                    <td>
                                        <?php if($found_plan && $found_plan->seplan_file == null): ?>
                                        <span class="badge badge-danger h6 text-white">ยังไม่ส่ง</span>
                                        <?php elseif($found_plan && $found_plan->seplan_file != null): ?>
                                        <span class="badge badge-success h6 text-white">ส่งแล้ว</span>
                                        <a href="<?= base_url('uploads/academic/course/plan/' . esc($found_plan->seplan_year) . '/' . esc($found_plan->seplan_term) . '/' . esc($found_plan->seplan_namesubject) . '/' . esc($found_plan->seplan_file)) ?>"
                                            target="_blank" rel="noopener noreferrer">
                                            <span class="badge badge-primary h6 text-white"><i class="bi bi-eye-fill"
                                                    aria-hidden="true" data-toggle="popover" data-trigger="hover"
                                                    data-content="เปิดดู" data-placement="top"></i></span>
                                        </a>
                                        <?php else: ?>
                                        <span class="badge badge-secondary h6 text-white">ไม่มีข้อมูล</span>
                                        <?php endif; ?>

                                        <br>
                                        <small><b>ผู้ส่ง :</b> <?= esc($found_plan ? $found_plan->seplan_sendcomment : '-') ?></small> <br>
                                        <small><b>หน.ก : </b>
                                            <?php 
                                            $textColor1="";
                                            if($found_plan && $found_plan->seplan_status1 == "ผ่าน"){
                                                $textColor1="text-success";
                                            }elseif($found_plan && $found_plan->seplan_status1 == "ไม่ผ่าน"){
                                                $textColor1="text-danger";
                                            }
                                            ?>
                                            <?php if(session('person_id') == 'pers_014' && session('learning') != ($IDlear ?? '')): // This logic needs to be re-evaluated for CI4 roles ?>
                                            <span class="<?= esc($textColor1) ?>"> <?= esc($found_plan ? $found_plan->seplan_status1 : 'รอตรวจ') ?></span>
                                            <?php else: ?>
                                            <select id="seplan_status1" name="seplan_status1"
                                                data-planId="<?= esc($found_plan ? $found_plan->seplan_ID : '') ?>"
                                                class="bgC<?= esc($found_plan ? $found_plan->seplan_ID : '') ?> seplan_status1 <?= esc($textColor1) ?> ">
                                                <option <?= ($found_plan && $found_plan->seplan_status1 == "รอตรวจ") ? 'selected' : ''?>
                                                    value="รอตรวจ">รอตรวจ</option>
                                                <option <?= ($found_plan && $found_plan->seplan_status1 == "ผ่าน") ? 'selected' : ''?>
                                                    value="ผ่าน">ผ่าน</option>
                                                <option <?= ($found_plan && $found_plan->seplan_status1 == "ไม่ผ่าน") ? 'selected' : ''?>
                                                    value="ไม่ผ่าน">ไม่ผ่าน</option>
                                            </select>
                                            <div class="IDCom0<?= esc($found_plan ? $found_plan->seplan_ID : '') ?> TbShowComment1">
                                                <?= ($found_plan && $found_plan->seplan_status1 == "ไม่ผ่าน") ? '<a href="#" class="show_comment1" data-toggle="modal" data-planId="' . esc($found_plan->seplan_ID) . '" data-target="#addcomment1">หมายเหตุ</a>' : ''?>
                                            </div>
                                           
                                            <?php endif; ?>
                                        </small>
                                        <br>
                                        <small><b>หน.ง : </b>
                                            <?php 
                                            $textColor2="";
                                            if($found_plan && $found_plan->seplan_status2 == "ผ่าน"){
                                                $textColor2="text-success";
                                            }elseif($found_plan && $found_plan->seplan_status2 == "ไม่ผ่าน"){
                                                $textColor2="text-danger";
                                            }
                                            ?>
                                            <?php if(session('person_id') == 'pers_051'):?>
                                            <select id="seplan_status2" name="seplan_status2"
                                                planId="<?= esc($found_plan ? $found_plan->seplan_ID : '') ?>"
                                                class="bgCC<?= esc($found_plan ? $found_plan->seplan_ID : '') ?>  seplan_status2 <?= esc($textColor2) ?>">
                                                <option <?= ($found_plan && $found_plan->seplan_status2 == "รอตรวจ") ? 'selected' : ''?>
                                                    value="รอตรวจ">รอตรวจ</option>
                                                <option <?= ($found_plan && $found_plan->seplan_status2 == "ผ่าน") ? 'selected' : ''?>
                                                    value="ผ่าน">ผ่าน</option>
                                                <option <?= ($found_plan && $found_plan->seplan_status2 == "ไม่ผ่าน") ? 'selected' : ''?>
                                                    value="ไม่ผ่าน">ไม่ผ่าน</option>
                                            </select>
                                            <div class="IDCom<?= esc($found_plan ? $found_plan->seplan_ID : '') ?> TbShowComment2">
                                                <?= ($found_plan && $found_plan->seplan_status2 == "ไม่ผ่าน") ? '<a href="#" class="show_comment2" data-toggle="modal" data-planId="' . esc($found_plan->seplan_ID) . '" data-target="#addcomment2">หมายเหตุ</a>' : ''?>
                                            </div>
                                            <?php else: echo esc($found_plan ? $found_plan->seplan_status2 : 'รอตรวจ'); ?>
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <div id="addcomment1" tabindex="-1" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true"
        style="display: none;">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">

                    <form id="form-comment1" class="form-comment1">
                        <div class="form-group">
                            <label for="seplan_comment1">หมายเหตุ:</label>
                            <textarea wrap="hard" class="form-control seplan_comment1" rows="5" name="seplan_comment1"
                                id="seplan_comment1"
                                placeholder="ไม่ผ่านเพราะ เช่น ปรับชื่อรายชื่อ หน้า 5 หรือ ลืมใส่ข้อมูลต้องกรอก"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" id="sub_comment1" data-planId class="btn btn-primary">บันทึก</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="addcomment2" tabindex="-1" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true"
        style="display: none;">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">

                    <form id="form-comment2" class="form-comment2">
                        <div class="form-group">
                            <label for="seplan_comment2">หมายเหตุ:</label>
                            <textarea wrap="hard" class="form-control seplan_comment2" rows="5" name="seplan_comment2"
                                id="seplan_comment2"
                                placeholder="ไม่ผ่านเพราะ เช่น ปรับชื่อรายชื่อ หน้า 5 หรือ ลืมใส่ข้อมูลต้องกรอก"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" id="sub_comment2" data-planId class="btn btn-primary">บันทึก</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // JavaScript for handling comments (AJAX calls will need to be implemented in controller)
    $('.show_comment1').on('click', function() {
        var planId = $(this).data('planid');
        $('#addcomment1 #sub_comment1').data('planId', planId);
        // Fetch existing comment if any
        $.ajax({
            url: '<?= site_url('curriculum/check-comment1') ?>',
            type: 'POST',
            data: { planId: planId },
            dataType: 'json',
            success: function(response) {
                if (response && response[0] && response[0].seplan_comment1) {
                    $('#addcomment1 #seplan_comment1').val(response[0].seplan_comment1.replace(/<br>/g, '\n'));
                } else {
                    $('#addcomment1 #seplan_comment1').val('');
                }
            }
        });
    });

    $('#sub_comment1').on('click', function() {
        var planId = $(this).data('planId');
        var comment = $('#addcomment1 #seplan_comment1').val();
        $.ajax({
            url: '<?= site_url('curriculum/update-comment1') ?>',
            type: 'POST',
            data: { planId: planId, seplan_comment1: comment },
            success: function(response) {
                if (response == 1) {
                    Swal.fire('สำเร็จ', 'บันทึกหมายเหตุสำเร็จ', 'success');
                    $('#addcomment1').modal('hide');
                } else {
                    Swal.fire('ผิดพลาด', 'บันทึกหมายเหตุไม่สำเร็จ', 'error');
                }
            }
        });
    });

    $('.show_comment2').on('click
', function() {
        var planId = $(this).data('planid');
        $('#addcomment2 #sub_comment2').data('planId', planId);
        // Fetch existing comment if any
        $.ajax({
            url: '<?= site_url('curriculum/check-comment2') ?>',
            type: 'POST',
            data: { planId: planId },
            dataType: 'json',
            success: function(response) {
                if (response && response[0] && response[0].seplan_comment2) {
                    $('#addcomment2 #seplan_comment2').val(response[0].seplan_comment2.replace(/<br>/g, '\n'));
                } else {
                    $('#addcomment2 #seplan_comment2').val('');
                }
            }
        });
    });

    $('#sub_comment2').on('click', function() {
        var planId = $(this).data('planId');
        var comment = $('#addcomment2 #seplan_comment2').val();
        $.ajax({
            url: '<?= site_url('curriculum/update-comment2') ?>',
            type: 'POST',
            data: { planId: planId, seplan_comment2: comment },
            success: function(response) {
                if (response == 1) {
                    Swal.fire('สำเร็จ', 'บันทึกหมายเหตุสำเร็จ', 'success');
                    $('#addcomment2').modal('hide');
                } else {
                    Swal.fire('ผิดพลาด', 'บันทึกหมายเหตุไม่สำเร็จ', 'error');
                }
            }
        });
    });

    // Status update dropdowns
    $('#tb_checkplan').on('change', '.seplan_status1', function() {
        var planId = $(this).data('planid');
        var status = $(this).val();
        var $this = $(this);
        $.ajax({
            url: '<?= site_url('curriculum/update-status1') ?>',
            type: 'POST',
            data: { planId: planId, status1: status },
            dataType: 'json',
            success: function(response) {
                if (response && response[0]) {
                    if (response[0].seplan_status1 === 'ไม่ผ่าน') {
                        $('.IDCom0' + planId).html('<a href="#" class="show_comment1" data-toggle="modal" data-planId="' + planId + '" data-target="#addcomment1">หมายเหตุ</a>');
                        $this.removeClass('text-success').addClass('text-danger');
                    } else if (response[0].seplan_status1 === 'ผ่าน') {
                        $('.IDCom0' + planId).empty();
                        $this.removeClass('text-danger').addClass('text-success');
                    } else {
                        $('.IDCom0' + planId).empty();
                        $this.removeClass('text-success text-danger');
                    }
                }
            }
        });
    });

    $('#tb_checkplan').on('change', '.seplan_status2', function() {
        var planId = $(this).data('planid');
        var status = $(this).val();
        var $this = $(this);
        $.ajax({
            url: '<?= site_url('curriculum/update-status2') ?>',
            type: 'POST',
            data: { planId: planId, status2: status },
            dataType: 'json',
            success: function(response) {
                if (response && response[0]) {
                    if (response[0].seplan_status2 === 'ไม่ผ่าน') {
                        $('.IDCom' + planId).html('<a href="#" class="show_comment2" data-toggle="modal" data-planId="' + planId + '" data-target="#addcomment2">หมายเหตุ</a>');
                        $this.removeClass('text-success').addClass('text-danger');
                    } else if (response[0].seplan_status2 === 'ผ่าน') {
                        $('.IDCom' + planId).empty();
                        $this.removeClass('text-danger').addClass('text-success');
                    } else {
                        $('.IDCom' + planId).empty();
                        $this.removeClass('text-success text-danger');
                    }
                }
            }
        });
    });

});
</script>
<?= $this->endSection() ?>
