<?php

session_start();

// Redirect to results if logged in
if($_SESSION['logged_in']){
    header('Location: results.php');
    exit;
}

// Include form submission handling if POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include('include/login_register_submission.php');
}

// Set vars and render header
$css_files = array('login');
$js_files = array('login');
$title = 'Stream Send Login';
$page = 'login';
include('include/header.php');

?>
<table cellspacing="0" class="contain">
    <tr class="main">
        <td class="leftBack"><p>&nbsp;</p></td>
        <?php
        /* 
            Using novalidate because the default appearance of errors on a lot of 
            browsers is not too aesthetically appealing. Overriding with JS, but
            keeping semantic types of HTML5
        */
        ?>
        <td class="loginCell">
            <section class="login pageForm">
                <form novalidate name="login" action="login.php" method="POST">
                    <p class="header">Login</p>
                    <?php if ($errors['message'] && $errors['login']) { ?>
                        <div class="errorBox">
                            <?php echo $errors['message']; ?>
                        </div>
                    <?php } ?>
                    <div class="input">
                        <input name="email" type="email" placeholder="E-mail Address" value="<?php echo $_POST['email']; ?>">
                        <div style="display: <?php echo $errors['email'] ? 'block' : 'none' ?>;" class="errorMessage">
                            Please enter a valid e-mail address.
                        </div>
                    </div>
                    <div class="input">
                        <input name="password" type="password" placeholder="Password" value>
                        <div style="display: <?php echo $errors['password'] ? 'block' : 'none' ?>;" class="errorMessage">
                            Please enter a password.
                        </div>
                    </div>
                    <button type="submit" name="login" value="1">
                        Login
                    </button>
                </form>
            </section>
        </td>
        <td class="registerCell">
            <section class="register pageForm">
                <form novalidate name="register" action="login.php" method="POST">
                    <p class="header">Register</p>
                    <?php if ($errors['message'] && !$errors['login']) { ?>
                        <div class="errorBox">
                            <?php echo $errors['message']; ?>
                        </div>
                    <?php } ?>
                    <div class="row cf">
                        <div class="input">
                            <input name="first_name" type="text" placeholder="First Name" value="<?php echo $_POST['first_name']; ?>">
                            <div class="errorMessage" style="display: <?php echo $errors['first_name'] ? 'block' : 'none' ?>;">
                                Please enter your first name.
                            </div>
                        </div>
                        <div class="input">
                            <input name="last_name" type="text" placeholder="Last Name" value="<?php echo $_POST['last_name']; ?>">
                            <div class="errorMessage" style="display: <?php echo $errors['last_name'] ? 'block' : 'none' ?>;">
                                Please enter your last name.
                            </div>
                        </div>
                    </div>
                    <div class="row cf">
                        <div class="input">
                            <input name="reg_email" type="email" placeholder="E-mail Address" value="<?php echo $_POST['reg_email']; ?>">
                            <div class="errorMessage" style="display: <?php echo $errors['reg_email'] ? 'block' : 'none' ?>;">
                                Please enter a valid e-mail address.
                            </div>
                        </div>
                        <div class="input">
                            <input name="password" type="password" placeholder="Password" value>
                            <div class="errorMessage" style="display: <?php echo $errors['password'] ? 'block' : 'none' ?>;">
                                Please enter a password.
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="register" value="1">
                        Register
                    </button>
                </form>
            </section>
        </td>
        <td class="rightBack"><p>&nbsp;</p></td>
    </tr>
</table>

<?php

include('include/footer.php');
