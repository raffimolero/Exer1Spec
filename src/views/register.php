<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/init.php'; ?>

<?php ob_start(); ?>
<!-- TODO: automatically get the path? -->
<form name="register" action="/controllers/register/submit.php" onsubmit="return validate()" method="post">
    <label for="custname">Name: </label>
    <input type="text" name="custname" id="custname" placeholder="[Lastname, Firstname M.I.]" />
    <br />

    <label for="address">Address: </label>
    <input type="text" name="address" id="address" placeholder="[Blk. Subd. etc]" />
    <br />

    <label for="number">Phone number: </label>
    <input type="text" name="number" id="number" placeholder="[09xx-xxx-xxxx]" />
    <br />

    <label for="email">Email: </label>
    <input type="text" name="email" id="email" placeholder="[username@example.com]" />
    <br />

    <label for="password">Password: </label>
    <input type="password" name="password" id="password" placeholder="[strong password]" />
    <br />

    <label for="confirmpassword">Password: </label>
    <input type="password" name="confirmpassword" id="confirmpassword" placeholder="[re-type password]" />
    <br />

    <input type="submit" name="customer" id="submit" value="Register" />
</form>
<script src="/controllers/register/validate.js"></script>
<!--
TODO: automatically generate a script src if one is found in the correct controllers folder?
'script' => 'validate.js',
-->
<?php $body = ob_get_clean(); ?>

<?= render('template', [
    'title' => 'Register',
    'body' => $body,
])
?>