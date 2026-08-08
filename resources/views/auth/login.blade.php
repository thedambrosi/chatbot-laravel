<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Entrar</title>
</head>

<body>
    <h1>Entrar</h1>

    @if (session('error'))
    <p style="color: red">{{ session('error') }}</p>
    @endif

    <a href="{{ route('google.redirect') }}">Entrar com Google</a>
</body>

</html>