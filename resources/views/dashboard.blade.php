<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrontEnd Dashboard</title>
</head>
<body>
    <h1>Frontend Dashboard</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <input type="submit" value="Logout">
    </form>
</body>
</html>
