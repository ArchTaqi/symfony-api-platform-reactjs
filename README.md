# Symfony API Platform

```bash
composer require maker
php bin/console make:user
composer require api
composer require jwt-auth
```


```bash
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

```

### API Plateform

## Features

Besides the REST and GraphQL APIs, other features include:

    Native support for JSON-LD, GraphQL, JSONAPI, HAL, raw JSON, XML, YAML and CSV
    Granular control over filters and sorting
    Symfony-based access control for an entire resource, or a particular method
    Pagination
    Serialization groups: The ability to define property groups so subsets of properties can be requested instead of all properties
    Advanced error handling
    Doctrine extension integration for dynamically extending queries
    FOSUserBundle integration
    JWT Authentication (Including the ability to view Swagger UI based on a specific token)
    Data Transfer Objects (DTO) for custom operations


#### API Resource

- **_itemOperations_** Item operations act on an individual resource. Three default routes are defined: GET, PUT and DELETE
- **_collectionOperations_** Collection operations act on a collection of resources. By default two routes are implemented: POST and GET.


When the `ApiResource` annotation is applied to an entity class, all default CRUD operations are automatically registered.
Both `collectionOperations` and `itemOperations` behave independently. i.e if you don't explicitly configure operations for collectionOperations, GET and POST operations will be automatically registered, even if you explicitly configure itemOperations. The reverse is also true.

More : https://api-platform.com/docs/core/operations/


To limit what properties are accessible to either GET or POST/PUT operations, we used below;

- **_normalizationContext_** Refers to reading properties (GET requests)
- **_denormalizationContext_**  Refers to writing data (POST/PUT requests)

In below, a user can view and update their name. They can view but not update their active status, and they have no access to what roles are assigned to them.
 ```php
 use ApiPlatform\Core\Annotation\ApiResource;
 use Symfony\Component\Serializer\Annotation\Groups;
 
 * @ApiResource(
 *   normalizationContext={"groups"={"read"}},
 *   denormalizationContext={"groups"={"write"}}
 * )
 
     /**  @Groups({"read"})  */
     private $active;
     /**  @Groups({"read", "write"}) */
     private $name;
     private $roles;
```
The result of a GET request will not include the roles property. and a PUT request to will only update the name property, even if active and roles are passed along with it.

More on: https://www.thinkbean.com/drupal-development-blog/restrict-properties-api-platform-serialization-groups

