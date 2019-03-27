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