<?php

# modelo que se va encargar de consultar los datos del json de tareas

// guardar tarea, listar todas las tareas, editar tarea (JSON)

class TaskModel{
    public $id_task;
    public $title;
    public $description;
    public $date;
    public $status;
    public $id_employee;

    //atributo para manejar la url del json
    private static $file_path = '../data/tasks.json';

    public function __construct($id_task, $title, $description, $id_empleyoee)
    {
        $this->id_task = $id_task;
        $this->title = $title;
        $this->description = $description;
        $this->date = date('Y-m-d');
        $this->status = 'Pendiente';
        $this->id_employee = $id_empleyoee;
    }

    //metodo para obtener todas las tareas del json
    public static function all(){
        //SELECT * FROM table
        if(file_exists(self::$file_path)){
            //obteniendo el archivo json
            $data_json = file_get_contents(self::$file_path);
            //print_r($data_json);
            //json_decode() = convertir tu JSON a un arreglo de PHP - json_encode() = convertir un arreglo de PHP a json
            //decodificando el json a un arreglo de PHP
            return json_decode($data_json, true); //arreglo de las tareas
        }

        return [];
    }

    //metodo que va cargar el json y lo va actualizar
    private static function loadJSON($array_tasks){
        //metodo que nos ayude actualizar el JSON
        //codificar el arreglo de PHP a un formato de tipo JSON
        $data_json = json_encode($array_tasks, JSON_PRETTY_PRINT);
        file_put_contents(self::$file_path, $data_json);
    }

    //metodo para guardar una tarea
    public function save(){

        $list_tasks = self::all(); //devuelve el arreglo de las tareas que hay en el json

        //agregando un nuevo elemento (tarea)
        //array_push($list_tasks, []);

        $list_tasks[] = [
            "id_task" => $this->id_task,
            "title" => $this->title,
            "description" => $this->description,
            "date" => $this->date,
            "status" => $this->status,
            "id_employee" => $this->id_employee
        ];

        self::loadJSON($list_tasks);
        return "Se ha guardado correctamente";
    }

    public static function edit($id_task, $title, $description){

        //iteramos la lista de tareas del json (decodificadas)
        $list_tasks = self::all();
        //variable booleana para actualizar una tarea
        $found_task = false;

        //referencia
        foreach($list_tasks as &$task){
            //condicionando si la tarea se encuentra en la lista
            if($task['id_task'] == $id_task){
                $found_task = true;
                $task['title'] = $title;
                $task['description'] = $description;
                //hacemos un break para que ya no se iteren las demas tareas
                break;
            }
        }

        //validamos si la tarea se encontro
        if($found_task){
            self::loadJSON($list_tasks);
        }else{
            return "No se encontro la tarea";
        }
    }

public static function changeStatus($id_task){
    // ✅ Usando __DIR__ para una ruta confiable
     $file = dirname(__DIR__) . '/data/tasks.json'; // ../data/tasks.json relativo al proyecto
    
    if(!file_exists($file)){
        error_log("Archivo no encontrado: " . $file);
        return false;
    }

    $json = file_get_contents($file);
    $tasks = json_decode($json, true);
    
    if(!is_array($tasks)){
        error_log("Error decodificando JSON o archivo vacío");
        return false;
    }

    $found = false;
    foreach($tasks as &$task){
        // ✅ Validación más robusta del ID
        if(isset($task['id_task']) && (int)$task['id_task'] === (int)$id_task){
            
            // ✅ Lógica corregida (sin duplicados)
            $current = mb_strtolower(trim($task['status'] ?? ''));
            
            switch($current){
                case 'pendiente':
                    $task['status'] = 'en proceso';
                    break;
                case 'en proceso':
                case 'enproceso': // Compatibilidad con typo
                    $task['status'] = 'completado';
                    break;
                case 'completado':
                    $task['status'] = 'pendiente'; // Ciclo completo
                    break;
                default:
                    $task['status'] = 'pendiente'; // Valor por defecto
                    break;
            }

            $found = true;
            break;
        }
    }

    if($found){
        // ✅ Guardar con manejo de errores
        $result = file_put_contents(
            $file, 
            json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
        
        if($result === false){
            error_log("Error guardando en el archivo JSON");
            return false;
        }
    }

    return $found;
}

}