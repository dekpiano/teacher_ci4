<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DesirableAssessmentModel;

class DesirableAssessmentController extends BaseController
{
    private $teacherId;

    public function __construct()
    {
        $this->teacherId = session('person_id');
        if (empty($this->teacherId)) {
            echo '<script>window.location.href = "' . base_url('login') . '";</script>';
            exit();
        }
    }

    public function index()
    {
        $model = new DesirableAssessmentModel();
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
            'title' => 'ประเมินคุณลักษณะอันพึงประสงค์'
        ];

        return view('teacher/desirable_assessment/index', $data);
    }

    public function assessClass($class, $room)
    {
        $className = $class . '/' . $room;
        $model = new DesirableAssessmentModel();
        $latestYearTerm = $model->getLatestSchoolYear();
        $academicYear = $latestYearTerm['year'];
        $term = $latestYearTerm['term'];

        $students = $model->getStudentsByHomeroomClass($className, $academicYear);
        $assessmentItems = $model->getAssessmentItems(); // This is now hierarchical
        $studentIds = array_column($students, 'StudentID');
        $evaluations = $model->getEvaluationsForClass($studentIds, $academicYear, $term);

        // --- New Report Data Processing ---

        $getQualityLevel = function($score, $isAverage = true) {
            if ($isAverage) {
                if ($score >= 2.51) return 'ดีเยี่ยม';
                if ($score >= 1.51) return 'ดี';
                if ($score >= 1.00) return 'ผ่าน';
            } else {
                if ($score == 3) return 'ดีเยี่ยม';
                if ($score == 2) return 'ดี';
                if ($score == 1) return 'ผ่าน';
            }
            return 'ไม่ผ่าน';
        };

        $getLevelAsNumber = function($levelText) {
            switch ($levelText) {
                case 'ดีเยี่ยม': return 3;
                case 'ดี': return 2;
                case 'ผ่าน': return 1;
                default: return 0;
            }
        };

        $report = [];
        $allSubItems = [];

        // Initialize report structure and get a flat list of all sub-items
        foreach ($assessmentItems as $mainItem) {
            $report[$mainItem['item_id']] = [
                'name' => $mainItem['item_name'],
                'sub_items' => [],
                'summary' => ['ดีเยี่ยม' => 0, 'ดี' => 0, 'ผ่าน' => 0, 'ไม่ผ่าน' => 0]
            ];
            foreach ($mainItem['sub_items'] as $subItem) {
                $allSubItems[] = $subItem;
                $report[$mainItem['item_id']]['sub_items'][$subItem['item_id']] = [
                    'name' => $subItem['item_name'],
                    'summary' => ['ดีเยี่ยม' => 0, 'ดี' => 0, 'ผ่าน' => 0, 'ไม่ผ่าน' => 0]
                ];
            }
        }

        $studentResults = [];
        $overallSummary = ['ดีเยี่ยม' => 0, 'ดี' => 0, 'ผ่าน' => 0, 'ไม่ผ่าน' => 0];
        $totalAssessedStudents = 0;

        foreach ($students as $student) {
            $studentId = $student['StudentID'];
            if (!isset($evaluations[$studentId])) continue;

            $totalAssessedStudents++;
            $studentTotalScore = 0;
            $studentTotalSubItems = count($allSubItems);
            $studentResults[$studentId] = ['main_item_levels' => []];

            // Calculate score and level for each main item group
            foreach ($assessmentItems as $mainItem) {
                $mainItemScore = 0;
                $mainItemSubItemsCount = count($mainItem['sub_items']);
                if ($mainItemSubItemsCount == 0) continue;

                foreach ($mainItem['sub_items'] as $subItem) {
                    $score = $evaluations[$studentId][$subItem['item_id']] ?? 0;
                    $mainItemScore += (int)$score;

                    // Tally summary for each sub-item
                    $subItemLevel = $getQualityLevel($score, false);
                    $report[$mainItem['item_id']]['sub_items'][$subItem['item_id']]['summary'][$subItemLevel]++;
                }

                $mainItemAverage = $mainItemScore / $mainItemSubItemsCount;
                $mainItemLevel = $getQualityLevel($mainItemAverage, true);
                $studentResults[$studentId]['main_item_levels'][$mainItem['item_id']] = $mainItemLevel;
                $studentResults[$studentId]['main_item_numeric_levels'][$mainItem['item_id']] = $getLevelAsNumber($mainItemLevel);
                $studentTotalScore += $mainItemScore;

                // Tally summary for each main item
                $report[$mainItem['item_id']]['summary'][$mainItemLevel]++;
            }

            // Calculate overall level for the student
            if($studentTotalSubItems > 0){
                $studentOverallAverage = $studentTotalScore / $studentTotalSubItems;
                $studentOverallLevel = $getQualityLevel($studentOverallAverage, true);
                $studentResults[$studentId]['overall_level'] = $studentOverallLevel;

                // Tally overall summary
                $overallSummary[$studentOverallLevel]++;
            }
            
        }

        $data = [
            'className' => $className,
            'academicYear' => $academicYear,
            'term' => $term,
            'students' => $students,
            'assessmentItems' => $assessmentItems, // Hierarchical items
            'evaluations' => $evaluations,
            'report' => $report, // Hierarchical report data
            'studentResults' => $studentResults, // Per-student results
            'overallSummary' => $overallSummary,
            'totalStudents' => count($students),
            'totalAssessedStudents' => $totalAssessedStudents,
            'title' => 'ประเมินคุณลักษณะฯ - ห้อง ' . $className
        ];

        return view('teacher/desirable_assessment/assess_class', $data);
    }

    public function saveClassEvaluation()
    {
        $model = new DesirableAssessmentModel();
        $className = $this->request->getPost('className');
        $scores = $this->request->getPost('scores');
        
        $latestYearTerm = $model->getLatestSchoolYear();

        $data = [
            'scores' => $scores,
            'term' => $latestYearTerm['term'],
            'academicYear' => $latestYearTerm['year'],
            'evaluatorId' => $this->teacherId
        ];

        if ($model->saveEvaluation($data)) {
            return redirect()->to(base_url('teacher/desirable_assessment/assess/' . $className))->with('message', 'บันทึกข้อมูลสำเร็จ');
        } else {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        }
    }

    public function printReport($class, $room)
    {
        $className = $class . '/' . $room;
        $model = new DesirableAssessmentModel();
        $latestYearTerm = $model->getLatestSchoolYear();
        $academicYear = $latestYearTerm['year'];
        $term = $latestYearTerm['term'];

        // --- Get Signatory Names ---
        $homeroomTeachersData = $model->getHomeroomTeachersByClassAndYear($class . '/' . $room, $academicYear);
        $homeroom_teachers = [];
        foreach ($homeroomTeachersData as $teacherData) {
            $persId = $teacherData['class_teacher'];
            $teacherInfo = $model->getPersonnelFullName($persId);
            if ($teacherInfo) {
                $homeroom_teachers[] = $teacherInfo['pers_prefix'] . $teacherInfo['pers_firstname'] . ' ' . $teacherInfo['pers_lastname'];
            }
        }

        // Fallback if no homeroom teachers found in tb_regclass
        if (empty($homeroom_teachers)) {
            $homeroom_teacher_info = $model->getPersonnelFullName($this->teacherId);
            if ($homeroom_teacher_info) {
                $homeroom_teachers[] = $homeroom_teacher_info['pers_prefix'] . $homeroom_teacher_info['pers_firstname'] . ' ' . $homeroom_teacher_info['pers_lastname'];
            } else {
                $homeroom_teachers[] = '...........................................';
            }
        }

        $gradeLevelHeadId = $model->getGradeLevelHead($class, $academicYear);
        $grade_level_head_info = null;
        if ($gradeLevelHeadId) {
            $grade_level_head_info = $model->getPersonnelFullName($gradeLevelHeadId);
        }
        $grade_level_head = ($grade_level_head_info) ? $grade_level_head_info['pers_prefix'] . $grade_level_head_info['pers_firstname'] . ' ' . $grade_level_head_info['pers_lastname'] : '...........................................';

        $academicHeadId = $model->getAdminPersonnelIdByRoleName('หัวหน้างานวิชาการ');
        $academic_head_info = null;
        if ($academicHeadId) {
            $academic_head_info = $model->getPersonnelFullName($academicHeadId);
        }
        $academic_head = ($academic_head_info) ? $academic_head_info['pers_prefix'] . $academic_head_info['pers_firstname'] . ' ' . $academic_head_info['pers_lastname'] : 'นางสาวชยารัตน์ เหงากูล'; // Fallback

        $deputyDirectorId = $model->getAdminPersonnelIdByRoleName('รองผู้อำนวยการสถานศึกษา');
        $deputy_director_info = null;
        if ($deputyDirectorId) {
            $deputy_director_info = $model->getPersonnelFullName($deputyDirectorId);
        }
        $deputy_director = ($deputy_director_info) ? $deputy_director_info['pers_prefix'] . $deputy_director_info['pers_firstname'] . ' ' . $deputy_director_info['pers_lastname'] : 'นางสาวอรอุมา ฉวีทอง'; // Fallback

        $directorId = $model->getAdminPersonnelIdByRoleName('ผู้อำนวยการสถานศึกษา');
        $director_info = null;
        if ($directorId) {
            $director_info = $model->getPersonnelFullName($directorId);
        }
        $director = ($director_info) ? $director_info['pers_prefix'] . $director_info['pers_firstname'] . ' ' . $director_info['pers_lastname'] : 'นายพงษ์ศักดิ์ เงินสันเทียะ'; // Fallback

        // --- Get Report Data (Copied and adapted from assessClass) ---
        $students = $model->getStudentsByHomeroomClass($className, $academicYear);
        $assessmentItems = $model->getAssessmentItems();
        $studentIds = array_column($students, 'StudentID');
        $evaluations = $model->getEvaluationsForClass($studentIds, $academicYear, $term);

        $getQualityLevel = function($score, $isAverage = true) {
            if ($isAverage) {
                if ($score >= 2.51) return 'ดีเยี่ยม';
                if ($score >= 1.51) return 'ดี';
                if ($score >= 1.00) return 'ผ่าน';
            } else {
                if ($score == 3) return 'ดีเยี่ยม';
                if ($score == 2) return 'ดี';
                if ($score == 1) return 'ผ่าน';
            }
            return 'ไม่ผ่าน';
        };

        $getLevelAsNumber = function($levelText) {
            switch ($levelText) {
                case 'ดีเยี่ยม': return 3;
                case 'ดี': return 2;
                case 'ผ่าน': return 1;
                default: return 0;
            }
        };

        $report = [];
        $allSubItems = [];
        foreach ($assessmentItems as $mainItem) {
            $report[$mainItem['item_id']] = [
                'name' => $mainItem['item_name'],
                'summary' => ['ดีเยี่ยม' => 0, 'ดี' => 0, 'ผ่าน' => 0, 'ไม่ผ่าน' => 0]
            ];
            foreach ($mainItem['sub_items'] as $subItem) {
                $allSubItems[] = $subItem;
            }
        }

        $overallSummary = ['ดีเยี่ยม' => 0, 'ดี' => 0, 'ผ่าน' => 0, 'ไม่ผ่าน' => 0];
        $totalAssessedStudents = 0;
        $studentResults = []; // Initialize the missing variable

        foreach ($students as $student) {
            $studentId = $student['StudentID'];
            if (!isset($evaluations[$studentId])) continue;

            $totalAssessedStudents++;
            $studentTotalScore = 0;
            $studentTotalSubItems = count($allSubItems);
            $studentResults[$studentId] = ['main_item_levels' => []]; // Initialize for student

            foreach ($assessmentItems as $mainItem) {
                $mainItemScore = 0;
                $mainItemSubItemsCount = count($mainItem['sub_items']);
                if ($mainItemSubItemsCount == 0) continue;

                foreach ($mainItem['sub_items'] as $subItem) {
                    $score = $evaluations[$studentId][$subItem['item_id']] ?? 0;
                    $mainItemScore += (int)$score;
                }

                $mainItemAverage = $mainItemScore / $mainItemSubItemsCount;
                $mainItemLevel = $getQualityLevel($mainItemAverage, true);
                $report[$mainItem['item_id']]['summary'][$mainItemLevel]++;
                $studentResults[$studentId]['main_item_levels'][$mainItem['item_id']] = $mainItemLevel; // Populate main item level
                $studentResults[$studentId]['main_item_numeric_levels'][$mainItem['item_id']] = $getLevelAsNumber($mainItemLevel);
                $studentTotalScore += $mainItemScore;
            }

            if($studentTotalSubItems > 0){
                $studentOverallAverage = $studentTotalScore / $studentTotalSubItems;
                $studentOverallLevel = $getQualityLevel($studentOverallAverage, true);
                $overallSummary[$studentOverallLevel]++;
                $studentResults[$studentId]['overall_level'] = $studentOverallLevel; // Populate overall level
            }
        }

        $data = [
            'className' => $className,
            'academicYear' => $academicYear,
            'term' => $term,
            'totalStudents' => count($students),
            'totalAssessedStudents' => $totalAssessedStudents,
            'report' => $report,
            'overallSummary' => $overallSummary,
            'students' => $students,
            'assessmentItems' => $assessmentItems,
            'evaluations' => $evaluations,
            'studentResults' => $studentResults, // Pass detailed results for page 2
            'homeroom_teachers' => $homeroom_teachers,
            'grade_level_head' => $grade_level_head,
            'academic_head' => $academic_head,
            'deputy_director' => $deputy_director,
            'director' => $director
        ];

        return view('teacher/desirable_assessment/print_report', $data);
    }
}
