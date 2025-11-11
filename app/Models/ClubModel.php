<?php

namespace App\Models;

use CodeIgniter\Model;

class ClubModel extends Model
{
    protected $table = 'tb_clubs';
    protected $primaryKey = 'club_id';
    protected $returnType = 'object'; // Explicitly set return type to object
    protected $allowedFields = [
        'club_name',
        'club_description',
        'club_faculty_advisor',
        'club_group',
        'club_established_date',
        'club_max_participants',
        'club_status',
        'club_year',
        'club_trem'
    ];

    /**
     * Fetches all clubs advised by a specific teacher.
     *
     * @param string $teacherId The ID of the teacher.
     * @return array An array of club objects.
     */
    public function getClubsByTeacher(string $teacherId, ?string $year = null, ?string $term = null): array
    {
        $builder = $this->select('tb_clubs.*, COUNT(tcm.member_student_id) AS member_count')
                        ->join('tb_club_members tcm', 'tcm.member_club_id = tb_clubs.club_id', 'left')
                        ->groupStart()
                        ->where('club_faculty_advisor', $teacherId) // Exact match
                        ->orLike('club_faculty_advisor', $teacherId . '|', 'after') // Starts with teacherId|
                        ->orLike('club_faculty_advisor', '|' . $teacherId, 'before') // Ends with |teacherId
                        ->orLike('club_faculty_advisor', '|' . $teacherId . '|', 'both') // Contains |teacherId|
                        ->groupEnd();

        if ($year) {
            $builder->where('club_year', $year);
        }
        if ($term) {
            $builder->where('club_trem', $term);
        }
        
        $builder->groupBy('tb_clubs.club_id'); // Group by club_id to get correct counts

        return $builder->findAll();
    }

    /**
     * Fetches all student members for a given club, along with their details.
     *
     * @param int $clubId The ID of the club.
     * @return array An array of student objects.
     */
    public function getClubMembers(int $clubId): array
    {
        // First, get the student IDs and roles from the tb_club_members table.
        $member_data = $this->db->table('tb_club_members')
                                     ->select('member_student_id, member_role')
                                     ->where('member_club_id', $clubId)
                                     ->get()
                                     ->getResultArray();

        if (empty($member_data)) {
            return [];
        }

        // Extract just the student IDs into a simple array.
        $studentCodes = array_column($member_data, 'member_student_id');
        $memberRoles = array_column($member_data, 'member_role', 'member_student_id'); // Map member_student_id to member_role

        // Now, fetch the student details from the tb_students table.
        $students = $this->db->table('tb_students')
                             ->select('StudentID, StudentNumber, StudentClass, StudentCode, StudentPrefix, StudentFirstName, StudentLastName')
                             ->whereIn('StudentID', $studentCodes)
                             ->orderBy('StudentClass', 'ASC')
                             ->orderBy('StudentNumber', 'ASC')
                             ->get()
                             ->getResult();

        // Merge member_role into student objects
        foreach ($students as $student) {
            $student->member_role = $memberRoles[$student->StudentID] ?? 'Member';
        }

        return $students;
    }

    /**
     * Updates a member's role in a specific club.
     *
     * @param int $clubId The ID of the club.
     * @param string $studentId The ID of the student.
     * @param string $newRole The new role for the member (e.g., 'Leader', 'Member').
     * @return bool
     */
    public function updateMemberRole(int $clubId, string $studentId, string $newRole): bool
    {
        return $this->db->table('tb_club_members')
                        ->where('member_club_id', $clubId)
                        ->where('member_student_id', $studentId)
                        ->set('member_role', $newRole)
                        ->update();
    }

    /**
     * Removes a member from a specific club.
     *
     * @param int $clubId The ID of the club.
     * @param string $studentId The ID of the student.
     * @return bool
     */
    public function removeMember(int $clubId, string $studentId): bool
    {
        return $this->db->table('tb_club_members')
                        ->where('member_club_id', $clubId)
                        ->where('member_student_id', $studentId)
                        ->delete();
    }

    // --- ClubScheduleModel methods ---

    /**
     * Fetches schedules for a specific club.
     *
     * @param int $clubId The ID of the club.
     * @return array An array of schedule objects.
     */
    public function getSchedulesByYear(string $year): array
    {
        return $this->db->table('tb_club_settings_schedule')
                        ->where('tcs_academic_year', $year)
                        ->get()
                        ->getResult();
    }

