<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'ประเมินและดูรายงาน') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    /* Hide spinner arrows on number inputs */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card" id="report-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar"></i> รายงานสรุปผลการประเมิน</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('teacher/reading_assessment/print_report/' . $className) ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> พิมพ์รายงาน</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($assessmentItems)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2" class="align-middle">ตัวชี้วัด</th>
                                        <th colspan="4">ระดับคุณภาพ (จำนวนนักเรียน)</th>
                                        <th rowspan="2" class="align-middle">รวม</th>
                                    </tr>
                                    <tr>
                                        <th>ดีเยี่ยม (3)</th>
                                        <th>ดี (2)</th>
                                        <th>ผ่าน (1)</th>
                                        <th>ไม่ผ่าน (0)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($assessmentItems as $key => $item) : ?>
                                        <tr>
                                            <td><?=$key+1?>.<?= esc($item['ItemName']) ?></td>
                                            <td class="text-center"><?= esc($itemQualityCounts[$item['ItemID']]['ดีเยี่ยม']) ?></td>
                                            <td class="text-center"><?= esc($itemQualityCounts[$item['ItemID']]['ดี']) ?></td>
                                            <td class="text-center"><?= esc($itemQualityCounts[$item['ItemID']]['ผ่าน']) ?></td>
                                            <td class="text-center"><?= esc($itemQualityCounts[$item['ItemID']]['ไม่ผ่าน']) ?></td>
                                            <td class="text-center"><?= array_sum($itemQualityCounts[$item['ItemID']]) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="fw-bold table-secondary">
                                        <td class="text-end">สรุปผลการประเมินภาพรวม</td>
                                        <td class="text-center"><?= esc($overallQualityCounts['ดีเยี่ยม']) ?></td>
                                        <td class="text-center"><?= esc($overallQualityCounts['ดี']) ?></td>
                                        <td class="text-center"><?= esc($overallQualityCounts['ผ่าน']) ?></td>
                                        <td class="text-center"><?= esc($overallQualityCounts['ไม่ผ่าน']) ?></td>
                                        <td class="text-center"><?= esc($totalStudents) ?></td>
                                    </tr>
                                    <tr class="fw-bold table-secondary">
                                        <td class="text-end">คิดเป็นร้อยละ</td>
                                        <td class="text-center"><?= esc($overallQualityPercentages['ดีเยี่ยม']) ?>%</td>
                                        <td class="text-center"><?= esc($overallQualityPercentages['ดี']) ?>%</td>
                                        <td class="text-center"><?= esc($overallQualityPercentages['ผ่าน']) ?>%</td>
                                        <td class="text-center"><?= esc($overallQualityPercentages['ไม่ผ่าน']) ?>%</td>
                                        <td class="text-center">100.00%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning"><i class="fas fa-info-circle"></i> ไม่พบข้อมูลตัวชี้วัดการประเมิน</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <form action="<?= base_url('teacher/reading_assessment/save_class') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="className" value="<?= esc($className) ?>">
        <div class="row mt-4" id="assessment-card">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> ประเมินการอ่าน คิดวิเคราะห์ และเขียน - ชั้นเรียน <?= esc($className) ?></h3>
                        <div class="card-tools">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> บันทึกข้อมูล</button>
                            <a href="<?= base_url('teacher/reading_assessment') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> กลับไปหน้ารวม</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($students)) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle">เลขที่</th>
                                            <th rowspan="2" class="align-middle">ชื่อ - นามสกุล</th>
                                            <th colspan="<?= count($assessmentItems) ?>">ระดับคะแนน (0-3)</th>
                                            <th rowspan="2" class="align-middle">คะแนนรวม</th>
                                            <th rowspan="2" class="align-middle">ระดับคะแนน</th>
                                            <th rowspan="2" class="align-middle">ระดับคุณภาพ</th>
                                        </tr>
                                        <tr>
                                            <?php foreach ($assessmentItems as $item) : ?>
                                                <th style="width: 120px;">
                                                    ตัวชี้วัดที่ <?= esc($item['ItemID']) ?>
                                                    <br>
                                                    <div class="btn-group">
                                                        <button style="padding: 0px 6px;" type="button" class="btn btn-xs btn-secondary dropdown-toggle dropdown-icon" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item fill-col" href="#" data-item-id="<?= $item['ItemID'] ?>" data-score="3">กรอก 3 ทั้งหมด</a>
                                                            <a class="dropdown-item fill-col" href="#" data-item-id="<?= $item['ItemID'] ?>" data-score="2">กรอก 2 ทั้งหมด</a>
                                                            <a class="dropdown-item fill-col" href="#" data-item-id="<?= $item['ItemID'] ?>" data-score="1">กรอก 1 ทั้งหมด</a>
                                                            <a class="dropdown-item fill-col" href="#" data-item-id="<?= $item['ItemID'] ?>" data-score="0">กรอก 0 ทั้งหมด</a>
                                                        </div>
                                                    </div>
                                                </th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student) : ?>
                                            <tr id="student-row-<?= $student['StudentID'] ?>">
                                                <td class="text-center"><?= esc($student['StudentNumber']) ?></td>
                                                <td><?= esc($student['StudentPrefix'] . $student['StudentFirstName'] . ' ' . $student['StudentLastName']) ?></td>
                                                <?php foreach ($assessmentItems as $item) : ?>
                                                    <?php 
                                                        $score = $evaluations[$student['StudentID']][$item['ItemID']] ?? '';
                                                        $displayScore = is_numeric($score) ? (int)$score : '';
                                                    ?>
                                                    <td class="text-center item-col-<?= $item['ItemID'] ?>">
                                                        <input type="number" name="scores[<?= $student['StudentID'] ?>][<?= $item['ItemID'] ?>]" value="<?= esc($displayScore) ?>" class="form-control form-control-sm score-input text-center" min="0" max="3">
                                                    </td>
                                                <?php endforeach; ?>
                                                <td class="text-center total-score">-</td>
                                                <td class="text-center average-score">-</td>
                                                <td class="text-center quality-level">-</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-warning"><i class="fas fa-info-circle"></i> ไม่พบข้อมูลนักเรียนในชั้นเรียนนี้</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> บันทึกข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // SweetAlert2 for flash messages
    <?php if (session()->getFlashdata('message')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '<?= session()->getFlashdata('message') ?>',
            confirmButtonText: 'ตกลง'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: '<?= session()->getFlashdata('error') ?>',
            confirmButtonText: 'ตกลง'
        });
    <?php endif; ?>

    const itemCount = <?= count($assessmentItems) ?>;

    function updateRowCalculations(row) {
        let totalScore = 0;
        let assessedItems = 0;

        row.find('.score-input').each(function() {
            let score = $(this).val();
            if ($.isNumeric(score) && score !== '') {
                let scoreVal = parseFloat(score);

                if (scoreVal > 3) {
                    scoreVal = 3;
                    $(this).val(3);
                }
                if (scoreVal < 0) {
                    scoreVal = 0;
                    $(this).val(0);
                }

                totalScore += scoreVal;
                assessedItems++;
            }
        });

        let averageScoreText = '-';
        let qualityLevel = '-';
        let totalScoreText = '-';

        if (assessedItems > 0) {
            let averageScore = totalScore / itemCount; // Calculate average based on total possible items
            totalScoreText = totalScore;
            averageScoreText = averageScore.toFixed(2);

            if (averageScore >= 2.51) {
                qualityLevel = 'ดีเยี่ยม';
            } else if (averageScore >= 1.51) {
                qualityLevel = 'ดี';
            } else if (averageScore >= 1.00) {
                qualityLevel = 'ผ่าน';
            } else {
                qualityLevel = 'ไม่ผ่าน';
            }
        }

        row.find('.total-score').text(totalScoreText);
        row.find('.average-score').text(averageScoreText);
        row.find('.quality-level').text(qualityLevel);
    }

    // Add event listener for input changes
    $('tbody').on('input', '.score-input', function() {
        updateRowCalculations($(this).closest('tr'));
    });

    // Add event listener for column fill buttons
    $('.table').on('click', '.fill-col', function(e) {
        e.preventDefault();
        const itemId = $(this).data('item-id');
        const score = $(this).data('score');
        
        $('td.item-col-' + itemId).find('.score-input').each(function() {
            $(this).val(score).trigger('input');
        });
    });

    // Initial calculation for all rows on page load
    $('tbody tr').each(function() {
        updateRowCalculations($(this));
    });
});
</script>
<?= $this->endSection() ?>
