# yii2-gii
Abstract model generator for Yii2 Gii code generator.

### Install

Either run

```
$ php composer.phar require mg-code/yii2-gii "@dev"
```

or add

```
"mg-code/yii2-gii": "@dev"
```

to the ```require``` section of your `composer.json` file.

### Usage

Simply add generator to gii generators list

```
  ...
    'bootstrap' => 'gii',
    'modules' => [
        'gii' => [
            'generators' => [
                'class' => 'yii\gii\Module',
                'abstractModel' => [
                    'class' => 'mgcode\gii\generators\abstractModel\Generator',
                ],
            ],
        ],
    ],
  ...
```
