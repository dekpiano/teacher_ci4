<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'ดาวน์โหลดแผนการสอน') ?>
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

            <?php  $typeplan = array('แบบตรวจแผนการจัดการเรียนรู้','บันทึกตรวจใช้แผน','โครงการสอน','แผนการสอนหน้าเดียว','บันทึกหลังสอน'); ?>
            <div class="card p-3">
                <div cass="card-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="mr-2">
                            <select name="SelTeacher" id="SelTeacher" class="form-control w-auto">
                                <option value="All">เลือกทั้งหมด</option>
                                <?php foreach ($SelTeacher as $v_SelTeacher): ?>
                                <option <?= ($CheckTeach == $v_SelTeacher->pers_id) ? "selected":"" ?> value="<?= esc($v_SelTeacher->pers_id) ?>">
                                    <?= esc($v_SelTeacher->pers_prefix . $v_SelTeacher->pers_firstname . ' ' . $v_SelTeacher->pers_lastname) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mr-2">                      
                            <select name="CheckYear" id="CheckYear" class="form-control w-auto">
                                <?php foreach ($CheckYear as $v_CheckYear): ?>
                                <option
                                    <?= ($current_year == $v_CheckYear->seplan_year && $current_term == $v_CheckYear->seplan_term) ? "selected":"" ?>
                                    value="<?= esc($v_CheckYear->seplan_year.'/'.$v_CheckYear->seplan_term) ?>">
                                    <?= esc($v_CheckYear->seplan_term.'/'.$v_CheckYear->seplan_year) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mr-2"> 
                        <button type="button" id="SearchPlan" class="btn btn-primary"> ค้นหาแผน</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($CheckTeach != "All"): ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tb_plan">
                            <thead>
                                <tr>
                                    <th scope="col">ปีการศึกษา</th>
                                    <th scope="col">รหัสชื่อวิชา</th>
                                    <th scope="col">ระดับ</th>
                                    <th scope="col">ประเภท</th>
                                    <?php foreach($typeplan as $tp): ?>
                                    <th scope="col"><?= esc($tp) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Reorganize plan data for easier display
                                $organizedPlans = [];
                                foreach ($plan as $p) {
                                    $key = $p->seplan_coursecode . '-' . $p->seplan_year . '-' . $p->seplan_term;
                                    if (!isset($organizedPlans[$key])) {
                                        $organizedPlans[$key] = [
                                            'seplan_year' => $p->seplan_year,
                                            'seplan_term' => $p->seplan_term,
                                            'seplan_coursecode' => $p->seplan_coursecode,
                                            'seplan_namesubject' => $p->seplan_namesubject,
                                            'seplan_gradelevel' => $p->seplan_gradelevel,
                                            'seplan_typesubject' => $p->seplan_typesubject,
                                            'files' => []
                                        ];
                                    }
                                    $organizedPlans[$key]['files'][$p->seplan_typeplan] = $p->seplan_file;
                                }
                                ?>
                                <?php foreach ($organizedPlans as $op):?>
                                <tr>
                                    <td scope="row"><?= esc($op['seplan_year']) ?>/<?= esc($op['seplan_term']) ?></td>
                                    <td><?= esc($op['seplan_coursecode']) ?> <?= esc($op['seplan_namesubject']) ?></td>
                                    <td>ม.<?= esc($op['seplan_gradelevel']) ?></td>
                                    <td><?= esc($op['seplan_typesubject']) ?></td>

                                    <?php foreach($typeplan as $tp): ?>
                                    <td>
                                        <?php if(isset($op['files'][$tp]) && !empty($op['files'][$tp])): ?>
                                        <a href="<?= base_url('uploads/academic/course/plan/' . esc($op['seplan_year']) . '/' . esc($op['seplan_term']) . '/' . esc($op['seplan_namesubject']) . '/' . esc($op['files'][$tp])) ?>"
                                            target="_blank" rel="noopener noreferrer">
                                            <span class="badge badge-primary h6 text-white"><i class="bi bi-eye-fill"
                                                    aria-hidden="true" data-toggle="popover" data-trigger="hover"
                                                    data-content="เปิดดู" data-placement="top"></i></span>
                                        </a>
                                        <?php else: ?>
                                        <span class="badge badge-danger h6 text-white">ยังไม่ส่ง</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php else:  ?>
                <div class="card">
                    <div class="card-body">
                       <div class="text-center">
                       กรุณาเลือกครูผู้สอน เพื่อดาวน์โหลดไฟล์
                       </div> 
                    </div>
                </div>
            <?php endif; ?>


        </div>
    </div>
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#SearchPlan').on('click', function() {
        var selectedTeacher = $('#SelTeacher').val();
        var selectedYearTerm = $('#CheckYear').val();
        var yearParts = selectedYearTerm.split('/');
        var year = yearParts[0];
        var term = yearParts[1];
        window.location.href = '<?= site_url('curriculum/load-plan/') ?>' + year + '/' + term + '/' + selectedTeacher;
    });

    // Initialize DataTables if needed
    // $('#tb_plan').DataTable();
});
</script>
<?= $this->endSection() ?>
