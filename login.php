<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Catastrophic Claims Unit Login Page</title>
    <link href="css/bootstrapcss/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/mainTest.css" type="text/css" rel="stylesheet" />
</head>
<body>
<header>
    <div class="container-fluid" id="logo">
        <img src="img/Auto-Owners.png" width="900" height="309" alt="logo"/>
    </div>
</header>
<div id="logo">
    <h2>Login</h2>
    <form method="post" action="post/login-post.php">
        <p>
            <label for="user">User Name: &nbsp;</label><input type="text" name="user">&nbsp;&nbsp;
            <label for="password">Password: &nbsp;</label><input type="password" name="password">
            <input type="submit">
        </p>
        <span id="errorLogin" >&nbsp;</span>
    </form>

</div>
</body>
</html>