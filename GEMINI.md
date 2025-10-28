
# Gemini CLI Context and Rules

This document provides context and rules for the Gemini CLI to ensure that UX/UI design and other tasks are performed consistently and in accordance with project conventions.

## 1. Database Schema

The application uses a MySQL database named `skjacth_academic`. The following tables have been identified:

### `tb_register`

This table stores student registration information for subjects.

| Column | Type | Description |
|---|---|---|
| `StudentID` | varchar(17) | Student ID (17 characters) |
| `SubjectID` | int(10) | Subject ID |
| `Score100` | text | Score (out of 100) |
| `Grade` | varchar(3) | Grade |
| `RegisterYear` | varchar(6) | Semester/Academic Year |
| `RegisterClass` | varchar(10) | Class |
| `TeacherID` | varchar(20) | Teacher ID |
| `StudyTime` | text | Study Time |
| `Grade_Type` | varchar(20) | Grade Type |
| `RepeatStatus` | varchar(10) | Repeat Status |
| `RepeatYear` | varchar(6) | Repeat Year |
| `RepeatTeacher` | varchar(15) | Repeat Teacher |
| `RepeatConfirm` | varchar(20) | Repeat Confirm |
| `Grade_UpdateTime` | datetime | Grade Update Time |

### `tb_send_plan`

This table stores information about submitted lesson plans.

| Column | Type | Description |
|---|---|---|
| `seplan_ID` | int(5) | Plan ID |
| `seplan_namesubject` | varchar(50) | Subject Name |
| `seplan_coursecode` | varchar(10) | Course Code |
| `seplan_gradelevel` | varchar(2) | Grade Level |
| `seplan_typesubject` | varchar(10) | Subject Type |
| `seplan_typeplan` | varchar(30) | Plan Type |
| `seplan_sendcomment` | text | Send Comment |
| `seplan_createdate` | datetime | Create Date |
| `seplan_usersend` | varchar(20) | User Send |
| `seplan_learning` | varchar(15) | Learning |
| `seplan_inspector1` | varchar(60) | Inspector 1 |
| `seplan_comment1` | text | Comment 1 |
| `seplan_inspector2` | varchar(60) | Inspector 2 |
| `seplan_comment2` | text | Comment 2 |
| `seplan_status1` | varchar(30) | Status 1 |
| `seplan_status2` | varchar(30) | Status 2 |
| `seplan_year` | varchar(4) | Year |
| `seplan_term` | varchar(1) | Term |
| `seplan_file` | text | File |
| `seplan_checkdate1` | datetime | Check Date 1 |
| `seplan_checkdate2` | datetime | Check Date 2 |

### Other Tables

Based on the controllers and models, the following tables are also likely to exist:

- `tb_assessment`
- `tb_curriculum`
- `tb_homeroom`
- `tb_login`
- `tb_students`
- `tb_subjects`
- `tb_personnel`

## 2. Project Conventions

### Naming Conventions

- **Controllers:** PascalCase, with the suffix `Controller` (e.g., `CurriculumController.php`).
- **Models:** PascalCase, with the suffix `Model` (e.g., `CurriculumModel.php`).
- **Views:** Directories are lowercase. View files are lowercase with underscores (e.g., `welcome_message.php`).

### File Structure

The project follows the CodeIgniter 4 framework structure.

- `app/`: Contains the application's core code (Controllers, Models, Views, etc.).
- `public/`: The web server's document root.
- `writable/`: Directory for storing cache, logs, and other writable data.
- `tests/`: Contains the application's tests.
- `vendor/`: Composer dependencies.

## 3. User Roles

Based on the controllers and views, the application appears to have the following user roles:

- **Teacher:**  Can manage curriculum, homeroom, and assessments.
- **Admin/Principal:** Can manage teachers, students, and other system settings.
- **Student:** Can view their grades and other information.

## 4. UX/UI Design Rules

- **Template:** The application uses the AdminLTE template. All new UI components should be consistent with the AdminLTE style.
- **Responsiveness:** The UI should be responsive and work on all screen sizes.
- **Clarity:** The UI should be clear and easy to understand.
- **Consistency:** The UI should be consistent across the entire application.

## 5. CODEIGNITER 4 (CI4) INTEGRATION RULES

### Controllers

- **Base Controller:** All controllers must extend the `BaseController`.
- **Data Passing:** Pass data to views using the `$this->response->setJSON()` method for JSON responses or by passing an array to the `view()` helper.
- **Security:** Use the built-in security features of CodeIgniter, such as `esc()` for escaping output and CSRF protection.

### Models

- **Database Connection:** Use the `$this->db->table()` method to interact with the database.
- **Query Builder:** Use the Query Builder class for all database queries.
- **Data Validation:** Use the Validation class to validate all incoming data.

### Views

- **Template:** Use the AdminLTE template for all views.
- **Data Display:** Use the `esc()` function to escape all data that is displayed in the view.
- **Partials:** Use partials for reusable view components, such as headers, footers, and sidebars.

### Routes

- **RESTful Routes:** Use RESTful routes for all API endpoints.
- **Named Routes:** Use named routes for all web routes.
- **Route Groups:** Use route groups to organize related routes.

## 6. AdminLTE v4.0.0-rc3 DESIGN PRINCIPLES

- **Responsiveness:** The template is fully responsive, adapting to various screen resolutions from mobile devices to large desktops.
- **Bootstrap 5 Foundation:** It is based on the Bootstrap 5 framework and its JavaScript plugins, leveraging Bootstrap’s mobile-first, component-based, and responsive design philosophy.
- **High Customizability:** AdminLTE is designed to be highly customizable and easy to use, with SCSS employed to enhance code customizability.
- **Cross-Platform Compatibility and Robust Deployment:** A significant focus of this release candidate is on resolving critical production deployment issues and ensuring consistent behavior across development and production environments. This includes intelligent relative path calculation for assets, proper handling of RTL (Right-to-Left) CSS, and reliable image loading in diverse deployment scenarios.
- **Modernization:** The codebase has undergone a complete modernization, incorporating the latest tooling, dependencies (such as updated TypeScript, ESLint, and Prettier), and best practices.
- **Accessibility:** AdminLTE v4 aims for full accessibility, complying with WCAG 2.1 AA standards.
- **Clean Code and Maintainability:** The template features carefully commented JS, SCSS, and HTML files, and efforts have been made to remove runtime path fixes that caused console errors, contributing to cleaner and more maintainable code.
- **Enhanced User Experience (UX):** Improvements such as full-width navigation links for better clickable areas and correctly displayed sidebar navigation with proper spacing indicate a focus on improving the overall user experience.
