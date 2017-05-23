# ElasticaBundle

## Installation

Open a command console and in your project directory execute following command
to download latest version of this bundle:

### 1. Download the Bundle

```bash
$ composer require opstalent/elastica-bundle dev-master
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### 2. Enable the Bundle

After downloading, enable the bundle by adding the following lines in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Opstalent\ElasticaBundle\ElasticaBundle(),
        ];

        // ...
    }
}
```

### 3. Modify config of FOSElasticaBundle

To enable serializer for Elasticsearch requests add following to your `app/config/config.yml`:

```yml
# app/config/config.yml

fos_elastica:
   serializer: 
       serializer: 'ops_elastica.serializer'
```

To enable transformer for Elasticsearch responses add following to your `app/config/config.yml`:

```yml
# app/config/config.yml

parameters:
    fos_elastica.elastica_to_model_transformer.prototype.orm.class: Opstalent\ElasticaBundle\Transformer\ElasticaToModelTransformer
```
