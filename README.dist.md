### {{PROJECT_NAME}}

This is how [we][despark] bootstrap a Kohana project.

#### Creating a new project

To create a project `foobar` run:
``` bash
composer create-project despark/kohana foobar
```

That's it! You now have a Kohana project with some important modules installed, CLI tools, permissions set up and more!

#### What is installed

- [Kohana core][kohana core]
- Official Kohana modules:
  * [Database][kohana database]
  * [Auth][kohana auth]
  * [Cache][kohana cache]
  * [Image][kohana image]
- Other Kohana modules:
  * [Jam][jam]
  * [Jam Auth][jam auth]
- [Phinx migrations][phinx] (see [Migrations](#migrations))
- [Password compatbility][password compat] (see [Password hashing](#password-hashing))

#### Installing additional libraries

You could run:
``` bash
composer require <vendor>/<library>:<version_constraint>
```

This would update the `require` section in `composer.json`, install the library and update the `composer.lock` file.

See the `suggest` section in `composer.json` for a useful list of Kohana modules and other libraries.

#### Bootstrap

The bootstrap file for Kohana is filled with a lot of goodies. You should check it out here: [`bootstrap.php`](application/bootstrap.php).

#### Password hashing

The [password hashing in the Auth module defaults](application/classes/Auth.php) to [PHP 5.5 `password_hash`][password_hash].
Compatibility for PHP <5.5.0 is achieved using Anthony Ferrara's [password_compat][password compat].

#### Database configuration

Kohana Database module is [configured based on environments](application/config/database.php).
The database name defaults to the project name.

#### Migrations

Migrations are done via [phinx][phinx].
Configuration is in [phinx.yml](phinx.yml).
The database name defaults to the project name.

#### Under the hood

If you are curious how your project is actually built you should check out:
- [Composer `create-project`][composer create-project] command
- [`composer.json`](composer.json)

Here is a summary:

- First it clones this repo in a folder with the name you've provided.
- Then it finds all dependencies listed in the `require` and `require-dev` sections in `composer.json` and their dependencies as well.
- Downloads them and put them in either [`vendor/`](vendor/) or [`modules/`](modules/).
- Then it runs the scripts from the `post-create-project-cmd` section in `composer.json`:
  * Creates `application/classes/Model`, `application/migrations` and `application/views`.
  * `chmod` with 755 `application/migrations`
  * Generates a random string and sets `Cookie::$salt` with it.
  * Replace `{{DATABASE_NAME}}` in [`phinx.yml`](phinx.yml) and [`application/config/database.php`](application/config/database.php) with the name of the project.

[despark]: http://despark.com/
[kohana]: http://kohanaframework.org/
[composer]: http://getcomposer.org/
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
[composer create-project]: https://getcomposer.org/doc/03-cli.md#create-project
