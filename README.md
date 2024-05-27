# Stocksense
An Inventory Management system that you can easily use for your store

Written at ```ALX``` by ```Sebastian Muchui```

# Requirements
## XAMPP / LAMPP
To run this project you need xampp installed on your machine.
Xampp comes with apache and mysql which we need for this project.

You can download xampp from
```
    https://apachefriends.org
```

### Windows Installation
To install xampp on windows, you simply need to run the executable file and follow the instructions.

### Linux
Installing xampp on linux is as follows

. First enable 32-bit compatibility (You may not need this on debian based distros)
To do this, you need to install ```libxcypt-compat``` For instance, on arch

```sh
    sudo pacman -S libxcrypt-compat
```

Once that is done, navigate to the location of the ```.run``` file you just downloaded and give user permissions

```sh
    ~/Downloads/$ sudo chmod a+rwx xampp*
```
Using ```xampp*``` as download versions may be different.

Now execute the file
```sh
    sudo ./xampp*
```

You should see a GUI prompt, and in a few minutes the installation is done.

. To run the server on Linux
```sh
sudo /opt/lampp/lampp start
```
By default, apache runs on port ```80``` and mysql runs on ```3306```

. To run the server on windows simply open the GUI interface
It is also possible to run it from the commandline

# Usage
First, you need to clone the repository into the xampp htdocs directory
Now, this might vary based on the system you are using.

```
    Windows: C:\XAMPP\htdocs
    Linux: /opt/lampp/htdocs
```
To clone the code in the main branch:

```sh
    git clone -b main https://github.com/astianmuchui/StockSense.git
```
Now start your server

Once that is done, navigate to ```http://localhost/phpmyadmin``` and create a new database called ```stocksense```


You can now import an sql file located at ```core/stocksense.sql``` in order to have the whole structure

. Now Open ```https://localhost/stocksense```

## Composer Package
This project uses ```PixelSequel``` More on that on <a href="https://astianmuchui.tech/PixelSequel/home/"> https://astianmuchui.tech/PixelSequel/home/ </a>

To Install it:
```sh
    echo "echo ' { "minimum-stability" : "dev" } ' > composer.json"
    composer require astianmuchui/pixelsequel
```

