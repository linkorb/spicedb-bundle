# Authzed Symfony Bundle

[![Docs](https://img.shields.io/badge/docs-authzed.com-%234B4B6C "Authzed Documentation")](https://docs.authzed.com)

This repository is integration of [PHP library](https://github.com/linkorb/spicedb-php) into Symfony app.

[SpiceDB] is a database system for managing security-critical permissions checking.

Check parent library README for more details

[SpiceDB]: https://github.com/authzed/spicedb

## Basic Usage

### Installation

```shell
composer require linkorb/spicedb-php-bundle
```
After that you need to specify SpiceDB URI & API in your config.yaml like that:
```yaml
authzed:
  uri: 'http://spicedb:8443'
  key: 'somerandomkeyhere'
```

### Getting client

In order to use SpiceDB client in your app simply call:
```php
$container->get(LinkORB\Authzed\SpiceDB::class)
```
or:
```php
$container->get(LinkORB\Authzed\ConnectorInterface::class)
```

You can also pass it in services (or using autowiring). For more information on SpiceDB connector calls refer to [library repo](https://github.com/linkorb/spicedb-php).
