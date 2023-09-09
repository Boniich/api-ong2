# API REST ONG

This is a copy of a API REST that i used in my acceleracion of REACT in ALKEMY in 2022.

## YOUTUBE

I believe that one of best way to improve our knowledge is teaching or explain concepts to other, that why i make a full playlist of 50 records, where i am going creainting this API REST, using `LARAVEL`, `DOCKER`, and `POSTGRESQL`

You can take a look here: https://www.youtube.com/playlist?list=PLl9ZbfOa8iGkEGt5BpHvk_CLdEP3nPK-2

## STACK/TECNOLOGIES

-   LARAVEL
-   DOCKER
-   POSTGRESQL
-   LARAVEL PERMISSION (Handle all about roles and permission)
-   SANTUM

## FEATURES

-   Creation of tables, models, controllers, factories, seeder
-   Upload, updating and destroy of images
-   Login and register
-   All most all endpoints can show all records, one record, update, create and destroy records
-   Error handeling
-   Override of exceptions
-   Creation and use of HELPER FUNCTIONS
-   TESTING (Data base testing and HTTP response testing)
-   DOCUMENTACION (using swagger)

## Extra

-   I used postman during development
-   A full use of `Linux terminal` to run commands

## How to run/see this API REST?

Unfortunelly, i am still having problem with desploy, meanwhile i work in it, i will give you two way to see my work:

## 1 - See this demo record

In this record of 5 minutes, you will see a fast advance of all this API REST:

https://youtu.be/pMBRVL9Zteg

## 2- Clone de repo and run the project

This second way requires a bit more of effort, but i let the step if you want to make it

1- You need DOCKER in your computer  
2- Clone de repo  
3- Open it with VSCode or another code editor

Note: since this point you will need a command line of linux (You can use command line that come with sub system add with DOCKER)

4- Run de command `./vendor/bin/sail up` to up de project  
5- Run migracion `./vendor/bin/sail artisan migration`  
6- Run Seeder and factories: `./vendor/bin/sail artisan db:seed`  
7- Read/Take a look to the code

### Take a look at documentacion generate with swagger

Here you will see all endpoints of API REST and will be able to make them work

1- Access to documentacion of API REST with the endpoint `localhost/documentacion` in your browser  
2- In this point you should have see all endpoints and MAKE WORK `ALL PUBLIC ENDPOINTS`

### Make work private/protected endpoints with in swagger:

1- Login one of two users leaved here belown.  
2- Copy the `TOKEN` of answer  
3- Click in the button `Authorizade`  
4- In the input of modal window introduce: `Bearer Token that you copied`

Note: It is required that you add the word `Bearer` and the space ` ` and then the `TOKEN`, any other pattern will give an incorrect authorization

5- Use all private/protected methods

### Running endpoints by postman or another program/extension

If you want use the postman or another programa/extension can follow the nexts step (it depends of each program)

1- You can use POSTMAN or another program to HTTP Request for test `ALL PUBLIC ENDPOINTS` following the next url: `http://0.0.0.0:80/api/v1/addenpointhere`

Note: remplace `addenpointhere` for the endpoint name that you want to use.

### To use protected/private endpoints:

1- Login one of two users leaved here belown.  
2- Copy the `TOKEN` of answer  
3- (In Postman) go to the authorization window and select `Bearer TOKEN` then paste the `TOKEN` that you copy before

## Users to login and use the protected endpoints

First user, here will able to use almost all endpoints, except `ROLE ENDPOINTS`, cause it required `ADMIN ROLE` to use that `ENDPOINT`

```
email: user@gmail.com
password: 123456
```

Second user, this user has the `ROLE of ADMIN`, so, will able to use ALL endpoints of API REST

```
email: admin@gmail.com
password: 123456
```