    /**
     * Inserts a new schedule.
     *
     * @param array $data The data for the new schedule.
     * @return bool
     */
    public function insertSchedule(array $data): bool
    {
        return $this->db->table('tb_club_settings_schedule')->insert($data);
    }

    /**
     * Finds a schedule by its ID.
     *
     * @param int $scheduleId The ID of the schedule.
     * @return object|null The schedule data or null if not found.
     */
    public function findSchedule(int $scheduleId): ?object
    {
        return $this->db->table('tb_club_settings_schedule')->where('tcs_schedule_id', $scheduleId)->get()->getRow();
    }

    // --- ClubAttendanceModel methods ---

    /**
     * Fetches attendance records for a specific schedule.
     *
     * @param int $scheduleId The ID of the schedule.
     * @return array An array of attendance records.
     */
    public function getAttendanceBySchedule(int $scheduleId): array
    {
        return $this->db->table('tb_club_recoed_activity')
                        ->where('trca_schedule_id', $scheduleId)
                        ->get()
                        ->getResult();
    }

    /**
     * Fetches attendance status for a specific student in a specific schedule.
     *
     * @param int $scheduleId The ID of the schedule.
     * @param int $studentId The ID of the student.
     * @return string|null The attendance status or null if not found.
     */
    public function getStudentAttendanceStatus(int $scheduleId, int $studentId): ?string
    {
        $record = $this->db->table('tb_club_recoed_activity')
                           ->where('schedule_id', $scheduleId)
                           ->where('StudentID', $studentId)
                           ->get()->getRow();
        return $record->status ?? null;
    }

    /**
     * Saves or updates an attendance record.
     *
     * @param int $scheduleId The ID of the schedule.
     * @param int $studentId The ID of the student.
     * @param string $status The attendance status.
     * @return bool
     */
    public function saveAttendance(int $scheduleId, int $studentId, string $status): bool
    {
        $data = [
            'schedule_id' => $scheduleId,
            'StudentID' => $studentId,
            'status' => $status,
            'recorded_at' => date('Y-m-d H:i:s')
        ];

        // Check if a record already exists for this student and schedule
        $existingRecord = $this->db->table('tb_club_recoed_activity')
                                   ->where('schedule_id', $scheduleId)
                                   ->where('StudentID', $studentId)
                                   ->get()->getRow();

        if ($existingRecord) {
            // Update existing record
            return $this->db->table('tb_club_recoed_activity')
                            ->where('record_id', $existingRecord->record_id)
                            ->update($data);
        } else {
            // Insert new record
            return $this->db->table('tb_club_recoed_activity')->insert($data);
        }
    }

    // --- ClubActivityModel methods ---

    /**
     * Fetches activities for a specific club.
     *
     * @param int $clubId The ID of the club.
     * @return array An array of activity objects.
     */
    public function getActivitiesByClub(int $clubId): array
    {
        return $this->db->table('tb_club_activities')
                        ->where('act_club_id', $clubId)
                        ->orderBy('activity_date', 'DESC')
                        ->get()
                        ->getResult();
    }

    /**
     * Inserts a new activity.
     *
     * @param array $data The data for the new activity.
     * @return bool
     */
    public function insertActivity(array $data): bool
    {
        return $this->db->table('tb_club_activities')->insert($data);
    }

    /**
     * Finds an activity by its ID.
     *
     * @param int $activityId The ID of the activity.
     * @return object|null The activity data or null if not found.
     */
    public function findActivity(int $activityId): ?object
    {
        return $this->db->table('tb_club_activities')->where('act_id', $activityId)->get()->getRow();
    }

    /**
     * Updates an activity.
     *
     * @param int $activityId The ID of the activity.
     * @param array $data The data to update.
     * @return bool
     */
    public function updateActivity(int $activityId, array $data): bool
    {
        return $this->db->table('tb_club_activities')
                        ->where('act_id', $activityId)
                        ->update($data);
    }

    /**
     * Deletes an activity.
     *
     * @param int $activityId The ID of the activity.
     * @return bool
     */
    public function deleteActivity(int $activityId): bool
    {
        return $this->db->table('tb_club_activities')
                        ->where('act_id', $activityId)
                        ->delete();
    }
}

