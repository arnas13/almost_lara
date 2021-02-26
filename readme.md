# AlmostLara

This is our mvc framework build from scratch

## Requirements
- Your machine has to have [composer](https://getcomposer.org/download/) installed
- This is PHP@7.4 project that uses typed properties
- This project uses mysql database

## How to set it up

1. run command `composer install`
1. create database mysql database
1. create table users in database
    ``
        CREATE TABLE  `users` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , `email` VARCHAR(150) NOT NULL , `password` VARCHAR(255) NOT NULL , `created_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), UNIQUE `EMAIL` (`email`)) ENGINE = InnoDB;

    ``
1. copy .env_example to .env
    1. change db name 
    1. change db user 
    1. change db password 