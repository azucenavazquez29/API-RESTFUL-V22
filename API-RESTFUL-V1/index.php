<?php
include 'read.php'; // Base de datos 
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Actor - Sakila</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; }
        h2 { text-align: center; margin-top: 20px; }

        table { border-collapse: collapse; width: 80%; margin: 20px auto; background-color: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }

        form.inline { display: inline; }
        input[type=text] { padding: 5px; margin-right: 5px; width: 120px; }

        /* Botones estilizados */
        input[type=submit].btn {
            padding: 5px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            font-weight: bold;
            margin-right: 5px;
        }
        input[type=submit].btn-insert { background-color: #28a745; }
        input[type=submit].btn-update { background-color: #007bff; }
        a.btn-delete {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }
        a.btn-delete:hover { opacity: 0.8; }

        /* Formulario crear centrado */
        .create-form { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>CRUD de Actores - Sakila</h2>

    <!-- FORMULARIO CREAR -->
    <form action="create.php" method="post" class="create-form">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="submit" value="Agregar Actor" class="btn btn-insert">
    </form>

    <!-- TABLA ACTORES -->
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Acciones</th>
        </tr>
        <?php foreach($actors as $actor): ?>
            <tr>
                <td><?= $actor['actor_id'] ?></td>
                <td><?= $actor['first_name'] ?></td>
                <td><?= $actor['last_name'] ?></td>
                <td>
                    <!-- Formulario inline para actualizar -->
                    <form action="update.php" method="post" class="inline">
                        <input type="hidden" name="id" value="<?= $actor['actor_id'] ?>">
                        <input type="text" name="first_name" value="<?= $actor['first_name'] ?>" required>
                        <input type="text" name="last_name" value="<?= $actor['last_name'] ?>" required>
                        <input type="submit" value="Editar" class="btn btn-update">
                    </form>

                    <!-- Botón eliminar -->
                    <a href="delete.php?id=<?= $actor['actor_id'] ?>" class="btn-delete" onclick="return confirm('¿Eliminar actor?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>