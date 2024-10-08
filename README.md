<p align="center">
  <a href="https://cakephp.org/" target="_blank" >
    <img alt="CakePHP" src="https://cakephp.org/v2/img/logos/CakePHP_Logo.svg" width="400" />
  </a>
</p>
<p align="center">
    <a href="LICENSE" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://codecov.io/gh/cakephp/cakephp/branch/4.x" target="_blank">
        <img alt="Coverage Status" src="https://img.shields.io/codecov/c/github/cakephp/cakephp?style=flat-square">
    </a>
    <a href="https://phpstan.org/" target="_blank">
        <img alt="PHPStan" src="https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat">
    </a>
    <a href="https://squizlabs.github.io/PHP_CodeSniffer/analysis/cakephp/cakephp/" target="_blank">
        <img alt="Code Consistency" src="https://squizlabs.github.io/PHP_CodeSniffer/analysis/cakephp/cakephp/grade.svg">
    </a>
    <a href="https://packagist.org/packages/cakephp/cakephp" target="_blank">
        <img alt="Total Downloads" src="https://img.shields.io/packagist/dt/cakephp/cakephp.svg?style=flat-square">
    </a>
    <a href="https://packagist.org/packages/cakephp/cakephp" target="_blank">
        <img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/cakephp/cakephp.svg?style=flat-square&label=stable">
    </a>
</p>

[CakePHP](https://cakephp.org) is a rapid development framework for PHP which
uses commonly known design patterns like Associative Data
Mapping, Front Controller, and MVC.  Our primary goal is to provide a structured
framework that enables PHP users at all levels to rapidly develop robust web
applications, without any loss to flexibility.

## Installing CakePHP via Composer

You can install CakePHP into your project using
[Composer](https://getcomposer.org).  If you're starting a new project, we
recommend using the [app skeleton](https://github.com/cakephp/app) as
a starting point. For existing applications you can run the following:

``` bash
composer require cakephp/cakephp
```

For details on the (minimum/maximum) PHP version see [version map](https://github.com/cakephp/cakephp/wiki#version-map).

## Running Tests

Assuming you have PHPUnit installed system wide using one of the methods stated
[here](https://phpunit.de/manual/current/en/installation.html), you can run the
tests for CakePHP by doing the following:

1. Copy `phpunit.xml.dist` to `phpunit.xml`.
2. Add the relevant database credentials to your `phpunit.xml` if you want to run tests against
   a non-SQLite datasource.
3. Run `phpunit`.

## Learn More

* [CakePHP](https://cakephp.org) - The home of the CakePHP project.
* [Book](https://book.cakephp.org) - The CakePHP documentation; start learning here!
* [API](https://api.cakephp.org) - A reference to CakePHP's classes and API documentation.
* [Awesome CakePHP](https://github.com/FriendsOfCake/awesome-cakephp) - A curated list of featured resources around the framework.
* [The Bakery](https://bakery.cakephp.org) - Tips, tutorials and articles.
* [Community Center](https://community.cakephp.org) - A source for everything community related.
* [Training](https://training.cakephp.org) - Join a live session and get skilled with the framework.
* [CakeFest](https://cakefest.org) - Don't miss our annual CakePHP conference.
* [Cake Software Foundation](https://cakefoundation.org) - Promoting development related to CakePHP.

## Get Support!

* [Slack](https://slack-invite.cakephp.org/) - Join us on Slack.
* [Discord](https://discord.gg/k4trEMPebj) - Join us on Discord.
* [#cakephp](https://webchat.freenode.net/?channels=#cakephp) on irc.freenode.net - Come chat with us, we have cake.
* [Forum](https://discourse.cakephp.org/) - Official CakePHP forum.
* [GitHub Issues](https://github.com/cakephp/cakephp/issues) - Got issues? Please tell us!
* [Roadmaps](https://github.com/cakephp/cakephp/wiki#roadmaps) - Want to contribute? Get involved!

## Contributing

* [CONTRIBUTING.md](.github/CONTRIBUTING.md) - Quick pointers for contributing to the CakePHP project.
* [CookBook "Contributing" Section](https://book.cakephp.org/5/en/contributing.html) - Details about contributing to the project.

# Security

If you’ve found a security issue in CakePHP, please use the procedure
described in [SECURITY.md](.github/SECURITY.md).
