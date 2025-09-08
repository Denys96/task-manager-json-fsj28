
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Registro de Tareas</title>
</head>
<body>
    <?php
        require_once "../controller/ManagerController.php";
        $data_employees = ManagerController::getEmployees(); //[]
        //print_r($data_employees);

        // -> el name = representa lo que php va extraer de cada entrada de dato
    ?>
    <main class="container">
        <h1 class="my-4">Crear Tarea</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="">Id Tarea</label>
                <input type="number" class="form-control" name="id_task" required>
            </div>
            <div class="mb-3">
                <label for="">Titulo</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="">Descripcion</label>
                <input type="text" class="form-control" name="description" required>
            </div>

            <div class="mb-3">
                <label for="">Asignar Empleado</label>
                <select id="" class="form-control" name="id_employee">
                    <?php foreach($data_employees as $employee) { ?>
                        <option value="<?php echo $employee['id_employee'] ?>"><?php echo $employee['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="submit" class="btn btn-success" value="Crear Tarea">
        </form>
    </main>

    <?php

        // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //     $id = $_POST['id_task'];
        //     $title = $_POST['title'];
        //     $description = $_POST['description'];
        //     $employee = $_POST['id_employee'];

        // }
        //isset() => verifica si hay datos o no hay datos
        if(isset($_POST['id_task'],  $_POST['title'], $_POST['description'], $_POST['id_employee'])){

            $id = $_POST['id_task'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $employee = $_POST['id_employee'];

            $task = new TaskModel($id, $title, $description, $employee);
            ManagerController::createTask($task);
        }
        
    ?>
</body>
</html>
