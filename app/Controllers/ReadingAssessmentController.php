<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ReadingAssessmentController extends BaseController
{
    private $teacherId;

    public function __construct()
    {
        $this->teacherId = session('person_id');
        if (empty($this->teacherId)) {
            // Using echo and exit because redirect() doesn't work in constructor in CI4
            echo '<script>window.location.href = "' . base_url('login') . '";</script>';
            exit();
        }
    }

    public function index()
    {
        $model = new \App\Models\ReadingAssessmentModel();
        $latestYearTerm = $model->getLatestSchoolYear();
        $academicYear = $latestYearTerm['year'];
        $term = $latestYearTerm['term'];

        $teacherClasses = $model->getTeacherClasses($this->teacherId, $academicYear);

        // Add status to each class
        foreach ($teacherClasses as &$class) { // Use reference to modify array directly
            $status = $model->getAssessmentStatusForClass($class['Reg_Class'], $academicYear, $term);
            $class['status'] = $status;
        }

        $data = [
            'teacherClasses' => $teacherClasses,
            'academicYear' => $academicYear,
            'title' => 'แบบประเมินการอ่าน คิดวิเคราะห์ และเขียน'
        ];

        return view('teacher/reading_assessment/index', $data);
    }

    public function assessClass($class, $room)
    {
        $className = $class . '/' . $room;
        $model = new \App\Models\ReadingAssessmentModel();
        $academicYear = '2568'; // Hardcoded for now
        $term = '1'; // Hardcoded for now

        $students = $model->getStudentsByHomeroomClass($className, $academicYear);
        $assessmentItems = $model->getAssessmentItems();
        $studentIds = array_column($students, 'StudentID');
        $evaluations = $model->getEvaluationsForClass($studentIds, $academicYear, $term);

        // --- Start Report Data Processing ---
        $reportData = [];
        $qualityLevels = ['ดีเยี่ยม' => 0, 'ดี' => 0, 'ผ่าน' => 0, 'ไม่ผ่าน' => 0];
        $itemQualityCounts = [];

        foreach ($assessmentItems as $item) {
            $itemQualityCounts[$item['ItemID']] = $qualityLevels;
        }

        $totalAssessedStudents = 0;

        foreach ($students as $student) {
            $studentTotalScore = 0;
            $studentAssessedItems = 0;
            $studentScores = [];

            if (isset($evaluations[$student['StudentID']])) {
                $totalAssessedStudents++;
                foreach ($assessmentItems as $item) {
                    $score = $evaluations[$student['StudentID']][$item['ItemID']] ?? '';
                    $studentScores[$item['ItemID']] = $score;

                    if (is_numeric($score) && $score !== '') {
                        $studentTotalScore += (int)$score;
                        $studentAssessedItems++;
                    }
                }

                if ($studentAssessedItems > 0) {
                    $averageScore = $studentTotalScore / count($assessmentItems);
                    $studentQualityLevel = 'ไม่ผ่าน';
                    if ($averageScore >= 2.51) {
                        $studentQualityLevel = 'ดีเยี่ยม';
                    } elseif ($averageScore >= 1.51) {
                        $studentQualityLevel = 'ดี';
                    } elseif ($averageScore >= 1.00) {
                        $studentQualityLevel = 'ผ่าน';
                    }
                    $qualityLevels[$studentQualityLevel]++;

                    foreach ($assessmentItems as $item) {
                        $itemScore = $studentScores[$item['ItemID']];
                        if (is_numeric($itemScore) && $itemScore !== '') {
                            $itemQuality = 'ไม่ผ่าน';
                            if ($itemScore == 3) {
                                $itemQuality = 'ดีเยี่ยม';
                            } elseif ($itemScore == 2) {
                                $itemQuality = 'ดี';
                            } elseif ($itemScore == 1) {
                                $itemQuality = 'ผ่าน';
                            }
                            $itemQualityCounts[$item['ItemID']][$itemQuality]++;
                        }
                    }
                }
            }
        }

        $overallQualityPercentages = [];
        foreach ($qualityLevels as $level => $count) {
            $overallQualityPercentages[$level] = ($totalAssessedStudents > 0) ? number_format(($count / $totalAssessedStudents) * 100, 2) : '0.00';
        }
        // --- End Report Data Processing ---

        $data = [
            'className' => $className,
            'students' => $students,
            'assessmentItems' => $assessmentItems,
            'evaluations' => $evaluations,
            'itemQualityCounts' => $itemQualityCounts,
            'overallQualityCounts' => $qualityLevels,
            'overallQualityPercentages' => $overallQualityPercentages,
            'totalStudents' => $totalAssessedStudents
        ];

        return view('teacher/reading_assessment/assess_class', $data);
    }

    public function printReport($class, $room)
    {
        $className = $class . '/' . $room;
        $model = new \App\Models\ReadingAssessmentModel();
        $academicYear = '2568'; // Hardcoded for now
        $term = '1'; // Hardcoded for now

        // --- Get Signatory Names ---
        $homeroom_teacher_info = $model->getPersonnelInfo($this->teacherId);
        $homeroom_teacher = ($homeroom_teacher_info) ? $homeroom_teacher_info['pers_prefix'] . $homeroom_teacher_info['pers_firstname'] . ' ' . $homeroom_teacher_info['pers_lastname'] : '';

        $gradeLevelHeadId = $model->getGradeLevelHead($class, $academicYear);
        $grade_level_head_info = $model->getPersonnelInfo($gradeLevelHeadId);
        $grade_level_head = ($grade_level_head_info) ? $grade_level_head_info['pers_prefix'] . $grade_level_head_info['pers_firstname'] . ' ' . $grade_level_head_info['pers_lastname'] : '...........................................';

        $academic_head_info = $model->getPersonnelInfo(null, 'หัวหน้างานวิชาการ');
        $academic_head = ($academic_head_info) ? $academic_head_info['pers_prefix'] . $academic_head_info['pers_firstname'] . ' ' . $academic_head_info['pers_lastname'] : 'นางสาวชยารัตน์ เหงากูล'; // Fallback

        $deputy_director_info = $model->getPersonnelInfo(null, 'รองผู้อำนวยการสถานศึกษา');
        $deputy_director = ($deputy_director_info) ? $deputy_director_info['pers_prefix'] . $deputy_director_info['pers_firstname'] . ' ' . $deputy_director_info['pers_lastname'] : 'นางสาวอรอุมา ฉวีทอง'; // Fallback

        $director_info = $model->getPersonnelInfo(null, 'ผู้อำนวยการสถานศึกษา');
        $director = ($director_info) ? $director_info['pers_prefix'] . $director_info['pers_firstname'] . ' ' . $director_info['pers_lastname'] : 'นายพงษ์ศักดิ์ เงินสันเทียะ'; // Fallback

        // --- Get Report Data ---
        $students = $model->getStudentsByHomeroomClass($className, $academicYear);
        $assessmentItems = $model->getAssessmentItems();
        $studentIds = array_column($students, 'StudentID');
        $evaluations = $model->getEvaluationsForClass($studentIds, $academicYear, $term);

        $qualityLevels = ['ดีเยี่ยม' => 0, 'ดี' => 0, 'ผ่าน' => 0, 'ไม่ผ่าน' => 0];
        $itemQualityCounts = [];
        foreach ($assessmentItems as $item) {
            $itemQualityCounts[$item['ItemID']] = $qualityLevels;
        }

        $totalAssessedStudents = 0;
        if(!empty($evaluations)){
            $totalAssessedStudents = count(array_keys($evaluations));
        }

        foreach ($evaluations as $studentId => $studentScores) {
            $studentTotalScore = array_sum($studentScores);
            $averageScore = $studentTotalScore / count($assessmentItems);

            $studentQualityLevel = 'ไม่ผ่าน';
            if ($averageScore >= 2.51) {
                $studentQualityLevel = 'ดีเยี่ยม';
            } elseif ($averageScore >= 1.51) {
                $studentQualityLevel = 'ดี';
            } elseif ($averageScore >= 1.00) {
                $studentQualityLevel = 'ผ่าน';
            }
            $qualityLevels[$studentQualityLevel]++;

            foreach ($studentScores as $itemId => $score) {
                $itemQuality = 'ไม่ผ่าน';
                if ($score == 3) {
                    $itemQuality = 'ดีเยี่ยม';
                } elseif ($score == 2) {
                    $itemQuality = 'ดี';
                } elseif ($score == 1) {
                    $itemQuality = 'ผ่าน';
                }
                if (isset($itemQualityCounts[$itemId])) {
                    $itemQualityCounts[$itemId][$itemQuality]++;
                }
            }
        }

        $overallQualityPercentages = [];
        foreach ($qualityLevels as $level => $count) {
            $overallQualityPercentages[$level] = ($totalAssessedStudents > 0) ? number_format(($count / $totalAssessedStudents) * 100, 2) : '0.00';
        }

        $data = [
            'className' => $className,
            'academicYear' => $academicYear,
            'students' => $students,
            'assessmentItems' => $assessmentItems,
            'evaluations' => $evaluations,
            'itemQualityCounts' => $itemQualityCounts,
            'overallQualityCounts' => $qualityLevels,
            'overallQualityPercentages' => $overallQualityPercentages,
            'totalStudents' => $totalAssessedStudents,
            'homeroom_teacher' => $homeroom_teacher,
            'grade_level_head' => $grade_level_head,
            'academic_head' => $academic_head,
            'deputy_director' => $deputy_director,
            'director' => $director
        ];

        return view('teacher/reading_assessment/print_report', $data);
    }

    public function saveClassEvaluation()
    {
        $model = new \App\Models\ReadingAssessmentModel();
        $className = $this->request->getPost('className');
        $scores = $this->request->getPost('scores');

        $data = [
            'scores' => $scores,
            'term' => '1', // Hardcoded for now
            'academicYear' => '2568', // Hardcoded for now
            'evaluatorId' => $this->teacherId
        ];

        if ($model->saveEvaluation($data)) {
            return redirect()->to(base_url('teacher/reading_assessment/assess/' . $className))->with('message', 'บันทึกข้อมูลสำเร็จ');
        } else {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        }
    }
}
