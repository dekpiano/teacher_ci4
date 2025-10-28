<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();

        // Check if user is not logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        // Database connections
        $db = db_connect(); // Default database connection
        $db_personnel = db_connect('personnel');
        $db_affairs = db_connect('affairs');

        // Fetch data like in the old controller
        $CheckHomeVisitManager = $db_affairs->table('tb_homevisit_setting')
                                            ->where('homevisit_set_id', 1)
                                            ->get()
                                            ->getRow();

        $OnOff = $db->table('tb_send_plan_setup')->get()->getResult();

        // The old controller used 'login_id', the new Login controller sets 'person_id'. Using 'person_id'.
        $teacher = $db_personnel->table('tb_personnel')
                                ->select('pers_id, pers_img')
                                ->where('pers_id', $session->get('person_id'))
                                ->get()
                                ->getResult();

        // Prepare data for the view
        $data = [
            'title'                 => 'หน้าแรก',
            'CheckHomeVisitManager' => $CheckHomeVisitManager,
            'OnOff'                 => $OnOff,
            'teacher'               => $teacher
        ];

        // Load the view, which will in turn use the main layout
        return view('teacher/home/index', $data);
    }
}
