<?php
/**
 *  File to handle the Mysql Requests
 */
namespace Includes;

class OrdersDao
{
    public $orderProductsDao;
    
    public function __construct(){
        $this->orderProductsDao = new OrderProductsDao();
    }
    
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
        $stmt->bind_param('ss', $args['total'], $args['date']);
        $stmt->execute();
        
        $request = true;
        foreach ($args['products'] as $product) {
            $request = $this->orderProductsDao->add_product_in_order($db->connection->insert_id, $product);
            if(!$request){
                return ['error in add products'];
            }
        }
        $message = [
            'request' => [
                'status'    => 'success',
                'message' => 'oder added'
            ]
        ];
        
        // check error
        if(!$stmt){
            return get_array_of_errors_mysqli(mysqli_error($db->connection));
        }         
        
        $stmt->close();
        $db->close_connection();
        $db = null;

        return $message;
    }

    public function update_order(array $args){
        
        $slq = "UPDATE orders SET total = ? WHERE id = ?";
        $response = ['notice' => ['text' => "order updated"]];        
        // Get database
        $db = new Database();            

        $db->connect();            
        $stmt = $db->connection->prepare($slq);
        $stmt->bind_param('ss', $args['total'], $args['id']);
        $stmt->execute();

        $request = $this->orderProductsDao->replace_all_products_in_order($args['id'], $args['products']);
        if(!$request){
            return get_array_of_errors_mysqli('error in replace products');
        }
        
        if(!$stmt){
            return get_array_of_errors_mysqli(mysqli_error($db->connection));
        }

        $stmt->close();
        $db->close_connection();
        $db = null;

        return $response;

    }
    
    public function delete_order(int $id){

        $slq = "DELETE FROM orders WHERE id = ?";        

        $db = new Database();            

        $db->connect();            
        $stmt = $db->connection->prepare($slq);
        $stmt->bind_param('s', $id );
        $stmt->execute();

        if(!$stmt){
            return get_array_of_errors_mysqli(mysqli_error($db->connection));
        }
        
        $stmt->close();
        $db->close_connection();
        $db = null;

        return ['notice' => ['text' => 'order deleted']];
        
    }
    
}
