<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'ตั้งค่าครูผู้สอน') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?= esc($title ?? '') ?></h2>
    </div>
</header>
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">เพิ่มข้อมูลทีละรายการ</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate id="form_insert_plan">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="seplan_coursecode">รหัสวิชา</label>
                                        <input type="text" class="form-control" placeholder="รหัสวิชา"
                                            id="seplan_coursecode" name="seplan_coursecode" required>
                                        <div class="invalid-feedback">กรุณากรอกรหัสวิชา</div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="seplan_namesubject">ชื่อวิชา</label>
                                        <input type="text" class="form-control" placeholder="ชื่อวิชา"
                                            id="seplan_namesubject" name="seplan_namesubject" required>
                                        <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="seplan_gradelevel">ระดับชั้น</label>
                                        <select class="form-control" id="seplan_gradelevel" name="seplan_gradelevel"
                                            required>
                                            <option value="">เลือกระดับชั้น</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                        <div class="invalid-feedback">กรุณาเลือกระดับชั้น</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="seplan_typesubject">ประเภท</label>
                                        <select class="form-control" id="seplan_typesubject" name="seplan_typesubject"
                                            required>
                                            <option value="">เลือกประเภท</option>
                                            <option value="พื้นฐาน">พื้นฐาน</option>
                                            <option value="เพิ่มเติม">เพิ่มเติม</option>
                                        </select>
                                        <div class="invalid-feedback">กรุณาเลือประเภท</div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="seplan_usersend">ครูผู้สอน</label>
                                        <select class="form-control" id="seplan_usersend" name="seplan_usersend"
                                            required>
                                            <option value="">เลือกครูผู้สอน</option>
                                            <?php foreach ($pers as $v_pers): ?>
                                            <option value="<?= esc($v_pers->pers_id) ?>">
                                                <?= esc($v_pers->pers_prefix . $v_pers->pers_firstname . ' ' . $v_pers->pers_lastname) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">กรุณาครูผู้สอน</div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">บันทึก</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">อัพโหลดข้อมูลทีเดียวทั้งหมด</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <form action="<?= site_url('curriculum/upload-plan') ?>" method="post" enctype="multipart/form-data">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileInput" name="file" aria-describedby="customFileInput">
                                    <label class="custom-file-label" for="customFileInput">เลือกไฟล์...</label>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" type="submit">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-header d-flex align-items-center">
                <h3 class="h4">รายการวิชาที่สอน</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="TableShoowPlan">
                    <thead>
                        <tr>
                            <th>ปีการศึกษา</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th>ระดับชั้น</th>
                            <th>ประเภท</th>
                            <th>ครูผู้สอน</th>
                            <th>คำสั่ง</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($Plan)): ?>
                        <?php foreach ($Plan as $v_Plan): ?>
                        <tr id="<?= esc($v_Plan->seplan_coursecode) ?>">
                            <td><?= esc($v_Plan->seplan_year) ?>/<?= esc($v_Plan->seplan_term) ?></td>
                            <td><?= esc($v_Plan->seplan_coursecode) ?></td>
                            <td><?= esc($v_Plan->seplan_namesubject) ?></td>
                            <td>ม.<?= esc($v_Plan->seplan_gradelevel) ?></td>
                            <td><?= esc($v_Plan->seplan_typesubject) ?></td>
                            <td><?= esc($v_Plan->pers_prefix) ?><?= esc($v_Plan->pers_firstname) ?> <?= esc($v_Plan->pers_lastname) ?>
                            </td>
                            <td width="10%"><a class="EditTeach" PlanCode="<?= esc($v_Plan->seplan_coursecode) ?>" PlanYear="<?= esc($v_Plan->seplan_year) ?>" PlanTerm="<?= esc($v_Plan->seplan_term) ?>" href="#"
                                    data-toggle="modal" data-target="#editteacher">แก้ไข</a> |
                                <a href="javascript:void(0)" class="DeleteTeach"
                                    delplancode="<?= esc($v_Plan->seplan_coursecode) ?>"
                                    delplanyear="<?= esc($v_Plan->seplan_year) ?>" delplanterm="<?= esc($v_Plan->seplan_term) ?>"
                                    delplanname="<?= esc($v_Plan->seplan_namesubject) ?>">ลบ</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>


    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="editteacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="FromUpdateTeacher">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="up_seplan_year">ปีการศึกษา</label>
                                <input readonly type="text" class="form-control" placeholder="รหัสวิชา"
                                    id="up_seplan_year" name="up_seplan_year" required>
                                <div class="invalid-feedback">กรุณากรอปีการศึกษา</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="up_seplan_term">ภาคเรียน</label>
                                <input readonly type="text" class="form-control" placeholder="รหัสวิชา"
                                    id="up_seplan_term" name="up_seplan_term" required>
                                <div class="invalid-feedback">กรุณากรอภาคเรียน</div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="up_seplan_coursecode">รหัสวิชา</label>
                                <input readonly type="text" class="form-control" placeholder="รหัสวิชา"
                                    id="up_seplan_coursecode" name="up_seplan_coursecode" required>
                                <div class="invalid-feedback">กรุณากรอกรหัสวิชา</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="up_seplan_namesubject">ชื่อวิชา</label>
                                <input type="text" class="form-control" placeholder="ชื่อวิชา"
                                    id="up_seplan_namesubject" name="up_seplan_namesubject" required>
                                <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="up_seplan_gradelevel">ระดับชั้น</label>
                                <select class="form-control" id="up_seplan_gradelevel" name="up_seplan_gradelevel"
                                    required>
                                    <option value="">เลือกระดับชั้น</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกระดับชั้น</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="seplan_typesubject">ประเภท</label>
                                <select class="form-control" id="up_seplan_typesubject" name="up_seplan_typesubject"
                                    required>
                                    <option value="">เลือกประเภท</option>
                                    <option value="พื้นฐาน">พื้นฐาน</option>
                                    <option value="เพิ่มเติม">เพิ่มเติม</option>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือประเภท</div>
                            </div>
                        </div>
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
            <div class="row">
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">เพิ่มข้อมูลทีละรายการ</h3>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate id="form_insert_plan">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="seplan_coursecode">รหัสวิชา</label>
                                            <input type="text" class="form-control" placeholder="รหัสวิชา"
                                                id="seplan_coursecode" name="seplan_coursecode" required>
                                            <div class="invalid-feedback">กรุณากรอกรหัสวิชา</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="seplan_namesubject">ชื่อวิชา</label>
                                            <input type="text" class="form-control" placeholder="ชื่อวิชา"
                                                id="seplan_namesubject" name="seplan_namesubject" required>
                                            <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="seplan_gradelevel">ระดับชั้น</label>
                                            <select class="form-control" id="seplan_gradelevel" name="seplan_gradelevel"
                                                required>
                                                <option value="">เลือกระดับชั้น</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                            <div class="invalid-feedback">กรุณาเลือกระดับชั้น</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label for="seplan_typesubject">ประเภท</label>
                                            <select class="form-control" id="seplan_typesubject" name="seplan_typesubject"
                                                required>
                                                <option value="">เลือกประเภท</option>
                                                <option value="พื้นฐาน">พื้นฐาน</option>
                                                <option value="เพิ่มเติม">เพิ่มเติม</option>
                                            </select>
                                            <div class="invalid-feedback">กรุณาเลือประเภท</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="seplan_usersend">ครูผู้สอน</label>
                                            <select class="form-control" id="seplan_usersend" name="seplan_usersend"
                                                required>
                                                <option value="">เลือกครูผู้สอน</option>
                                                <?php foreach ($pers as $v_pers): ?>
                                                <option value="<?= esc($v_pers->pers_id) ?>">
                                                    <?= esc($v_pers->pers_prefix . $v_pers->pers_firstname . ' ' . $v_pers->pers_lastname) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">กรุณาครูผู้สอน</div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">อัพโหลดข้อมูลทีเดียวทั้งหมด</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form action="<?= site_url('curriculum/upload-plan') ?>" method="post" enctype="multipart/form-data">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFileInput" name="file" aria-describedby="customFileInput">
                                        <label class="custom-file-label" for="customFileInput">เลือกไฟล์...</label>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">

                <div class="card-header d-flex align-items-center">
                    <h3 class="h4">รายการวิชาที่สอน</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="TableShoowPlan">
                        <thead>
                            <tr>
                                <th>ปีการศึกษา</th>
                                <th>รหัสวิชา</th>
                                <th>ชื่อวิชา</th>
                                <th>ระดับชั้น</th>
                                <th>ประเภท</th>
                                <th>ครูผู้สอน</th>
                                <th>คำสั่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($Plan)): ?>
                            <?php foreach ($Plan as $v_Plan): ?>
                            <tr id="<?= esc($v_Plan->seplan_coursecode) ?>">
                                <td><?= esc($v_Plan->seplan_year) ?>/<?= esc($v_Plan->seplan_term) ?></td>
                                <td><?= esc($v_Plan->seplan_coursecode) ?></td>
                                <td><?= esc($v_Plan->seplan_namesubject) ?></td>
                                <td>ม.<?= esc($v_Plan->seplan_gradelevel) ?></td>
                                <td><?= esc($v_Plan->seplan_typesubject) ?></td>
                                <td><?= esc($v_Plan->pers_prefix) ?><?= esc($v_Plan->pers_firstname) ?> <?= esc($v_Plan->pers_lastname) ?>
                                </td>
                                <td width="10%"><a class="EditTeach" PlanCode="<?= esc($v_Plan->seplan_coursecode) ?>" PlanYear="<?= esc($v_Plan->seplan_year) ?>" PlanTerm="<?= esc($v_Plan->seplan_term) ?>" href="#"
                                        data-toggle="modal" data-target="#editteacher">แก้ไข</a> |
                                    <a href="javascript:void(0)" class="DeleteTeach"
                                        delplancode="<?= esc($v_Plan->seplan_coursecode) ?>"
                                        delplanyear="<?= esc($v_Plan->seplan_year) ?>" delplanterm="<?= esc($v_Plan->seplan_term) ?>"
                                        delplanname="<?= esc($v_Plan->seplan_namesubject) ?>">ลบ</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>


        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="editteacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="FromUpdateTeacher">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="up_seplan_year">ปีการศึกษา</label>
                                <input readonly type="text" class="form-control" placeholder="รหัสวิชา"
                                    id="up_seplan_year" name="up_seplan_year" required>
                                <div class="invalid-feedback">กรุณากรอปีการศึกษา</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="up_seplan_term">ภาคเรียน</label>
                                <input readonly type="text" class="form-control" placeholder="รหัสวิชา"
                                    id="up_seplan_term" name="up_seplan_term" required>
                                <div class="invalid-feedback">กรุณากรอภาคเรียน</div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="up_seplan_coursecode">รหัสวิชา</label>
                                <input readonly type="text" class="form-control" placeholder="รหัสวิชา"
                                    id="up_seplan_coursecode" name="up_seplan_coursecode" required>
                                <div class="invalid-feedback">กรุณากรอกรหัสวิชา</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="up_seplan_namesubject">ชื่อวิชา</label>
                                <input type="text" class="form-control" placeholder="ชื่อวิชา"
                                    id="up_seplan_namesubject" name="up_seplan_namesubject" required>
                                <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="up_seplan_gradelevel">ระดับชั้น</label>
                                <select class="form-control" id="up_seplan_gradelevel" name="up_seplan_gradelevel"
                                    required>
                                    <option value="">เลือกระดับชั้น</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกระดับชั้น</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="seplan_typesubject">ประเภท</label>
                                <select class="form-control" id="up_seplan_typesubject" name="up_seplan_typesubject"
                                    required>
                                    <option value="">เลือกประเภท</option>
                                    <option value="พื้นฐาน">พื้นฐาน</option>
                                    <option value="เพิ่มเติม">เพิ่มเติม</option>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือประเภท</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="up_seplan_usersend">ครูผู้สอน</label>
                                <select class="form-control" id="up_seplan_usersend" name="up_seplan_usersend" required>
                                    <option value="">เลือกครูผู้สอน</option>
                                    <?php foreach ($pers as $v_pers): ?>
                                    <option value="<?= esc($v_pers->pers_id) ?>">
                                        <?= esc($v_pers->pers_prefix . $v_pers->pers_firstname . ' ' . $v_pers->pers_lastname) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">กรุณาครูผู้สอน</div>
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">แก้ไข</button>
            </div>
            </form>
        </div>
    </div>
