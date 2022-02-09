<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $name }}, solicitaste restaurar la contraseña en <strong>Sistema de gestión de cátedras</strong> !</h2>
    <p>Por favor confirma la solicitud.</p>
    <p>Si no te has registrado en la aplicación, ignora el mensaje</p>
    <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>
    <p><strong>Código de verificación</strong></p>
    <p><strong>{{$codigo}}</strong></p>
    <a href="{{ url('/api/activarcuenta/' . $codigo) }}">
        Clic para confirmar la restauración
    </a>
</body>
</html>