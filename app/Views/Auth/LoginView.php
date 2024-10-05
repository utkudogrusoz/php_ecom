<!DOCTYPE html>
<html>
<head>
    <title>Giriş Formu</title>
</head>
<body>
<h1>Giriş Yap</h1>


<form action="/codeigniter/auth/login" method="post">

    <label for="email">E-posta:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="password">Şifre:</label>
    <input type="password" name="password" id="password" required><br>

    <button type="submit">Giriş Yap</button>
</form>
</body>
</html>
