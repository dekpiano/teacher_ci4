<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'รายงานการบันทึกเวลาเรียน') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">รายงานผลการบันทึกเวลาเรียน</h3>
                    <a href="<?= site_url('club/printActivitiesReport/' . $club->club_id) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-printer"></i> พิมพ์รายงาน
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" style="width: 100%;">
                            <thead>
                                <?php
                                    $thaiMonths = [
                                        'January' => 'มกราคม', 'February' => 'กุมภาพันธ์', 'March' => 'มีนาคม',
                                        'April' => 'เมษายน', 'May' => 'พฤษภาคม', 'June' => 'มิถุนายน',
                                        'July' => 'กรกฎาคม', 'August' => 'สิงหาคม', 'September' => 'กันยายน',
                                        'October' => 'ตุลาคม', 'November' => 'พฤศจิกายน', 'December' => 'ธันวาคม',
                                    ];
                                ?>
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">เลขที่</th>
                                    <th rowspan="2" class="align-middle" style="min-width: 200px;">ชื่อ - นามสกุล</th>
                                    <th rowspan="2" class="align-middle">ชั้น</th> <!-- Added Class column -->
                                    <?php foreach ($schedulesByMonth as $month => $schedulesInMonth): ?>
                                        <?php
                                            $englishMonthName = date('F', strtotime($month));
                                            $thaiMonthName = $thaiMonths[$englishMonthName] ?? $englishMonthName;
                                            $year = date('Y', strtotime($month));
                                        ?>
                                        <th colspan="<?= count($schedulesInMonth) ?>"><?= $thaiMonthName . ' ' . ($year + 543) ?></th>
                                    <?php endforeach; ?>
                                    <th rowspan="2" class="align-middle">รวม</th>
                                    <th rowspan="2" class="align-middle">ผลของ<br>เวลาเรียน<br>ผ/มผ</th>
                                </tr>
                                <tr class="text-center">
                                    <?php foreach ($schedulesByMonth as $month => $schedulesInMonth): ?>
                                        <?php foreach ($schedulesInMonth as $schedule): ?>
                                            <th style="min-width: 50px;"><?= date('d', strtotime($schedule->tcs_start_date)) ?></th>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Calculate the total number of schedules that are actually being displayed in the table
                                    $totalDisplayedSchedules = 0;
                                    if (!empty($schedulesByMonth)) {
                                        foreach ($schedulesByMonth as $schedulesInMonth) {
                                            $totalDisplayedSchedules += count($schedulesInMonth);
                                        }
                                    }
                                ?>
                                <?php if (!empty($members)): ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($members as $member): ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td><?= esc($member->StudentPrefix . $member->StudentFirstName . ' ' . $member->StudentLastName) ?></td>
                                            <td class="text-center"><?= esc($member->StudentClass) ?></td> <!-- Added Class data -->
                                            <?php 
                                                $totalPresent = 0;
                                                foreach ($schedulesByMonth as $month => $schedulesInMonth):
                                                    foreach ($schedulesInMonth as $schedule):
                                                        $status = $attendanceMap[$member->StudentID][$schedule->tcs_schedule_id] ?? '-';
                                                        if ($status === 'มา') {
                                                            $totalPresent++;
                                                        }
                                            ?>
                                                <td class="text-center">
                                                    <?php if ($status === 'มา'): ?>
                                                        <i class="bi bi-check-lg text-success"></i>
                                                    <?php else: ?>
                                                        <i class="bi bi-x-lg text-danger"></i>
                                                    <?php endif; ?>
                                                </td>
                                            <?php 
                                                    endforeach;
                                                endforeach; 
                                            ?>
                                            <td class="text-center"><?= $totalPresent ?></td>
                                            <td class="text-center">
                                                <?php
                                                    if ($totalDisplayedSchedules > 0) {
                                                        $percentage = ($totalPresent / $totalDisplayedSchedules) * 100;
                                                        $result = ($percentage >= 80) ? 'ผ' : 'มผ';
                                                        $resultClass = ($percentage >= 80) ? 'text-success' : 'text-danger';
                                                        echo "<strong class='{$resultClass}'>{$result}</strong>";
                                                    } else {
                                                        // If there are no schedules, there's nothing to pass/fail
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?= 3 + ($totalDisplayedSchedules ?? 0) + 2 ?>" class="text-center">ไม่พบสมาชิกในชุมนุมนี้</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Objectives Report Card -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">รายงานผลการประเมินตามจุดประสงค์</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($club_objectives)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">เลขที่</th>
                                    <th rowspan="2" class="align-middle" style="min-width: 200px;">ชื่อ - นามสกุล</th>
                                    <th colspan="<?= count($club_objectives) ?>">จุดประสงค์ที่</th>
                                    <th rowspan="2" class="align-middle">รวมที่ผ่าน</th>
                                    <th rowspan="2" class="align-middle">ผล (ผ/มผ)</th>
                                </tr>
                                <tr class="text-center">
                                    <?php foreach ($club_objectives as $objective): ?>
                                        <th><?= esc($objective->objective_order) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($members)): ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($members as $member): ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td><?= esc($member->StudentPrefix . $member->StudentFirstName . ' ' . $member->StudentLastName) ?></td>
                                            <?php
                                                $totalPassed = 0;
                                                foreach ($club_objectives as $objective):
                                                    $hasPassed = $objectiveProgressMap[$member->StudentID][$objective->objective_id] ?? false;
                                                    if ($hasPassed) {
                                                        $totalPassed++;
                                                    }
                                            ?>
                                                <td class="text-center">
                                                    <?php if ($hasPassed): ?>
                                                        <i class="bi bi-check-lg text-success"></i>
                                                    <?php else: ?>
                                                        <i class="bi bi-x-lg text-danger"></i>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td class="text-center"><?= $totalPassed ?></td>
                                            <td class="text-center">
                                                <?php
                                                    $totalObjectivesCount = count($club_objectives);
                                                    if ($totalObjectivesCount > 0) {
                                                        $result = ($totalPassed === $totalObjectivesCount) ? 'ผ' : 'มผ';
                                                        $resultClass = ($totalPassed === $totalObjectivesCount) ? 'text-success' : 'text-danger';
                                                        echo "<strong class='{$resultClass}'>{$result}</strong>";
                                                    } else {
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?= 4 + count($club_objectives) ?>" class="text-center">ไม่พบสมาชิกในชุมนุมนี้</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">ยังไม่มีการกำหนดจุดประสงค์สำหรับชุมนุมนี้</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>