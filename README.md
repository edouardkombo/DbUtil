DbUtil
================

The Troll Inception - Db Util

About
-----

Db Util is a set of classes you can use as driver in your application to store values in database.
You can store actually with pdo.

These classes use AbstractFactory methods from The Troll Inception, so they respect the single responsibility principle.

Requirements
------------

Require PHP version 5.3 or greater, AbstractFactory and InterfaceFactory from The Troll Inception.

Installation
------------

The easiest way to install is using [Composer](http://getcomposer.org/) you can easily install TTI Db Util system-wide with the following command:

    composer global require 'edouardkombo/db-util=1.0.0.*@dev'

Make sure you have `~/.composer/vendor/bin/` in your PATH.

Or alternatively, include a dependency in your `composer.json` file. For example:

    {
        "require": {
            "edouardkombo/db-util": "1.0.0.*@dev"
        }
    }

You can also download the DbUtil source directly from the GIT checkout:

    https://github.com/edouardkombo/DbUtil


Documentation
-------------

All additional documentation is available in code docblocks.

Contributing
-------------

If you do contribute code to DbUtil, please make sure it conforms to the PSR coding standard. The easiest way to contribute is to work on a checkout of the repository, or your own fork, rather than an installed version.

Issues
------

Bug reports and feature requests can be submitted on the [Github issues tracker](https://github.com/edouardkombo/DbUtil/issues).

For further informations, contact me directly at edouard.kombo@gmail.com.

