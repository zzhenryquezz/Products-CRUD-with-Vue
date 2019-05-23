<?php

namespace Api\Routes;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Products
{
    public $app;
    private $productsDao;
        
    public function __construct(\Slim\App $app){
        
        $this->app = $app;
        
        $this->productsDao = new \Includes\ProductsDao();

        $this->register_routes();         
    }
    
    public function register_routes(){
        $this->app->get('/products', [$this, 'get_all_products']);
        $this->app->get('/products/{id}', [$this, 'get_product_by_id']);
        $this->app->post('/products/add', [$this, 'add_product']);
        $this->app->put('/products/update/{id}', [$this, 'update_product']);
        $this->app->delete('/products/delete/{id}', [$this, 'delete_product']);
    }

    public function get_all_products(Request $request, Response $response, array $args){
        
        $products = $this->productsDao->get_all_products();
        
        echo json_encode($products);
        
    }

    public function get_product_by_id(Request $request, Response $response, array $args){
        
        $id = $request->getAttribute('id');
        
        $product = $this->productsDao->get_product_by_id($id);

        echo json_encode($product);
        
    }
    
    public function add_product(Request $request, Response $response, array $args){
        $productData = [
            'name'          => $request->getParam('name'),
            'description'   => $request->getParam('description'),
            'sku'           => $request->getParam('sku'),
            'price'         => $request->getParam('price'),
        ];

        $response = $this->productsDao->add_new_product($productData);

        echo json_encode($response);
        
    }
    
    public function update_product(Request $request, Response $response, array $args){
        $productData = [
            'id' => $request->getAttribute('id'),
            'name'          => $request->getParam('name'),
            'description'   => $request->getParam('description'),
            'sku'           => $request->getParam('sku'),
            'price'         => $request->getParam('price'),
        ];
        
        $response = $this->productsDao->update_product($productData);

        echo json_encode($response);
        
    }
    
    public function delete_product(Request $request, Response $response, array $args){
        
        $id = $request->getAttribute('id');

        $response = $this->productsDao->delete_product($id);

        echo json_encode($response);
        
    }

}