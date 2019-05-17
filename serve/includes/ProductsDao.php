<?php
/**
 *  File to handle the Mysql Requests
 */
namespace Includes;

class ProductsDao
{
    public function get_all_products(){
        
        $slq = "SELECT * FROM products";
        $response = [];
            
        $db = new Database();            

        $db->connect();            
        $stmt = mysqli_query($db->connection, $slq);            
        // check error
        
        if (mysqli_num_rows($stmt) > 0) {
            while($row = mysqli_fetch_assoc($stmt)) {
                $response[] =$row;
            }
        }
        
        if($stmt->error){
            $response = $db->get_array_of_errors_mysqli($stmt->error);
        }

        $db->close_connection();
        $db = null;

        return $response;        
    }

    public function get_product_by_id( int $id ){

        $slq = "SELECT * FROM products WHERE id = $id";

        $response = [];

        
            // Get database
            $db = new Database();            

            $db->connect();            
            $stmt = mysqli_query($db->connection, $slq);            
            
            if (mysqli_num_rows($stmt) > 0) {
                while($row = mysqli_fetch_assoc($stmt)) {
                   $response[] =$row;
                }
            }
            
            if($stmt->errno){
                $response = $db->get_array_of_errors_mysqli($stmt->error);
            }

            $db->close_connection();
            $db = null;

            return $response;        
    }

    public function add_new_product(array $args){
        
        $slq = "INSERT INTO products (name, description, sku, price) VALUES (? , ?, ?, ?)";

        
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

    public function update_product(array $args){
        $slq = "UPDATE products SET name = ?, description = ?, sku = ?, price = ? WHERE id = ?";
        $response = ['notice' => ['text' => "product updated"]];

        
        // Get database
        $db = new Database();            

        $db->connect();            
        $stmt = $db->connection->prepare($slq);
        $stmt->bind_param('sssss', $args['name'], $args['description'], $args['sku'], $args['price'], $args['id'] );
        $stmt->execute();
        
        if($stmt->errno){
            $response = $db->get_array_of_errors_mysqli($stmt->error);
        }

        $stmt->close();
        $db->close_connection();
        $db = null;

        return $response;

    }

    public function delete_product(int $id){

        $slq = "DELETE FROM products WHERE id = ?";        

        try {
            
            $db = new Database();            

            $db->connect();            
            $stmt = $db->connection->prepare($slq);
            $stmt->bind_param('s', $id );
            $stmt->execute();
            $stmt->close();
            $db->close_connection();
            $db = null;

            return ['notice' => ['text' => 'product deleted']];

        } catch( \Exception $error){
            $message = [
                'error' => [
                    'text' => $error->getMessage()
                ]
            ];
            
            return $message;
        }
    }
}