# dot-doctrine-metadata

> [!IMPORTANT]
> dot-doctrine-metadata is a wrapper on top of [mezzio/mezzio-hal](https://github.com/mezzio/mezzio-hal)
>
> ![Dynamic JSON Badge](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fapi.github.com%2Frepos%2Fmezzio%2Fmezzio-hal%2Fproperties%2Fvalues&query=%24%5B%3F(%40.property_name%3D%3D%22maintenance-mode%22)%5D.value&label=Maintenance%20Mode)

> [!CAUTION]
> ## Security-Only Maintenance Mode
> This package is in maintenance mode and will not receive further updates because the main issue was fixed by mezzio.

## dot-doctrine-metadata badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-doctrine-metadata)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-doctrine-metadata/3.2.2)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-doctrine-metadata)](https://github.com/dotkernel/dot-doctrine-metadata/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-doctrine-metadata)](https://github.com/dotkernel/dot-doctrine-metadata/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-doctrine-metadata)](https://github.com/dotkernel/dot-doctrine-metadata/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-doctrine-metadata)](https://github.com/dotkernel/dot-doctrine-metadata/blob/3.0/LICENSE)

[![Build Static](https://github.com/dotkernel/dot-doctrine-metadata/actions/workflows/continuous-integration.yml/badge.svg?branch=3.0)](https://github.com/dotkernel/dot-doctrine-metadata/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/dot-doctrine-metadata/graph/badge.svg?token=ZGR8LJGZV5)](https://codecov.io/gh/dotkernel/dot-doctrine-metadata)

[![SymfonyInsight](https://insight.symfony.com/projects/e76bb03b-b630-4a3e-9a24-b6a04cee7210/big.svg)](https://insight.symfony.com/projects/e76bb03b-b630-4a3e-9a24-b6a04cee7210)


Provides metadata and strategies for extracting and rendering Doctrine entities.
This package is a wrapper for `mezzio/mezzio-hal` which addresses the doctrine entity proxy metadata issue when using `mezzio/mezzio-hal` to generate HAL responses.

## Requirements

- PHP >= 8.1
- mezzio/mezzio-hal >= ^2.4

## Installation

Run the following command in your project root directory:

      composer require dotkernel/dot-doctrine-metadata

Next, register the package's `ConfigProvider` to your application config:

      Dot\DoctrineMetadata\ConfigProvider::class,

Note : Make sure to register the package in the `// DK packages` section.

## Migrating from previous integrations

To migrate from previous integrations please follow the below steps, in order:

- Remove the previous fork from composer.json at the `repositories` key :

      {   
          "type": "vcs",
          "url": "https://github.com/dotkernel/mezzio-hal"
      }

- Remove "`mezzio/mezzio-hal`" package from composer.json
- Delete composer.lock
- Run `composer require dotkernel/dot-doctrine-metadata`
- Register the package’s `ConfigProvider` in `/config/config.php` in the `//DK Packages` section
  `Dot\DoctrineMetadata\ConfigProvider::class,`
