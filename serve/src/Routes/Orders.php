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
        $this->app->get('/api/orders', [$this, 'get_all_orders']);        
        $this->app->get('/api/orders/{id}', [$this, 'get_order_by_id']);        
        $this->app->post('/api/orders/add', [$this, 'add_order']);        
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
    
    public function add_order(Request $request, Response $response, array $args){
        $orderData = [
            'total'     => $request->getParam('total'),
            'date'      => $request->getParam('date'),
            'products'   => $request->getParam('products'),
        ];

        $response = $this->ordersDao->add_new_order($orderData);

        echo json_encode($response);
        
    }
}