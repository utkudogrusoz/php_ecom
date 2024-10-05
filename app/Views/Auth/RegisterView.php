<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Formu</title>
</head>
<body>
<h1>Kayıt Ol</h1>


<form action="/codeigniter/auth/register" method="post">
    <label for="first_name">Ad:</label>
    <input type="text" name="first_name" id="first_name" required><br>

    <label for="last_name">Soyad:</label>
    <input type="text" name="last_name" id="last_name" required><br>

    <label for="email">E-posta:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="password">Şifre:</label>
    <input type="password" name="password" id="password" required><br>

    <button type="submit">Kayıt Ol</button>
</form>
</body>
</html>
