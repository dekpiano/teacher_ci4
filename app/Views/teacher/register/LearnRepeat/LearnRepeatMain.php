<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
บันทึกผลการเรียน (ซ้ำ)
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="bi bi-pencil-square"></i> บันทึกผลการเรียน (ซ้ำ)</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?=base_url('home');?>"><i class="bi bi-house-door"></i> หน้าแรก</a></li>
                        <li class="breadcrumb-item active" aria-current="page">บันทึกผลการเรียน (ซ้ำ)</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <style>
            .services .card1 {
                padding: 10px;
                border: none;
                cursor: pointer;
                border: groove;
            }

            .services .card1:hover {
                background-color: #fff;
            }

            .services .card1 span {
                font-size: 14px;
            }

            .g-1 {
                padding: 10px 15px;
                margin: 0;
            }
            </style>
            <div class="col-lg-12">
                <?php if($onoff[0]->onoff_status == 'off'): ?>
                <div class="alert alert-danger" role="alert">
                    ทางวิชาการขอ ปรับปรุง หรือ อัพเดตข้อมูลสักครู่... กรุณารอ ^/\^ !
                </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><i class="bi bi-book"></i> รายวิชาที่สอน</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ปีการศึกษา</th>
                                        <th>ชั้นที่สอน</th>
                                        <th>วิชา</th>
                                        <th>หน่วยกิจ</th>
                                        <th>ชั่วโมง</th>
                                        <th>บันทึกผลการเรียน</th>
                                        <th>รายงาน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($check_subject as $key => $v_check_subject) : ?>
                                    <tr>
                                        <th><?= $v_check_subject->RegisterYear ?></th>
                                        <td><?= $v_check_subject->RegisterClass ?></td>
                                        <td><?= $v_check_subject->SubjectCode ?> <?= $v_check_subject->SubjectName ?></td>
                                        <td><?= $v_check_subject->SubjectUnit ?></td>
                                        <td><?= $v_check_subject->SubjectHour ?></td>
                                        <td>
                                            <?php if($onoff[0]->onoff_status == 'off'): ?>
                                            <a href="#" data-toggle="modal"
                                                data-target="#AlertNoReg"
                                                class="btn btn-danger btn-sm"><i class="bi bi-ban"
                                                    aria-hidden="true"></i> ยังไม่เปิดให้บันทึก</a>
                                            <?php else: ?>
                                            <a href="<?= base_url('assessment/save-score-repeat-add/'.$v_check_subject->RegisterYear.'/'.$v_check_subject->SubjectID.'/all') ?>"
                                                class="btn btn-primary btn-sm clickLoad"><i class="bi bi-pencil-square"
                                                    aria-hidden="true"></i> บันทึกผลการเรียน</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="#" id="chcek_report" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#Modalprint"
                                                report-yaer="<?= $v_check_subject->RegisterYear ?>"
                                                report-subject="<?= $v_check_subject->SubjectID ?>"><i class="bi bi-printer"
                                                    aria-hidden="true"></i> พิมพ์รายงาน</a>
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
    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="Modalprint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-printer"></i> พิมพ์รายงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('assessment/report-learn-repeat'); ?>" method="post" target="_blank">
                <div class="modal-body">
                    <select name="select_print" id="select_print" class="form-control mb-3">
                        <option value="all">ทั้งหมด</option>
                    </select>

                    <input type="text" name="report_RegisterYear" id="report_RegisterYear" style="display:none">
                    <input type="text" name="report_SubjectID" id="report_SubjectID" style="display:none">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-printer"></i> พิมพ์</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="AlertNoReg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-exclamation-triangle"></i> บันทึกผลการเรียน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                ขณะนี้! ระบบยังไม่เปิดให้ลงผลการเรียน รอสักครู่... <br>
                ทางฝ่ายวิชาการจะแจ้งให้ทราบอีกครั้ง
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Workaround for data-dismiss="modal" not working
        $(document).on('click', '[data-dismiss="modal"]', function(e) {
            e.preventDefault();
            $(this).closest('.modal').modal('hide');
        });
        $(document).on('click', '#chcek_report', function(e) {
            e.preventDefault();

            var year = $(this).attr('report-yaer');
            var subject = $(this).attr('report-subject');

            // Set values for the form inside the modal
            $("#report_RegisterYear").val(year);
            $("#report_SubjectID").val(subject);

            // AJAX call to get classrooms
            $.ajax({
                url: "<?= site_url('assessment/save-score-repeat/checkroom-report') ?>",
                type: 'POST',
                data: {
                    report_yaer: year,
                    report_subject: subject
                },
                dataType: 'json',
                success: function(data) {
                    // Clear and populate the select dropdown
                    var selectPrint = $('#select_print');
                    selectPrint.empty();
                    selectPrint.append('<option value="all">ทั้งหมด</option>');
                    $.each(data, function(key, val) {
                        selectPrint.append('<option value="' + val.StudentClass + '">' + val.StudentClass + '</option>');
                    });

                    // Show the modal
                    $('#Modalprint').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถดึงข้อมูลห้องเรียนได้: ' + textStatus
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>