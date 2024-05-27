<?php


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

    public static function Orders(int $user_id)
    {
        /**
         * @todo fetch all orders belonging to the user
         * @body Fetch all orders belonging to the user
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "orders",
                where: [
                    "owner_id" => $user_id
                ]
            );
            return $data;
         }
    }

    public static function Sales(int $user_id)
    {
        /**
         * @todo fetch all sales belonging to the user
         * @body Fetch all sales belonging to the user
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "sales",
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

    public static function Revenue(int $user_id)
    {
        /**
         * @todo Fetch the revenue of the user
         * @body Fetch the revenue of the user
         * @param int $user_id Id of the user
         * @return int
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "sales",
                where: [
                    "user_id" => $user_id
                ]
            );
            $revenue = 0;
            foreach ($data as $sale)
            {
                $revenue += ($sale->item_count * Products::Get($sale->product_id)->price);
            }
            return $revenue;
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
                /** Delete Orders and Sales */
                Model::Delete(
                    table: "orders",
                    param_t: "product_id",
                    param_n: $product_id
                );
                Model::Delete(
                    table: "sales",
                    param_t: "product_id",
                    param_n: $product_id
                );
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

    public static function GetId($product_name)
    {
        /**
         * @todo Fetch the id of the product
         * @body Fetch the id of the product
         * @param mixed $product_name Name of the product
         * @return int
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "products",
                where: [
                    "name" => $product_name
                ],
                limit: 1
            );
            $data = $data[0];
            return $data->id;
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

Class Orders
{
    public static function Create(int $product_id, int $owner_id, int $count, string $customer, string $phone, string $location, string $due_date)
    {
        /**
         * @todo Create a new order
         * @body Create a new order
         * @param int $product_id Id of the product
         * @param int $owner_id Id of the owner
         * @param int $count Number of the product
         * @param string $customer Name of the customer
         * @param string $phone Phone number of the customer
         * @param string $location Location of the customer
         * @param string $due_date Due date of the order
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Insert(
                table: "orders",
                data: [
                    "product_id" => $product_id,
                    "owner_id" => $owner_id,
                    "item_count" => $count,
                    "customer_name" => $customer,
                    "customer_phone" => $phone,
                    "location" => $location,
                    "due_date" => $due_date
                ]
            ));
         }
    }

    public static function Update(int $order_id,int $product_id, int $count, string $customer, string $phone, string $location, string $due_date)
    {
        /**
         * @todo Update the order
         * @body Update the order
         * @param int $order_id Id of the order
         * @param int $count Number of the product
         * @param string $customer Name of the customer
         * @param string $phone Phone number of the customer
         * @param string $location Location of the customer
         * @param string $due_date Due date of the order
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Update(
                table: "orders",
                data: [
                    "product_id" => $product_id,
                    "item_count" => $count,
                    "customer_name" => $customer,
                    "customer_phone" => $phone,
                    "location" => $location,
                    "due_date" => $due_date
                ],
                param_t: "id",
                param_n: $order_id
            ));
         }
    }

    public static function Get(int $order_id)
    {
        /**
         * @todo Fetch the data of the order
         * @body Fetch the data of the order
         * @param int $order_id Id of the order
         * @return object
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "orders",
                where: [
                    "id" => $order_id
                ],
                limit: 1
            );
            $data = $data[0];
            return $data;
         }
    }

    public static function Delete(int $order_id)
    {
        /**
         * @todo Delete the order
         * @body Delete the order
         * @param int $order_id Id of the order
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Delete(
                table: "orders",
                param_t: "id",
                param_n: $order_id
            ));
         }
    }

    public static function All()
    {
        /**
         * @todo Fetch all orders
         * @body Fetch all orders
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "orders"
            );
            return $data;
         }
    }
}

class Sales
{
    public static function Create( int $user_id, int $product_id, int $item_count, mixed $customer_name, mixed $payment_method, mixed $payment_code, $date)
    {
        /**
         * @todo Create a new sale
         * @body Create a new sale
         * @param int $product_id Id of the product
         * @param int $item_count Number of the product
         * @param mixed $customer_name Name of the customer
         * @param mixed $payment_method Payment method of the customer
         * @param mixed $payment_code Payment code of the customer
         * @param mixed $date Date of the sale
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Insert(
                table: "sales",
                data: [
                    "user_id" => $user_id,
                    "product_id" => $product_id,
                    "item_count" => $item_count,
                    "customer_name" => $customer_name,
                    "payment_method" => $payment_method,
                    "payment_code" => $payment_code,
                    "date" => $date
                ]
            ));
         }
    }

    public static function Update(int $sale_id, int $product_id, int $item_count, mixed $customer_name, mixed $payment_method, mixed $payment_code, $date)
    {
        /**
         * @todo Update the sale
         * @body Update the sale
         * @param int $sale_id Id of the sale
         * @param int $product_id Id of the product
         * @param int $item_count Number of the product
         * @param mixed $customer_name Name of the customer
         * @param mixed $payment_method Payment method of the customer
         * @param mixed $payment_code Payment code of the customer
         * @param mixed $date Date of the sale
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Update(
                table: "sales",
                data: [
                    "product_id" => $product_id,
                    "item_count" => $item_count,
                    "customer_name" => $customer_name,
                    "payment_method" => $payment_method,
                    "payment_code" => $payment_code,
                    "date" => $date
                ],
                param_t: "id",
                param_n: $sale_id
            ));
         }
    }

    public static function Get(int $sale_id)
    {
        /**
         * @todo Fetch the data of the sale
         * @body Fetch the data of the sale
         * @param int $sale_id Id of the sale
         * @return object
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "sales",
                where: [
                    "id" => $sale_id
                ],
                limit: 1
            );
            $data = $data[0];
            return $data;
         }
    }

    public static function Delete(int $sale_id)
    {
        /**
         * @todo Delete the sale
         * @body Delete the sale
         * @param int $sale_id Id of the sale
         * @return bool
         */

         if (Model::Connected())
         {
            return (Model::Delete(
                table: "sales",
                param_t: "id",
                param_n: $sale_id
            ));
         }
    }

    public static function All()
    {
        /**
         * @todo Fetch all sales
         * @body Fetch all sales
         * @return array of objects
         */

         if (Model::Connected())
         {
            $data = Model::All(
                table: "sales"
            );
            return $data;
         }
    }
}