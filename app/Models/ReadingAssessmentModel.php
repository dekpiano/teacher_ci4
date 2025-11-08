<?php

namespace App\Models;

use CodeIgniter\Model;

class ReadingAssessmentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_evalu_raw_detail';
    protected $primaryKey       = 'EvaluationID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['StudentID', 'ItemID', 'Score', 'Term', 'AcademicYear', 'EvaluatorID', 'DateEvaluated'];

    public function getTeacherClasses(string $teacherId, string $academicYear)
    {
        $db = db_connect(); // tb_regclass is in default database
        return $db->table('tb_regclass')
                        ->select('Reg_Class')
                        ->where('class_teacher', $teacherId)
                        ->where('Reg_Year', $academicYear)
                        ->distinct()
                        ->get()
                        ->getResultArray();
    }

    public function getStudentsByHomeroomClass(string $className, string $academicYear)
    {
        $db = db_connect();
        return $db->table('tb_students')
            ->where('StudentClass', 'ม.'.$className)
            ->where('StudentStatus', '1/ปกติ')
            ->orderBy('StudentNumber', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getAssessmentItems()
    {
        return $this->db->table('tb_evalu_raw_item')
                        ->orderBy('ItemID', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    public function getStudentDetails(string $studentId)
    {
        $db = db_connect(); // tb_students is in default database
        return $db->table('tb_students')
                        ->where('StudentID', $studentId)
                        ->get()
                        ->getRowArray();
    }

    public function saveEvaluation(array $data)
    {
        $studentIds = array_keys($data['scores']);

        if (empty($studentIds)) {
            return true;
        }

        $this->db->transStart();

        // Delete old records for the students being updated
        $this->db->table('tb_evalu_raw_detail')
           ->whereIn('StudentID', $studentIds)
           ->where('AcademicYear', $data['academicYear'])
           ->where('Term', $data['term'])
           ->delete();

        // Insert new records
        foreach ($data['scores'] as $studentId => $items) {
            foreach ($items as $itemId => $score) {
                // Only insert if a score was actually entered
                if (is_numeric($score) && $score !== '') {
                    $this->db->table('tb_evalu_raw_detail')->insert([
                        'StudentID' => $studentId,
                        'ItemID' => $itemId,
                        'Score' => $score,
                        'Term' => $data['term'],
                        'AcademicYear' => $data['academicYear'],
                        'EvaluatorID' => $data['evaluatorId'],
                        'DateEvaluated' => date('Y-m-d')
                    ]);
                }
            }
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    public function getEvaluationsForClass(array $studentIds, string $academicYear, string $term)
    {
        if (empty($studentIds)) {
            return [];
        }

        $query = $this->db->table('tb_evalu_raw_detail')
                      ->whereIn('StudentID', $studentIds)
                      ->where('AcademicYear', $academicYear)
                      ->where('Term', $term)
                      ->get()
                      ->getResultArray();

        $evaluations = [];
        foreach ($query as $row) {
            $evaluations[$row['StudentID']][$row['ItemID']] = $row['Score'];
        }

        return $evaluations;
    }

    public function getGradeLevelHead(string $grade, string $academicYear)
    {
        $db = db_connect();
        $result = $db->table('tb_regclass')
                       ->where('Reg_Year', $academicYear)
                       ->where('Reg_Class', $grade)
                       ->get()
                       ->getRowArray();
        return $result ? $result['class_teacher'] : null;
    }

    public function getPersonnelInfo(string $personnelId = null, string $position = null)
    {
        $db = db_connect('personnel'); // Connect to the personnel database
        $builder = $db->table('tb_personnel');

        if ($personnelId) {
            $builder->where('pers_id', $personnelId);
        } elseif ($position) {
            $builder->where('pers_position', $position);
        }

        return $builder->get()->getRowArray();
    }

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /*
    This model will be used to interact with the following tables:
    - tb_evalu_raw_item
    - tb_evalu_raw_detail
    - t_final_result
    - t_class
    - tb_students (for student info)
    - tb_personnel (for teacher info)
    */
}