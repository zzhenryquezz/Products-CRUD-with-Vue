<?php

namespace Api\Routes;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Orders
{
    public $app;
    private $ordersDao;
        
    public function __construct( \Slim\App $app){
        
        $this->app = $app;
        
        $this->ordersDao = new \Includes\OrdersDao();

        $this->register_routes();         
    }
    
    public function register_routes(){
        $this->app->get('/orders', [$this, 'get_all_orders']);        
        $this->app->get('/orders/{id}', [$this, 'get_order_by_id']);        
        $this->app->get('/orders/{id}/products', [$this, 'get_all_products_orders_by_id']);        
        $this->app->post('/orders/add', [$this, 'add_order']);       
        $this->app->put('/orders/update/{id}', [$this, 'update_order']);       
        $this->app->delete('/orders/delete/{id}', [$this, 'delete_order']);       
    }

    public function get_all_orders(Request $request, Response $response, array $args){
        
        $orders = $this->ordersDao->get_all_orders();

        echo json_encode($orders);
        
    }

    public function get_order_by_id(Request $request, Response $response, array $args){
        
        $id = $request->getAttribute('id');

        $order = $this->ordersDao->get_order_by_id($id);

        echo json_encode($order);
    }
    
    public function get_all_products_orders_by_id(Request $request, Response $response, array $args){
        
        $id = $request->getAttribute('id');

        $order = $this->ordersDao->get_all_products_orders_by_id($id);

        echo json_encode($order);
    }

    
    public function add_order(Request $request, Response $response, array $args){
        $orderData = [
            'total'         => $request->getParam('total'),
            'date'          => $request->getParam('date'),
            'products'      => $request->getParam('products'),
        ];

        $response = $this->ordersDao->add_new_order($orderData);

        echo json_encode($response);
        
    }
    public function update_order(Request $request, Response $response, array $args){
        
        $orderData = [
            'id'            => $request->getAttribute('id'),
            'date'         => $request->getParam('date'),
            'total'         => $request->getParam('total'),
            'products'      => $request->getParam('products')            
        ];
        
        $response = $this->ordersDao->update_order($orderData);

        echo json_encode($response);
    }
    
    public function delete_order(Request $request, Response $response, array $args){
        
        $id = $request->getAttribute('id');

        $response = $this->ordersDao->delete_order($id);

        echo json_encode($response);
        
    }
}