</div>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">แก้ไข</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Handle insert form submission
    $('#form_insert_plan').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '<?= site_url('curriculum/insert-plan') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.msg === 'OK') {
                    Swal.fire('สำเร็จ', 'บันทึกข้อมูลสำเร็จ', 'success').then(() => {
                        location.reload();
                    });
                } else if (response.msg === 2) {
                    Swal.fire('ผิดพลาด', 'รหัสวิชานี้ถูกลงทะเบียนแล้ว', 'error');
                } else {
                    Swal.fire('ผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้', 'error');
                }
            },
            error: function() {
                Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการส่งข้อมูล', 'error');
            }
        });
    });

    // Handle edit modal data population
    $('.EditTeach').on('click', function() {
        var planCode = $(this).attr('PlanCode');
        var planYear = $(this).attr('PlanYear');
        var planTerm = $(this).attr('PlanTerm');

        $.ajax({
            url: '<?= site_url('curriculum/setting-teacher-edit') ?>',
            type: 'POST',
            data: { PlanCode: planCode, PlanYear: planYear, PlanTerm: planTerm },
            dataType: 'json',
            success: function(response) {
                if (response && response[0]) {
                    var data = response[0];
                    $('#up_seplan_year').val(data.seplan_year);
                    $('#up_seplan_term').val(data.seplan_term);
                    $('#up_seplan_coursecode').val(data.seplan_coursecode);
                    $('#up_seplan_namesubject').val(data.seplan_namesubject);
                    $('#up_seplan_gradelevel').val(data.seplan_gradelevel);
                    $('#up_seplan_typesubject').val(data.seplan_typesubject);
                    $('#up_seplan_usersend').val(data.seplan_usersend);
                }
            }
        });
    });

    // Handle update form submission
    $('#FromUpdateTeacher').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '<?= site_url('curriculum/setting-teacher-update') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response == 1) {
                    Swal.fire('สำเร็จ', 'อัปเดตข้อมูลสำเร็จ', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('ผิดพลาด', 'ไม่สามารถอัปเดตข้อมูลได้', 'error');
                }
            },
            error: function() {
                Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการส่งข้อมูล', 'error');
            }
        });
    });

    // Handle delete
    $('.DeleteTeach').on('click', function(e) {
        e.preventDefault();
        var delPlanCode = $(this).attr('delplancode');
        var delPlanYear = $(this).attr('delplanyear');
        var delPlanTerm = $(this).attr('delplanterm');
        var delPlanName = $(this).attr('delplanname');

        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('curriculum/setting-teacher-delete') ?>',
                    type: 'POST',
                    data: { PlanCode: delPlanCode, PlanYear: delPlanYear, PlanTerm: delPlanTerm, PlanName: delPlanName },
                    dataType: 'json',
                    success: function(response) {
                        if (response == 1) {
                            Swal.fire('ลบสำเร็จ!', 'ข้อมูลของคุณถูกลบแล้ว.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('ผิดพลาด!', 'ไม่สามารถลบข้อมูลได้.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการลบข้อมูล.', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
