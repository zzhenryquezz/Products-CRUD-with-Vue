<?php
/**
 *  File to database conection
*/
namespace Includes;

class Database
{
    private $dbHost = 'localhost';
    private $dbUser = 'tecnofit-avaliation';
    private $dbPassword = 'tecnofit-avaliation';
    private $dbName = 'tecnofit-avaliation';
    public $connection;

   

    public function connect(){        
        $this->connection = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);

        $this->create_tables();
        
        if( mysqli_connect_errno() ) {
            $error = [
                "error" => [
                    'message' => 'database error connect',
                    'mysql error number'   => mysqli_connect_errno()                    
                ]
            ];
            $this->close_connection();
            die(json_encode($error));
        }        
        
    }

    public function create_tables(){

    }
    
    public function get_array_of_errors_mysqli($message, array $args = []){
        $error = ['error' => [
                'message' => $message
            ]
        ];
        
        foreach ($args as $key => $value) {
            $error['error'][$key] = $value;    
        }        

        return $error;
    }

    public function close_connection(){
        mysqli_close($this->connection);
    }
}