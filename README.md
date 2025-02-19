# Authzed Symfony Bundle

[![Docs](https://img.shields.io/badge/docs-authzed.com-%234B4B6C "Authzed Documentation")](https://docs.authzed.com)

`linkorb/spicedb-bundle` integrates of [`linkorb/spicedb-bundle`](https://github.com/linkorb/spicedb-php) into Symfony applications.

[SpiceDB](https://github.com/authzed/spicedb) is a database system for managing security-critical access control (permissions).

Check out the [SpiceDB's README](https://github.com/authzed/spicedb#readme) for more information.

## Installation

```shell
composer require linkorb/spicedb-bundle
```

## Setup

Specify SpiceDB's `URI` and `API` in your ***config.yaml***  as shown in the following example.
   
```yaml
authzed:
  uri: 'http://spicedb:8443'
  key: 'somerandomkeyhere'
```

## Getting client

Use a SpiceDB client in your application by calling `$container->get()` method with `LinkORB\Authzed\SpiceDB::class` or `LinkORB\Authzed\ConnectorInterface::class` as its argument as shown below.

```php
$container->get(LinkORB\Authzed\SpiceDB::class)
```

**OR**

```php
$container->get(LinkORB\Authzed\ConnectorInterface::class)
```

> [!NOTE]
> You can also register a SpiceDB client in a Symfony application by registering it in the ***config/services.yaml***  (or using [autowiring](https://symfony.com/doc/current/service_container/autowiring.html)).

> [!TIP]
> For more information on SpiceDB connector calls, please refer to [`linkorb/spicedb-php`](https://github.com/linkorb/spicedb-php).

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [engineering.linkorb.com](https://engineering.linkorb.com).