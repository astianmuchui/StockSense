<?php

use PixelSequel\Model\Model;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();

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

            $api_key = password_hash(bin2hex(random_bytes(32)), PASSWORD_BCRYPT);
            $api_key = str_replace("/", "", $api_key);
            $api_key = str_replace("+", "", $api_key);
            $api_key = str_replace("$", "", $api_key);
            $api_key = substr($api_key, 0, 20);


            return (Model::Insert(
                table: "api_keys",
                data: [
                    "user_id" => $user_id,
                    "api_key" => $api_key
                ]
            ));
         }
    }
}
