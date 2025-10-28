<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบงานครู SKJ | สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS (Bootstrap 5 CDN)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome CSS (Font Awesome 6 CDN)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.default.css" id="theme-stylesheet">

    <!-- Favicon-->
    <link rel="shortcut icon" href="https://skj.ac.th/uploads/logo/LogoSKJ_4.png">
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

</head>

<body style="font-family:Sarabun; background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);">

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 25rem;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">เข้าสู่ระบบ งานครู SKJ</h3>
                <form method="post" action="<?php echo site_url('login/authenticate'); ?>">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="login-username" name="username" placeholder="ชื่อผู้ใช้งาน Email" required autocomplete="off">
                        <label for="login-username">ชื่อผู้ใช้งาน Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="login-password" name="password" placeholder="รหัสผ่าน" required>
                        <label for="login-password">รหัสผ่าน</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sign-in-alt"></i> Login</button>
                    </div>
                </form>
                <hr class="my-4">
                <div class="d-grid gap-2">
                    <a href="<?= $google_login_url ?>" class="btn btn-outline-danger btn-lg">
                        <i class="fab fa-google"></i> Sign in with Google
                    </a>
                </div>
                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo session()->getFlashdata('msg'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap JS (Bootstrap 5 CDN)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="<?php echo base_url(); ?>assets/js/front.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/all.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');
            loginForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                const username = document.getElementById('login-username').value;
                const password = document.getElementById('login-password').value;

                // Basic client-side validation
                if (!username || !password) {
                    Swal.fire("แจ้งเตือน", "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน", "warning");
                    return;
                }

                // Send AJAX request
                fetch(loginForm.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest' // Important for CodeIgniter's is_ajax_request()
                        },
                        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                title: "สำเร็จ!",
                                text: data.message,
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'home'; // Redirect to home page
                            });
                        } else {
                            Swal.fire("แจ้งเตือน", data.message, "error");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire("แจ้งเตือน", "เกิดข้อผิดพลาดในการเชื่อมต่อ", "error");
                    });
            });
        });
    </script>
</body>

</html>