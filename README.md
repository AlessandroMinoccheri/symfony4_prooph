# SYMFONY4 PROOPH

This repository is a simple boilerplate with symfony 4 and prooph.
It's a fork of this other repository:

[proophessor-do-symfony](https://github.com/prooph/proophessor-do-symfony)

In this project I will make some tests on it and I will add other scenarios to make some examples with Prooph

## INSTALLATION

To install it you need to launch into your cli

```
composer install
```

And after starts the docker 

```
docker-compose up -d
```

To init database and tables you need to launch this command

```
docker-compose run --rm php php bin/console event-store:event-stream:create
```

If you want to create some events you can launch tests that create a Todo and a Post creation event in this way:

```
./runtests.sh
```

## ADD NEW RESOURCE

To add a new resource to test events you need to create 

* Write tests (Example tests/Controller/PostControllerTest)
* Write controller (Example src/Controller/PostController)
* Add route

Example

```
command::post-post:
    path: /posts
    defaults: { _controller: App\Controller\PostController:postCreatePostAction, prooph_command_name: 'App\Prooph\Model\Post\Command\PostPost' }

```


* Add Model with its Object Id, Handler, Event and Command (Example src/Prooph/Model/Post)
* Add the repository (Example src/Prooph/Infrastructure/Repository/EventStorePostList)
* Add services into services.yaml

```
App\Controller\PostController:
    arguments: ['@prooph_service_bus.todo_command_bus', '@prooph_service_bus.message_factory']
    tags: ['controller.service_arguments']

App\Prooph\Model\Post\Handler\PostPostHandler:
    arguments: ['@post_list']
    public: true
    tags:
        - { name: 'prooph_service_bus.todo_command_bus.route_target', message_detection: true }
```

## Projections

If you want to test a projection you can:

* run into you cli ```bin/console event-store:projection:run post_projection```
* open Postman
* make a POST request to /posts with text and description
* take the post Id that returns
* make a GET request to /posts/{postId}

For every projection you need to run its projection command.  
For this reason isn't possible at the moment to test this api because you need to launch projections also


 
