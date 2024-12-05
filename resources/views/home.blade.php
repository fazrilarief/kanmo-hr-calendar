<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Kanmo - Login</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

        <style>
            .container-fluid {
                height: 100vh;
                /* Pastikan kontainer penuh layar */
                background-color: #e9500e;
                /* Warna latar belakang sesuai dengan desain */
                display: flex;
                /* Flexbox untuk tata letak */
                justify-content: center;
                /* Pusatkan secara horizontal */
                align-items: center;
                /* Pusatkan secara vertikal */
            }

            .card {
                border-radius: 10px;
                /* Opsional: sudut membulat untuk estetika */
            }
        </style>


    </head>

    <body style="background: #e9500e">

        <div class="container-fluid d-flex justify-content-center align-items-center"
            style="height: 100vh; background-color: #e9500e;">
            <div class="col-xl-4 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('logo/logokanmo.jpg') }}" alt="Logo" width="25%">
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <h2 class="font-weight-bold mb-4 mt-5">Welcome to HR Calendar</h2>
                                        <a href="{{ route('login.form') }}" class="btn py-2 px-5 rounded-pill mb-5"
                                            style="background: #e9500e; color: white;">
                                            Login Page
                                        </a>
                                    </div>
                                    <hr>
                                    <div class="copyright text-center mt-4">
                                        <span>Copyright &copy; Kanmo Group {{ date('Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </body>

</html>
