<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="miksoft.pro">
    <title>BeeJee test task</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>
    <body class="text-center signin">
        <form action="/auth" method="post" class="form-signin" id="loginform">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="text" name="username" class="form-control" placeholder="Login" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y') ?></p>
        </form>
        <script src="/assets/js/jquery-3.5.0.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/jquery.form.min.js"></script>
        <script src="/assets/js/jquery.validate.min.js"></script>
        <script>
            $("#loginform").validate({
                errorClass: 'is-invalid',
                validClass: 'is-valid',
                rules: {
                    'username': {
                        required: true
                    },
                    'password': {
                        required: true
                    }
                },
                messages: {
                    'username': {
                        required: 'Enter your name'
                    },
                    'password': {
                        required: 'Enter your password'
                    }
                },
                submitHandler: function(form) {
                    $(form).ajaxSubmit({
                        dataType: "json",
                        beforeSubmit: function() {
                            $(form).find('[type="submit"]').addClass('disabled');
                        },
                        success: function(data) {
                            if (data.status != true)
                            {
                                alert(data.error);
                            }
                            else
                            {
                                location.href='/';
                            }
                        }
                    });
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            });
        </script>
    </body>
</html>
