### [Kohana][kohana] project template for Composer

This is how [we][despark] bootstrap a Kohana project.

#### Creating a new project

To create a project `foobar` run:
``` bash
composer create-project despark/kohana foobar 
```

That's it! You now have a Kohana project with some important modules installed, CLI tools, permissions set up and more!

#### What is installed

- [Kohana core][kohana core]
- Kohana modules:
  * [database][kohana database]
  * [auth][kohana auth]
  * [cache][kohana cache]
  * [image][kohana image]
- [Jam][jam]
- [Jam Auth][jam auth]
- [Phinx migrations][phinx]
- [Password compatbility][password compat]

#### Password hashing

The password hashing in the Auth module defaults to [PHP 5.5 `password_hash`][password_hash].
Compatibility for PHP <5.5.0 is achieved using Anthony Ferrara's [password_compat][password compat].

#### Database configuration

Kohana Database module is configured based on environments.
The database name defaults to the project name.

#### Migrations

Migrations are done via [phinx][phinx].
Configuration is in [phinx.yml][phinx.yml].
The database name defaults to the project name.

[despark]: http://despark.com/
[kohana]: http://kohanaframework.org/
[kohana core]: https://github.com/kohana/core
[kohana database]: https://github.com/kohana/database
[kohana auth]: https://github.com/kohana/auth
[kohana cache]: https://github.com/kohana/cache
[kohana image]: https://github.com/kohana/image
[kohana core]: https://github.com/kohana/core
[jam]: https://github.com/openbuildings/jam
[jam auth]: https://github.com/openbuildings/jam-auth
[phinx]: https://github.com/robmorgan/phinx
[password compat]: https://github.com/ircmaxell/password_compat
[password_hash]: http://www.php.net/manual/en/function.password-hash.php
