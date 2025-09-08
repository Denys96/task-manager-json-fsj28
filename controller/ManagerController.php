<?php

require_once "EmployeeController.php";
require_once "../interfaces/ICRUDTask.php";

class ManagerController extends EmployeeController implements ICRUDTask {

    public static function getTask()
    {
        try{
            //ORM => (Mapeo-Objeto-Relacional)
            //find() => encontrar un registro en base a un ID
            $list_tasks = TaskModel::all(); //metodo mapeado
            return $list_tasks;
        }catch(Error $error){
            return "Error al obtener las tareas: " . $error;
        }
    }

    public static function createTask(TaskModel $task)
    {
        try{
            $task->save();
            //redireccionar a una vista
            header('Location: ../views/listTasks.php');
            exit; // Importante: agregar exit después de header
        }catch(Error $error){
            return "Error al guardar los datos " . $error;
        }
    }

    public static function editTask($id_task, $title, $description)
    {
        try{
            TaskModel::edit($id_task, $title, $description);
            header('Location: ../views/listTasks.php');
            exit; // Importante: agregar exit después de header
        }catch(Error $error){
            return "Error al guardar los datos " . $error;
        }
    }

    // Método para cambiar el estado 
    public static function changeTaskStatus($id)
    {
        try{
            $id = intval($id);
            TaskModel::changeStatus($id);
            header('Location: ../views/listTasks.php');
            exit;
        }catch(Error $error){
            return "Error al cambiar el estado: " . $error;
        }
    }

}

// Código fuera de la clase para manejar la solicitud
if(isset($_GET['change_status'])){
    $id = intval($_GET['change_status']);
    // TaskModel ya está incluido por la interfaz o por otros require_once, pero aseguramos su carga:
    require_once "../models/TaskModel.php";
    
    // Llamar al método estático de la clase
    ManagerController::changeTaskStatus($id);
}