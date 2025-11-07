<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('logout', 'Login::logout');

$routes->get('login/googleLogin', 'Login::googleLogin');
$routes->get('login/googleCallback', 'Login::googleCallback');

// Placeholder for the page after login. We will create this controller next.
    $routes->get('home', 'Home::index');

    // Homeroom Routes
    $routes->group('homeroom', static function ($routes) {
        $routes->get('', 'HomeroomController::index');
        $routes->get('add', 'HomeroomController::add');
        $routes->post('insert', 'HomeroomController::insert');
        $routes->post('update/(:num)', 'HomeroomController::update/$1');
        $routes->get('dashboard/(:any)', 'HomeroomController::dashboard/$1');
    });

    // Assessment Routes
    $routes->group('assessment', static function ($routes) {
        $routes->get('', 'AssessmentController::index');
        $routes->get('save-score-main', 'AssessmentController::saveScoreMain');
        $routes->get('save-score-normal', 'Assessment\ControllerSaveScore::normal');
        $routes->get('add-score-normal/(:any)/(:num)/(:any)', 'AssessmentController::add/$1/$2/$3');
        $routes->post('process-save-score-normal', 'AssessmentController::insertScore');
        
        $routes->get('add/(:num)/(:num)/(:num)/(:any)', 'AssessmentController::add/$1/$2/$3/$4');
        $routes->post('insert', 'AssessmentController::insertScore');
        $routes->post('update', 'AssessmentController::updateScore');
        $routes->post('report', 'AssessmentController::report'); // Placeholder for report

        // Repeat Score Routes
        $routes->get('save-score-repeat', 'Assessment\ControllerSaveScoreRepeat::normal');
        $routes->get('save-score-repeat-add/(:any)/(:any)/(:any)/(:any)', 'Assessment\ControllerSaveScoreRepeat::saveScoreRepeatAdd/$1/$2/$3/$4');
        $routes->post('report-learn-repeat', 'Assessment\ControllerSaveScoreRepeat::ReportLearnRepeat');

        $routes->group('save-score-repeat', ['namespace' => 'App\Controllers\Assessment'], static function ($routes) {
            $routes->post('setting-score/(:any)', 'ControllerSaveScoreRepeat::settingScore/$1');
            $routes->post('edit-score', 'ControllerSaveScoreRepeat::editScore');
            $routes->post('insert-score', 'ControllerSaveScoreRepeat::insertScore');
            $routes->post('autosave-score', 'ControllerSaveScoreRepeat::autosaveScore');
            $routes->post('checkroom-report', 'ControllerSaveScoreRepeat::checkroomReport');
        });

        $routes->get('save-score-add/(:any)/(:any)/(:any)/(:any)', 'Assessment\ControllerSaveScore::saveScoreAdd/$1/$2/$3/$4');
        // Routes for SaveScore Controller
        $routes->group('save-score', ['namespace' => 'App\Controllers\Assessment'], static function ($routes) {
            $routes->get('add/(:any)/(:any)/(:any)/(:any)', 'ControllerSaveScore::saveScoreAdd/$1/$2/$3/$4');
            $routes->post('setting-score/(:any)', 'ControllerSaveScore::settingScore/$1');
            $routes->post('edit-score', 'ControllerSaveScore::editScore');
            $routes->post('insert-score', 'ControllerSaveScore::insertScore');
            $routes->post('autosave-score', 'ControllerSaveScore::autosaveScore');
            $routes->post('checkroom-report', 'ControllerSaveScore::checkroomReport');
        });
        $routes->post('report-learn-normal', 'Assessment\ControllerSaveScore::ReportLearnNormal');
    });

    // Curriculum Routes
    $routes->group('curriculum', static function ($routes) {
        $routes->get('', 'CurriculumController::index');
        $routes->get('SendPlan', 'CurriculumController::index');
        $routes->get('(:num)/(:num)', 'CurriculumController::index/$1/$2');
        $routes->get('send-plan', 'CurriculumController::sendPlan');
        $routes->get('edit-plan/(:num)', 'CurriculumController::editPlan/$1');
        $routes->post('insert-plan', 'CurriculumController::insertPlan');
        $routes->post('update-plan', 'CurriculumController::updatePlan');
        $routes->post('set-main-subject', 'CurriculumController::setMainSubject');
        $routes->get('delete-plan/(:num)', 'CurriculumController::deletePlan/$1');
        $routes->get('download-plan-file/(:num)', 'CurriculumController::downloadPlanFile/$1');
        $routes->get('download-plan', 'CurriculumController::loadPlan');
        $routes->get('download-plan/(:num)/(:num)/(:any)', 'CurriculumController::loadPlan/$1/$2/$3');
        $routes->get('download-plan-zip/(:any)', 'CurriculumController::downloadPlanZip/$1');

        // Routes for Head of Department
        $routes->get('check-plan-head', 'CurriculumController::checkPlanHead');
        $routes->get('check-plan-head-detail/(:any)', 'CurriculumController::checkPlanHeadDetail/$1');
        $routes->get('check-plan-head-detail/(:any)/(:num)/(:num)', 'CurriculumController::checkPlanHeadDetail/$1/$2/$3');
        $routes->post('update_status1', 'CurriculumController::update_status1');
        $routes->post('get_comment', 'CurriculumController::get_comment');
        $routes->post('save_comment', 'CurriculumController::save_comment');
    });

    // Reading Assessment Routes
    $routes->group('teacher/reading_assessment', static function ($routes) {
        $routes->get('', 'ReadingAssessmentController::index');
        $routes->get('assess/(:num)/(:num)', 'ReadingAssessmentController::assessClass/$1/$2');
        $routes->post('save', 'ReadingAssessmentController::saveEvaluation');
        $routes->post('save_class', 'ReadingAssessmentController::saveClassEvaluation');
        $routes->get('print_report/(:num)/(:num)', 'ReadingAssessmentController::printReport/$1/$2');
    });

    // Desirable Characteristics Assessment Routes
    $routes->group('teacher/desirable_assessment', static function ($routes) {
        $routes->get('', 'DesirableAssessmentController::index');
        $routes->get('assess/(:num)/(:num)', 'DesirableAssessmentController::assessClass/$1/$2');
        $routes->post('save_class', 'DesirableAssessmentController::saveClassEvaluation');
        $routes->get('print_report/(:num)/(:num)', 'DesirableAssessmentController::printReport/$1/$2');
    });