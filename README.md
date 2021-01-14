# dot-doctrine-metadata
Provides metadata and strategies for extracting and rendering Doctrine entities.
This package is a wrapper for mezzio/hal which addresses the doctrine entity proxy metadata issue when using mezzio/hal to generate a HAL response.

### Requirements
- PHP >= 7.4
- mezzio/mezzio-hal >= ^2.0

### Installation

Run the following command in your project root directory

```bash
$ composer require dotkernel/dot-doctrine-metadata
``` 

Next, register the package's `ConfigProvider` to your application config.

``Dot\DoctrineMetadata\ConfigProvider::class,``

Note : Make sure to register the package under the `// DK packages` section.
