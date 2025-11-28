<?php 
// Incluye el encabezado general del sitio (CSS, menú, etc.)
require __DIR__ . '/../templates/header.php'; 
?>

<h2>Listado de videojuegos</h2>

<?php 
// ===================================================================
//  CONTROLES DE ORDENAMIENTO Y BÚSQUEDA
//  Estos botones y formulario permiten ordenar y buscar videojuegos
//  en la tabla. El controlador procesa estas solicitudes.
// ===================================================================
?>

<?php if(!empty($videojuegos)): ?>

    <div style="margin-bottom:20px;">
    <strong>Ordenar por:</strong>

    <!-- Botones de ordenamiento (cambian el parámetro sort y order) -->
    <a class="button" href="index.php?sort=titulo&order=<?= $currentOrder ?>">Nombre</a>
    <a class="button" href="index.php?sort=plataforma&order=<?= $currentOrder ?>">Plataforma</a>
    <a class="button" href="index.php?sort=genero&order=<?= $currentOrder ?>">Género</a>
    <a class="button" href="index.php?sort=anio&order=<?= $currentOrder ?>">Año</a>
    <a class="button" href="index.php?sort=precio&order=<?= $currentOrder ?>">Precio</a>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="index.php" style="margin-bottom: 20px;">

        <!-- Campo de texto para buscar por título, plataforma o género -->
        <input type="text" name="buscar" placeholder="Buscar videojuego" 
               value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
               style="width: 250px; padding: 8px;">

        <!-- Botón para iniciar búsqueda -->
        <button type="submit" class="button">Buscar</button>

        <!-- Botón para limpiar resultados -->
        <a href="index.php" class="button">Limpiar</a>
    </form>
</div>

<!-- Cierres sobrantes heredados del diseño anterior -->
</div>
</div>

<?php 
// ===================================================================
//  TABLA DE TODOS LOS VIDEOJUEGOS
//  Muestra cada videojuego con sus atributos y acciones disponibles.
// ===================================================================
?>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>Plataforma</th>
    <th>Género</th>
    <th>Año</th>
    <th>Precio</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php foreach($videojuegos as $v): ?>
<tr>
    <!-- Cada columna muestra un dato del videojuego -->
    <td><?=htmlspecialchars($v['id'])?></td>
    <td><?=htmlspecialchars($v['titulo'])?></td>
    <td><?=htmlspecialchars($v['plataforma'])?></td>
    <td><?=htmlspecialchars($v['genero'])?></td>
    <td><?=htmlspecialchars($v['anio'])?></td>
    <td><?=number_format($v['precio'],2)?></td>

    <!-- Acciones disponibles por registro -->
    <td>
        <!-- Ver detalles (abre modal show.php) -->
        <a href="index.php?action=show&id=<?= $v['id'] ?>">Ver</a> | 
        
        <!-- Editar videojuego -->
        <a href="index.php?action=edit&id=<?= $v['id'] ?>">Editar</a>

        <!-- Eliminar con confirmación -->
        <a href="index.php?action=delete&id=<?= $v['id'] ?>" 
           onclick="return confirm('¿Eliminar?')">Eliminar</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php else: ?>

<!-- Si no existen videojuegos en la BD -->
<p>No hay videojuegos registrados.</p>

<?php endif; ?>

<?php 
// Footer del sitio
require __DIR__ . '/../templates/footer.php'; 
?>
