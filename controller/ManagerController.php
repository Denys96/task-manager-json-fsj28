<?php

require_once "EmployeeController.php";
require_once "../interfaces/ICRUDTask.php";

class ManagerController extends EmployeeController implements ICRUDTask{

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
        }catch(Error $error){
            return "Error al guardar los datos " . $error;
        }
    }

    public static function editTask($id_task, $title, $description)
    {
        try{
            TaskModel::edit($id_task, $title, $description);
            header('Location: ../views/listTasks.php');
        }catch(Error $error){
            return "Error al guardar los datos " . $error;
        }
    }
}