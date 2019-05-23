<?php
/**
 *  File to handle the Mysql Requests
 */
namespace Includes;

class OrderProductsDao
{
    public function add_product_in_order(int $id, array $product){
        $slq = "INSERT INTO orders_products (order_id, product_id) VALUES (? , ?)";        
        $response = true;
        
        // Get database        
        $db = new Database();            

        $db->connect();        
        $stmt = $db->connection->prepare($slq);
        $stmt->bind_param('ss', $id, $product['id']);
        $stmt->execute();
        
        
        // check error
        if($stmt->errno){
            $response = false;
        }         
        
        $stmt->close();
        $db->close_connection();
        $db = null;

        return $response;
    }

    public function replace_all_products_in_order(int $order_id, array $products){
        $slq = "DELETE FROM orders_products WHERE order_id = ?";        
        $response = true;
        
        // Get database        
        $db = new Database();            
        
        // delete all products in table
        $db->connect();        
        $stmt = $db->connection->prepare($slq);
        $stmt->bind_param('s', $order_id);
        $stmt->execute();
        
        if($stmt->errno){
            $response = false;
        }         
        
        $stmt->close();
        $db->close_connection();
        $db = null;

        // insert the new array of products
        foreach ($products as $product) {
            $request = $this->add_product_in_order($order_id, $product);
            if(!$request){
                $response = false;
            }
        }

        return $response;
    }
}