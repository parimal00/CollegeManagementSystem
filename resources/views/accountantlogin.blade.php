<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login Form | LMS </title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/custom.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<br>

@if (Session::has('failure'))
    <script>
        toastr.error('{{ session('failure') }}')
    </script>
@endif

<div class="col-lg-12 text-center ">
    <h1 style="font-family:Lucida Console">Account Management System</h1>
</div>

<br>

<body class="login">


    <div class="login_wrapper">

        <section class="login_content">
            <form action="login_accountant" method="POST">
                @csrf;
                <h1>Accountant Login Form</h1>

                <div>
                    <input type="text" name="username" class="form-control" placeholder="Username"
                        required="" /><br>
                </div>
                <div>
                    <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                </div>
                <div>

                    <input class="btn btn-default submit" type="submit" name="submit1" value="Login">
                    <a class="reset_pass" href="#">Lost your password?</a>
                </div>







                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">New to site?
                        <a href="registration.html"> Create Account </a>
                    </p>

                    <div class="clearfix"></div>
                    <br />


                </div>
            </form>
        </section>


    </div>

    <div class="alert alert-danger col-lg-6 col-lg-push-3">
        <strong style="color:white">Invalid</strong> Username Or Password.
    </div>


</body>

</html>
