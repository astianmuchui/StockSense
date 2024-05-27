<?php

require "/opt/lampp/htdocs/stocksense/vendor/autoload.php";

use PixelSequel\Model\Model;
session_start();


ini_set('display_errors', 'On');
error_reporting(E_ALL);

interface MediaHandler
{
    public static function Upload ( $file, string $folder="", $tmp="",array $formats=[]);
    public static function Delete ( string $file);
}

final class FileHandler implements MediaHandler
{

    public function __construct()
    {

    }
    public static function Upload ( $file, string $folder="", $tmp="",array $formats=[])
    {

        $filename = basename($file);
        $path = $folder.$filename;
        $extension = pathinfo($path,PATHINFO_EXTENSION);

        if (gettype($formats) == "array")
        {
            if (in_array($extension,$formats))
            {
                if (move_uploaded_file($tmp,$path))
                {
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
        else
        {
            return false;
        }
    }

    public static function Delete ( string $file) : bool
    {
        if (file_exists($file))
        {
            if (unlink($file))
            {
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
}


new Model (
    dbname:"stocksense",
    username:"root",
    password:"",
    dbhost:"localhost"
);

interface Users
{
    public static function Create(string $name, string $email, string $phone,string $password);
    public static function Authenticate(string $email, string $password);
    public static function Exists($email): bool;
    public static function Products(int $user_id);
    public static function IsAuthenticated(): bool;
    public static function ApiKey(int $user_id);
    public static function GenerateApiKey(int $user_id);
    public static function HasApiKey(int $user_id);

    public static function Data();

    public static function Update(int $user_id, string $name, string $email, string $phone);

}

class User implements Users
{
    public function __construct()
    {

    }

    public static function Exists($email): bool
    {
        $data = Model::All(
            table: "users",
            where: [
                "email" => $email
            ]
        );

        if (count($data) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public static function Create(string $name, string $email, string $phone,string $password)
    {
        /**
         * @todo Implement Create() method
         * @body Implement the Create() method to create a new user
         * @param string $name Name of the user
         * @param string $email Email of the user
         * @param string $phone Phone number of the user
         * @param string $password Password of the user, To be hashed
         * @return bool True if user is created successfully, False otherwise
         */
        $error = "";

         if (Model::Connected())
         {
            if (!self::Exists($email))
            {
                return (Model::Insert(
                    table: "users",
                    data: [
                        "name"=> $name,
                        "email"=> $email,
                        "phone"=> $phone,
                        "password"=> password_hash($password, PASSWORD_BCRYPT)
                    ]
                ));
            }
            else
            {
                $error = "User already exists";
                return $error;
            }
         }
    }

    public static function Authenticate(string $email, string $password)
    {
        /**
         * @todo Logs in the user
         * @body Authenticate the user
         * @param string $email Email of the user
         * @param string $password Password of the user to be hash matched
         */

         if (Model::Connected())
         {

            $data = Model::All(
                table: "users",
                where: [
                    "email" => $email
                ],
                limit: 1
            );
            $data = $data[0];
            if (password_verify($password, $data->password))
            {
                $_SESSION['user_id'] = $data->id;
                return true;
            }
            else
            {
                return false;
            }
         }
    }

    public static function Products(int $user_id)
    {
        /**
         * @todo fetch all products belonging to the user
         * @body Fetch all products belonging to the user
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "products",
                where: [
                    "user_id" => $user_id
                ]
            );
            return $data;
         }
    }

    public static function IsAuthenticated(): bool
    {
        if (isset($_SESSION['user_id']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function HasApiKey(int $user_id)
    {
        /**
         * @todo Check if the user has an api key
         * @body Check if the user has an api key
         * @return bool
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "api_keys",
                where: [
                    "user_id" => $user_id
                ],
                limit: 1
            );
            if (count($data) > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
         }
    }

    public static function ApiKey(int $user_id)
    {
        /**
         * @todo fetch the api key of the user
         * @body Fetch the api key of the user
         * @return string
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "api_keys",
                where: [
                    "user_id" => $user_id
                ],
                limit: 1
            );
            $data = $data[0];
            return $data->api_key;
         }
    }

    public static function DeleteApiKeys(int $user_id)
    {
        /**
         * @todo Delete all api keys of the user
         * @body Delete all api keys of the user
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Delete(
                table: "api_keys",
                param_t: "user_id",
                param_n: $user_id
            ));
         }
    }

    public static function GenerateApiKey(int $user_id)
    {
        /**
         * @todo Generate a new api key for the user
         * @body Generate a new api key for the user
         * @return string
         */

         if (Model::Connected())
         {
            if (self::HasApiKey($user_id))
            {
                self::DeleteApiKeys($user_id);
            }

            $api_key = password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT);
            $api_key = str_replace("/", "", $api_key);
            $api_key = str_replace("+", "", $api_key);
            $api_key = str_replace("$", "", $api_key);
            $api_key = str_replace("[", "", $api_key);
            $api_key = str_replace("]", "", $api_key);
            $api_key = str_replace("{", "", $api_key);
            $api_key = str_replace("}", "", $api_key);
            $api_key = str_replace("(", "", $api_key);
            $api_key = str_replace("2", "", $api_key);
            $api_key = substr($api_key, rand(1, 5), rand(10, strlen($api_key)));


            return (Model::Insert(
                table: "api_keys",
                data: [
                    "user_id" => $user_id,
                    "api_key" => $api_key
                ]
            ));
         }
    }

    public static function Data()
    {
        /**
         * @todo Fetch the data of the user
         * @body Fetch the data of the user
         * @return object
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "users",
                where: [
                    "id" => $_SESSION['user_id']
                ],
                limit: 1
            );
            $data = $data[0];
            return $data;
         }
    }

    public static function Update(int $user_id, string $name, string $email, string $phone)
    {
        /**
         * @todo Update the user's data
         * @body Update the user's data
         * @param int $user_id Id of the user
         * @param string $name Name of the user
         * @param string $email Email of the user
         * @param string $phone Phone number of the user
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Update(
                table: "users",
                data: [
                    "name" => $name,
                    "email" => $email,
                    "phone" => $phone
                ],
                param_t: "id",
                param_n: $user_id
            ));
         }
    }
}

interface StockInterface
{
    public static function Create(int $user_id, mixed $product_name,mixed $image_path, mixed $tmp, int $price, int $count, int $category);
}

class Products implements StockInterface
{
    public function __construct()
    {

    }

    public static function Get(int $product_id)
    {
        /**
         * @todo Fetch the data of the product
         * @body Fetch the data of the product
         * @param int $product_id Id of the product
         * @return object
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "products",
                where: [
                    "id" => $product_id
                ],
                limit: 1
            );
            $data = $data[0];
            return $data;
         }
    }

    public static function Create(int $user_id, mixed $product_name,mixed $image_path, mixed $tmp, int $price, int $count, int $category)
    {
        /**
         * @todo Create a new product
         * @body Create a new product
         * @param int $user_id Id of the user
         * @param mixed $product_name Name of the product
         * @param int $price Price of the product
         * @param int $count Number of the product
         * @param int $category Category of the product
         * @param mixed $description Description of the product
         * @return bool
         */

         if (Model::Connected())
         {
            FileHandler::Upload($image_path, "../../assets/uploads/", $tmp, ["jpg","jpeg","png","gif"]);

            return (Model::Insert (
                table: "products",
                data: [
                    "user_id" => $user_id,
                    "name" => $product_name,
                    "image_path" => $image_path,
                    "price" => $price,
                    "count" => $count,
                    "category" => $category
                ]
            ));

        }
    }

    public static function GetOrders(int $product_id)
    {
        /**
         * @todo Fetch all orders of the product
         * @body Fetch all orders of the product
         * @param int $product_id Id of the product
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "orders",
                where: [
                    "product_id" => $product_id
                ]
            );
            return $data;
         }
    }

    public static function Delete(int $product_id)
    {
        /**
         * @todo Delete the product
         * @body Delete the product
         * @param int $product_id Id of the product
         * @return bool
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "products",
                where: [
                    "id" => $product_id
                ],
                limit: 1
            );
            $data = $data[0];
            if (Model::Delete (
                table: "products",
                param_t: "id",
                param_n: $product_id
            ))
            {
                FileHandler::Delete("../../assets/uploads/".$data->image_path);
                return true;
            }
            else
            {
                return false;
            }
         }
    }

    public static function GetSales(int $product_id)
    {
        /**
         * @todo Fetch all sales of the product
         * @body Fetch all sales of the product
         * @param int $product_id Id of the product
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "sales",
                where: [
                    "product_id" => $product_id
                ]
            );
            return $data;
         }
    }

    public static function GetAvailable(int $product_id)
    {
        /**
         * @todo Fetch the available number of the product
         * @body Fetch the available number of the product
         * @param int $product_id Id of the product
         * @return int
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "products",
                where: [
                    "id" => $product_id
                ],
                limit: 1
            );
            $data = $data[0];
            return $data->count;
         }

    }

    public static function Update(int $product_id, mixed $product_name, mixed $image_path=NULL, mixed $tmp=NULL, int $price, int $count, int $category)
    {
        /**
         * @todo Update the product
         * @body Update the product
         * @param int $product_id Id of the product
         * @param mixed $product_name Name of the product
         * @param mixed $image_path Image of the product
         * @param int $price Price of the product
         * @param int $count Number of the product
         * @param int $category Category of the product
         * @param mixed $description Description of the product
         * @return bool
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "products",
                where: [
                    "id" => $product_id
                ],
                limit: 1
            );
            $data = $data[0];

            if ($image_path == NULL && $tmp == NULL)
            {
                return Model::Update(
                    table: "products",
                    data: [
                        "name" => $product_name,
                        "price" => $price,
                        "count" => $count,
                        "category" => $category
                    ],
                    param_t: "id",
                    param_n: $product_id
                );
            }
            else
            {
                if (FileHandler::Upload($image_path, "../../assets/uploads/", $tmp, ["jpg","jpeg","png","gif"]))
                {
                    return Model::Update(
                        table: "products",
                        data: [
                            "name" => $product_name,
                            "image_path" => $image_path,
                            "price" => $price,
                            "count" => $count,
                            "category" => $category
                        ],
                        param_t: "id",
                        param_n: $product_id
                    );
                }

            }
        }
    }

}

class Categories
{

    public static function Get(int $category_id)
    {
        /**
         * @todo Fetch the data of the category
         * @body Fetch the data of the category
         * @param int $category_id Id of the category
         * @return object
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "categories",
                where: [
                    "id" => $category_id
                ],
                limit: 1
            );
            $data = $data[0];
            return $data;
         }
    }
    public static function All()
    {
        /**
         * @todo Fetch all categories
         * @body Fetch all categories
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "categories"
            );
            return $data;
         }
    }

    public static function Create(mixed $category_name, mixed $image, mixed $tmp)
    {
        /**
        * @todo Create a new category
        * @body Create a new category
        * @param mixed $category_name Name of the category
        * @param mixed $image Image of the category
        */

         if (FileHandler::Upload($image,"../../assets/uploads/", $tmp, ["jpg","jpeg","png","gif"]))
         {
            if (Model::Connected())
            {
                return (Model::Insert(
                    table: "categories",
                    data: [
                        "name" => $category_name,
                        "image" => $image
                    ]
                ));
            }
        }
    }

}