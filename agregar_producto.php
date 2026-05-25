<?php
session_start();

// si no es admin lo mandamos alv al login
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
include 'header.php';
?>

<div class="mb-8 text-center md:text-left max-w-2xl mx-auto">
    <h2 class="text-3xl font-extrabold text-stone-800 tracking-tight flex items-center justify-center md:justify-start gap-2">
        👑 Panel de Administración
    </h2>
    <p class="text-stone-600 mt-2">
        Registro de pastel
    </p>
</div>

<div class="bg-white w-full max-w-2xl rounded-2xl shadow-md border border-rose-100 overflow-hidden p-8 mx-auto mb-12">
    
    <div class="border-b border-stone-100 pb-4 mb-6">
        <h3 class="text-lg font-bold text-stone-800 flex items-center gap-2">
            🎂 Detalles del Nuevo Producto
        </h3>
    </div>

    <form action="procesar_producto.php" method="POST" class="space-y-6">
        
        <div>
            <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Nombre del Pastel</label>
            <input type="text" 
                   name="nombre_pastel" 
                   required 
                   placeholder="Ej: Pastel de Tres Leches con Fresa"
                   class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-stone-800 placeholder-stone-400 focus:outline-none focus:border-rose-400 focus:bg-white transition duration-200 text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Descripción del Pastel</label>
            <textarea name="descripcion_pastel" 
                      rows="4" 
                      required 
                      placeholder="Describe los ingredientes, el tamaño, el sabor y para cuántas personas rinde..."
                      class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-stone-800 placeholder-stone-400 focus:outline-none focus:border-rose-400 focus:bg-white transition duration-200 text-sm resize-none"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Precio ($ MXN)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-stone-400 font-medium text-sm">$</span>
                    <input type="number" 
                           name="precio" 
                           step="0.01" 
                           min="0" 
                           required 
                           placeholder="299.50"
                           class="w-full pl-8 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-stone-800 placeholder-stone-400 focus:outline-none focus:border-rose-400 focus:bg-white transition duration-200 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Cantidad en Inventario (Stock)</label>
                <input type="number" 
                       name="stock" 
                       min="0" 
                       required 
                       placeholder="10"
                       class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-stone-800 placeholder-stone-400 focus:outline-none focus:border-rose-400 focus:bg-white transition duration-200 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2">Nombre del archivo de imagen</label>
            <div class="flex">
                <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-stone-200 bg-stone-100 text-stone-500 text-xs font-mono">
                    imagenes/
                </span>
                <input type="text" 
                       name="imagen" 
                       required 
                       placeholder="chocolate.jpg"
                       class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-r-xl text-stone-800 placeholder-stone-400 focus:outline-none focus:border-rose-400 focus:bg-white transition duration-200 text-sm">
            </div>
            <p class="text-[11px] text-stone-400 mt-1.5 pl-1">
                  La imagen debe estar guardada con el mismo nombre y extensión (.jpg, .png).
            </p>
        </div>

        <div class="pt-4 border-t border-stone-100 flex flex-col sm:flex-row shadow-sm gap-3">
            <button type="submit" 
                    class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-md shadow-emerald-100 hover:shadow-lg transition tracking-wide text-sm order-1 sm:order-2">
                Guardar Pastel en Catálogo 
            </button>
            <a href="bienvenido.php" 
               class="w-full bg-stone-100 hover:bg-stone-200 text-stone-600 font-bold py-3.5 px-4 rounded-xl text-center text-sm transition order-2 sm:order-1 border border-stone-200">
                Cancelar y Volver
            </a>
        </div>
    </form>

</div>

<?php

include 'footer.php';
?>