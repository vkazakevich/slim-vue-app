# Slim 4 + Vue 3 application

Project demonstrating using the Slim 4 framework to create a Restful API. The database is powered by Eloquent, and the client side is developed using Vue 3.


## Getting Started

Here you can see how to setup the project. Since the project is using docker you have to have it installed and running.

Use the following commands to initialize the project:

```bash
# You can now edit the settings in the .env file
cp .env.example .env

# Run docker build command
make build

# Install the Composer dependencies
make composer-install 

# Create a database
make create-database
```

To populate the database with fake values, use the following command:

```bash
make populate-database
```

To stop or start the container, use `make start` and `make stop`.

The project is accessible by `localhost:8080` host.

## Postman

For your convenience, this repository has a [OpenAPI Specification](./openapi.json) that can be imported into Postman ([more details](https://learning.postman.com/docs/integrations/available-integrations/working-with-openAPI/)).
