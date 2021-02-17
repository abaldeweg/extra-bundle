# baldeweg/extra-bundle

This is the description of the package.

## Getting Started

```shell
composer req skeleton/framework
```

Activate the bundle in your `config/bundles.php`.

```php
Baldeweg\Bundle\ExtraBundle\BaldewegExtraBundle::class => ['all' => true],
```

Add optional routes to your `src/routes.yaml`. The `me` endpoint gives you some details of the current user. Change your password with the `password` endpoint. For more info have a look into the corresponding classes.

```yaml
me:
  path: /api/v1/me
  controller: Baldeweg\Bundle\ExtraBundle\Service\MeUser::me
  methods: GET

password:
  path: /api/v1/password
  controller: Baldeweg\Bundle\ExtraBundle\Service\PasswordUser::password
  methods: PUT
```

## Doc

Create `README.md` and `bin/setup` with the following command. Existing files wont be overridden.

```shell
bin/console make:extra:doc
```

## User

Define the `User` class in the `config/packages/baldeweg_extra.yaml`. You can omit this setting if you use `App\Entity\User`.

```yaml
baldeweg_extra:
  userclass: App\Entity\User
```

## test Trait

To make XHR requests easier, there is an `ApiTestTrait` trait available for use.

```php
use \Baldeweg\Bundle\ExtraBundle\ApiTestTrait;
```
