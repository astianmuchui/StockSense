<?php

require "../vendor/autoload.php";
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
}
