# dot-doctrine-metadata
Provides metadata and strategies for extracting and rendering Doctrine entities.
This package is a wrapper for `mezzio/mezzio-hal` which addresses the doctrine entity proxy metadata issue when using `mezzio/mezzio-hal` to generate HAL responses.

### Requirements
- PHP >= 7.4
- mezzio/mezzio-hal >= ^2.0

### Installation

Run the following command in your project root directory

```
$ composer require dotkernel/dot-doctrine-metadata
``` 

Next, register the package's `ConfigProvider` to your application config.

``Dot\DoctrineMetadata\ConfigProvider::class,``

Note : Make sure to register the package in the `// DK packages` section.

### Migrating from previous integrations

To migrate from previous integrations please follow the below steps, in order:

- Remove the previous fork from composer.json at the `repositories` key :
```$xslt
{   
    "type": "vcs",
    "url": "https://github.com/dotkernel/mezzio-hal"
}
```

- Remove "`mezzio/mezzio-hal`" package from composer.json
- Delete composer.lock
- Run ```
      $ composer require dotkernel/dot-doctrine-metadata
      ``` 
- Register the package’s `ConfigProvider` in `/config/config.php` in the `//DK Packages` section 
``Dot\DoctrineMetadata\ConfigProvider::class,``