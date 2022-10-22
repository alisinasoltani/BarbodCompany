<?php
    include __DIR__.'/DB.php';
    include __DIR__.'/Auth.php';
    $flag = 0;
    if (isset($_POST['username']) && isset($_POST['password'])){
        $db = new DB();
        $auth = new Auth($db);
        if ($auth->checkUsername($_POST['username']) && $auth->checkPassword($_POST['username'], $_POST['password'])) {
            header('Location: '. 'index.php');
        } else {
            $flag = 1;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <link rel="stylesheet" href="form.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  </head>
    </head>
    <body class="container-fluid">
        <div class="row form-row">
            <div class="col-3 form-body">
                <div class="form-img"><img src="colleagues-working-together-project_74855-6308.webp" alt="" /></div>
                <?php if ($flag): ?>
                    <div class="warn">Wrong Username or Password</div>
                <?php endif; ?>
                <form class="form" method="POST" action="">
                    <div class="form-input-group">
                        <label class="form-label" for="username">Userneme:</label><br />
                        <input class="form-input" type="text" name="username" /><br />
                    </div>
                    <div class="form-input-group">
                        <label class="form-label" for="password">Password:</label><br />
                        <input class="form-input" type="password" name="password" /><br />
                    </div>
                    <button class="btn" type="submit">
                        Login
                    </button>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>