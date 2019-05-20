<?php
/**
 *  File to handle the Mysql Requests
 */
namespace Includes;

class OrdersDao
{
    public function get_all_orders(){
        
        $slq = "SELECT * FROM orders";
        $response = [];
            
        $db = new Database();            

        $db->connect();            
        $stmt = mysqli_query($db->connection, $slq);            
        // check error
        
        if(!$stmt){
            $error = ['function' => 'get all orders'];
            $response = $db->get_array_of_errors_mysqli(mysqli_error($db->connection), $error);
        }else if (mysqli_num_rows($stmt) > 0) {
            $i = 0;
            while($row = mysqli_fetch_assoc($stmt)) {
                $response[$i] = $row;
                $response[$i]['products'] = $this->get_all_products_orders_by_id($response[$i]['id']);
                $i++;
            }
        }
        

        $db->close_connection();
        $db = null;        
        return $response;       
    }

    public function get_all_products_orders_by_id(int $id){
        
        $slq = "SELECT * FROM orders_products WHERE order_id = $id";
        $response = [];
            
        $db = new Database();            

        $db->connect();            
        $stmt = mysqli_query($db->connection, $slq);            
        // check error
        
        if(!$stmt){
            $error = ['function' => 'get all products order'];
            $response = $db->get_array_of_errors_mysqli(mysqli_error($db->connection), $error);
        }else if (mysqli_num_rows($stmt) > 0) {
            while($row = mysqli_fetch_assoc($stmt)) {
                $response[] = $row;
            }
        }
        

        $db->close_connection();
        $db = null;        

        return $response; 
    }

    public function get_order_by_id(int $id){
        
        $slq = "SELECT * FROM orders WHERE id = $id";
        $response = [];
            
        $db = new Database();            

        $db->connect();            
        $stmt = mysqli_query($db->connection, $slq);            
        // check error
        
        if(!$stmt){
            $error = ['function' => 'get order by id'];
            $response = $db->get_array_of_errors_mysqli(mysqli_error($db->connection), $error);
        }else if (mysqli_num_rows($stmt) > 0) {            
            $i = 0;
            while($row = mysqli_fetch_assoc($stmt)) {
                $response[$i] = $row;
                $response[$i]['products'] = $this->get_all_products_orders_by_id($response[$i]['id']);
                $i++;
            }
        }        
        

        $db->close_connection();
        $db = null;        
        return $response;   
    }
    public function add_new_order(array $args){
        $slq = "INSERT INTO orders (total, date) VALUES (? , ?)";        
        
        // Get database
        $db = new Database();            

        $db->connect();            
        $stmt = $db->connection->prepare($slq);
        $stmt->bind_param('ssss', $args['name'], $args['description'], $args['sku'], $args['price'] );
        $stmt->execute();
        
        $message = [
            'request' => [
                'status'    => 'success',
                'message' => 'product added'
            ]
        ];
        
        // check error
        if($stmt->errno){
            $message = $db->get_array_of_errors_mysqli($stmt->error);
        }         
        
        $stmt->close();
        $db->close_connection();
        $db = null;

        return $message;
    }
}
