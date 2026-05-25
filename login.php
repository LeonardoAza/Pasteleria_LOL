<?php
session_start();
// si el usuario ya estaba se conecta, lo mandamos directo a la bienvenida
if (isset($_SESSION['usuario_nombre'])) {
    header("Location: bienvenido.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Pastelería Lol 🎂</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-rose-100 overflow-hidden p-8">
        
        <div class="text-center mb-8">
            <span class="text-5xl block mb-2">🎂</span>
            <h2 class="text-3xl font-black text-stone-800 tracking-tight">¡Bienvenido de Nuevo!</h2>
            <p class="text-stone-500 text-sm mt-1">Ingresa tus datos para endulzar tu día</p>
        </div>

        <?php
        // captura de erroes xddd
        if (isset($_GET['error'])) {
            echo '<div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-r-xl mb-6 text-sm text-red-700 font-medium flex items-center gap-2">
                    <span>❌</span> Datos incorrectos. Intenta de nuevo.
                  </div>';
        }
        ?>

        <form action="procesar_login.php" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Correo electrónico</label>
                <input type="email" 
                       name="correo" 
                       required 
                       placeholder="ejemplo@correo.com"
                       class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-stone-800 placeholder-stone-400 focus:outline-none focus:border-rose-400 focus:bg-white transition duration-200 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Contraseña</label>
                <input type="password" 
                       name="contraseña" 
                       required 
                       placeholder="••••••••"
                       class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-stone-800 placeholder-stone-400 focus:outline-none focus:border-rose-400 focus:bg-white transition duration-200 text-sm">
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-rose-100 hover:shadow-xl transition tracking-wide text-sm">
                    Entrar a mi Cuenta 🍰
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-stone-100 text-center">
            <p class="text-sm text-stone-500">
                ¿Aún no tienes cuenta? 
                <a href="registro.php" class="text-rose-500 hover:text-rose-600 font-bold ml-1 transition">
                    Regístrate aquí
                </a>
            </p>
        </div>

    </div>

</body>
</html>