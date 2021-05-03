# gamingWebStore

Video games Web Store with database and full admin/user functionality by using advanced MVC structure. This is v1.00, more updates will be implemented in the future.

Admin login information:

    Email: admin@mail.com 
    Password: Password1

User login information:

    Email: user@mail.com 
    Password: Password1

    Or create your own user

Technical tasks which were accomplished in this project

- Advanced MVC structure.
- Composer and PSR-4 autoloading.
- MySQL database.
- PhpDoc format documentation for project.
- Where possible prevented page refresh by using JavaScript.
- Main view HTML layout which includes head, body, navbar, footer, to prevent HTML duplication.
- PHP Heredoc syntax for creating repeating HTML elements dynamically, for example in register and login forms.
  
Functional tasks

- Registration and login with validation.
- Admin functionality:
1. Add new items to the store. 
2. Manage store orders. 

- User functionality:
1. Add items to the shopping cart.
2. Checkout and make new orders. 
3. Check your orders and status. 
4. Change user information and change password. 

## How to set it up

1. run command `composer install`
1. create mysql database
1. Create table 'users' in database
1. Create table 'items' in database
1. Create table 'shopping_cart' in database
1. Create table 'orders' in database

CREATE TABLE `users` (
 `user_id` int(11) NOT NULL AUTO_INCREMENT,
 `status` varchar(255) NOT NULL DEFAULT 'customer',
 `firstname` varchar(255) NOT NULL,
 `lastname` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `phone` varchar(255) NOT NULL,
 `address` varchar(255) NOT NULL,
 `postal_code` varchar(255) NOT NULL,
 `password` varchar(255) NOT NULL,
 PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8

CREATE TABLE `items` (
 `item_id` int(11) NOT NULL AUTO_INCREMENT,
 `item_name` varchar(255) NOT NULL,
 `item_type` varchar(40) NOT NULL,
 `item_image` varchar(255) NOT NULL,
 `item_video` varchar(255) NOT NULL,
 `item_price` float NOT NULL,
 `item_quantity` int(255) NOT NULL,
 `item_description` mediumtext NOT NULL,
 `item_rating` int(255) NOT NULL DEFAULT '0',
 PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8

CREATE TABLE `shopping_cart` (
 `shopping_cart_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(255) NOT NULL,
 `items` text NOT NULL,
 `items_quantity` int(11) NOT NULL,
 `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`shopping_cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8

CREATE TABLE `orders` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `order_list` text NOT NULL,
 `message` text NOT NULL,
 `status` varchar(40) NOT NULL,
 `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8