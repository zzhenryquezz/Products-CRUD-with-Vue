<?php
/**
 *  File to database conection
*/
namespace Includes;

class Database
{
    private $dbHost = 'localhost';
    private $dbUser = 'Database_teste';
    private $dbPassword = 'Database_teste';
    private $dbName = 'Database_teste';
    public $connection;



    public function connect(){
        $this->connection = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);


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

        $this->create_tables();
    }

    public function create_tables(){
        // name, description, sku, price
        $sql_querys[0] = 'CREATE TABLE IF NOT EXISTS products (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            description TEXT NOT NULL,
            sku INT(11) NOT NULL,
            price DECIMAL(15,2)
        );';

        $sql_querys[1] = 'CREATE TABLE IF NOT EXISTS orders (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            total DECIMAL(15,2) NOT NULL,
            date  DATETIME NOT NULL
        );';

        $sql_querys[2] = 'CREATE TABLE IF NOT EXISTS orders_products (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            order_id INT(11) NOT NULL,
            product_id Int(11)
        );';

        foreach ($sql_querys as $sql) {
            $stmt = mysqli_query( $this->connection, $sql);
        }


        if(!$stmt){
            $error = [
                "error" => [
                    'message' => 'database error create tables',
                    'mysql error'   => mysqli_error($this->connection)
                    ]
            ];

            $this->close_connection();
            die(json_encode($error));
        }


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
