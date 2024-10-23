# Migrating from previous integrations

To migrate from previous integrations please follow the below steps, in order:

- Remove the previous fork from composer.json at the `repositories` key :

      {   
          "type": "vcs",
          "url": "https://github.com/dotkernel/mezzio-hal"
      }

- Remove "`mezzio/mezzio-hal`" package from composer.json
- Delete composer.lock
- Run below command:

      composer require dotkernel/dot-doctrine-metadata

- Register the package’s `ConfigProvider` in `/config/config.php` in the `//DK Packages` section
  `Dot\DoctrineMetadata\ConfigProvider::class,`
