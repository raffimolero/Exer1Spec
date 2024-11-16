<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php'; ?>

<?php ob_start(); ?>
<h1>Register</h1>
<form name="register" action="register/submit.php" onsubmit="return validate()" method="post">
    <label for="custname">Name: </label>
    <input type="text" name="custname" id="custname" placeholder="[Lastname, Firstname M.I.]" />
    <br>

    <label for="address">Address: </label>
    <input type="text" name="address" id="address" placeholder="[123, Petal Str., Agdao, Davao City]" />
    <br>

    <label for="number">Phone number: </label>
    <input type="text" name="number" id="number" placeholder="[09xx-xxx-xxxx]" />
    <br>

    <label for="email">Email: </label>
    <input type="text" name="email" id="email" placeholder="[username@example.com]" />
    <br>

    <label for="password">Password: </label>
    <input type="password" name="password" id="password" placeholder="[strong password]" />
    <br>

    <label for="confirmpassword">Confirm Password: </label>
    <input type="password" name="confirmpassword" id="confirmpassword" placeholder="[re-type password]" />
    <br>

    <input type="submit" name="customer" id="submit" value="Register" />
</form>
<a href="login.html">Log In</a>
<br>
<a href="index.html">Home</a>
<script src="register/validate.js"></script>
<?php $body = ob_get_clean(); ?>

<?= render('template', [
    'title' => 'Register',
    'body' => $body,
]) ?>