<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sicepat</title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.css') ?>">
    
    <link rel="stylesheet" href="<?= base_url('/assets/css/app.css') ?>">
    <style>
        body {
            background-color: #F8E8EE; /* Soft red background OR use #F6FDC3 for cream */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333; /* Dark gray text for better readability */
        }

        .login-container {
            background-color: white; /* White background for the card */
            padding: 20px;
            border-radius: 10px; 
            margin-top: 100px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .form-control {
            background-color: #fff; /* White input background */
            border: 1px solid #ced4da; /* Add a subtle border to the input fields */
            color: #333; /* Dark gray text */
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #E91E63; /* Red button */
            border: none;
            border-radius: 5px;
            color: white; /* White text on button */
            transition: background-color 0.3s ease; /* Smooth transition on hover */
        }

        .btn-primary:hover {
            background-color: #C2185B; /* Darker red on hover */
        }

        .logo {
            max-width: 200px; /* Adjust the logo size as needed */
            display: block;
            margin: 0 auto 20px;
        }

        .logo img {
            display: block;
            margin: 0 auto;
        }

        /* Style the alert messages */
        .alert {
            border-radius: 5px; /* Add rounded corners to alerts */
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="<?= base_url('assets/images/logo.png') ?>" height="200" class='mb-4'>
                                <h3>Sign In</h3>
                            </div>
                            <?php if (session()->getFlashdata('msg')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('msg') ?>
                            </div>
                            <?php endif; ?>
                            <form action="<?= base_url('/login/auth') ?>" method="post">
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="username" name="username" required>
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block mt-2">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/feather-icons/feather.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>
