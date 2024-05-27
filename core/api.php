<?php

use PixelSequel\Model\Model;

ini_set('display_errors', 'On');
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, api_key");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Api
{
    private static $api_key;

    public static function validate_request()
    {
        $headers = getallheaders();
        if (isset($headers['api_key']))
        {
            $api_key = $headers['api_key'];
            if (self::api_key_exists($api_key))
            {
                self::$api_key = $api_key;
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    public static function api_key_exists($api_key)
    {
        $keys = Model::All(
            table: "api_keys",
            where: [
                "api_key" => $api_key
            ],
            limit: 1,
        );

        if (count( $keys ) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function Get()
    {

        /**
         * Handle GET requests
         * API Keys are required for this request
         * ?products
         * ?products&id=1
         * ?orders
         * ?orders&id=1
         * ?sales
         * ?sales&id=1
         * ?categories
        */


        if (self::validate_request())
        {
            if (isset($_GET['products']))
            {
                if (isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $products = Model::All(
                        table: "products",
                        where: [
                            "id" => $id
                        ],
                        limit: 1,
                    );
                    echo json_encode($products[0]);
                }
                else
                {
                    $products = Model::All(
                        table: "products",
                    );
                    echo json_encode($products);
                }
            }
            elseif (isset($_GET['orders']))
            {
                if (isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $orders = Model::All(
                        table: "orders",
                        where: [
                            "id" => $id
                        ],
                        limit: 1,
                    );
                    echo json_encode($orders[0]);
                }
                else
                {
                    $orders = Model::All(
                        table: "orders",
                    );
                    echo json_encode($orders);
                }
            }
            elseif (isset($_GET['sales']))
            {
                if (isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $sales = Model::All(
                        table: "sales",
                        where: [
                            "id" => $id
                        ],
                        limit: 1,
                    );
                    echo json_encode($sales[0]);
                }
                else
                {
                    $sales = Model::All(
                        table: "sales",
                    );
                    echo json_encode($sales);
                }
            }
            else if (isset($_GET['categories']))
            {
                if (isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    $categories = Model::All(
                        table: "categories",
                        where: [
                            "id" => $id
                        ],
                        limit: 1,
                    );
                    echo json_encode($categories[0]);
                }
                else
                {
                    $categories = Model::All(
                        table: "categories",
                    );
                    echo json_encode($categories);
                }
            }
            else
            {
                echo json_encode([
                    "error" => "Invalid request"
                ]);
            }
        }
        else
        {
            echo json_encode([
                "error" => "Invalid API Key"
            ]);
        }
    }

    public static function Post()
    {
        /**
         * Handle POST requests
         * API Keys are required for this request
         * ?products
         * ?orders
         * ?sales
         * ?categories
        */

        if (self::validate_request())
        {
            if (isset($_GET['products']))
            {
                $data = json_decode(file_get_contents('php://input'), true);
                $products = Model::Insert (
                    table: "products",
                    data: $data
                );
                echo json_encode($products);
            }
            elseif (isset($_GET['orders']))
            {
                $data = json_decode(file_get_contents('php://input'), true);
                $orders = Model::Insert (
                    table: "orders",
                    data: $data
                );
                echo json_encode($orders);
            }
            elseif (isset($_GET['sales']))
            {
                $data = json_decode(file_get_contents('php://input'), true);
                $sales = Model::Insert (
                    table: "sales",
                    data: $data
                );
                echo json_encode($sales);
            }
            elseif (isset($_GET['categories']))
            {
                $data = json_decode(file_get_contents('php://input'), true);
                $categories = Model::Insert (
                    table: "categories",
                    data: $data
                );
                echo json_encode($categories);
            }
            else
            {
                echo json_encode([
                    "error" => "Invalid request"
                ]);
            }
        }
        else
        {
            echo json_encode([
                "error" => "Invalid API Key"
            ]);
        }
    }
}