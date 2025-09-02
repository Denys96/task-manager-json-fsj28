<?php

require_once "../models/EmployeeModel.php";

# Manejo de los metodos de la clase Empleado
class EmployeeController {
    protected $id_employee;
    protected $name;
    protected $phone;
    protected $email;
    private $password;
    private $salary;

    public function __construct($id, $name, $phone, $email, $salary)
    {
        $this->id_employee = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = "Kodigo";
        $this->salary = $salary;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setSalary($salary){
        $this->salary = $salary;
    }

    //metodo para obtener todos los empleados
    public static function getEmployees(){
        try{
            $list_employees = EmployeeModel::all(); //metodo mapeado
            return $list_employees;
        }catch(Error $error){
            return "Error al obtener los empleados: " . $error;
        }
    }
}