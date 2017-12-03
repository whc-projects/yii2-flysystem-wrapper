yii2 flysystem wrapper
=================
yii2 flysystem wrapper. [Flysystem](http://flysystem.thephpleague.com/) is a filesystem abstraction which allows you to easily swap out a local filesystem for a remote one.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist whc/yii2-flysystem-wrapper "*"
```

or add

```
"whc/yii2-flysystem-wrapper": "*"
```

to the require section of your `composer.json` file.

then up migrations
```
php yii migrate/up --migrationPath=vendor/whc/yii2-flysystem-wrapper/migrations
```

Usage/Features
-----
Once the extension is installed, simply use it in your code by  :

add "fs" to components
```php
'fs' => [
    'class' => 'Integral\Flysystem\Adapter\PDOAdapter', // or other adapters
    'tableName' => 'file_storage'
],
```

upload sample code
```php
<?php
$model = new MyModel();
if (Yii::$app->request->isPost) {
    $model->files = UploadedFile::getInstancesByName('files');
    if ($model->validate()) {
        $data = [
            'path' => '@common/files',
            'context' => '025',
            'version' => '1',
            'metadata' => ['meta' => 1, 'meta2' => 2, 'meta3' => 3],
        ];
        return FlysystemWrapper::upload($model->files, $data);
    }
        return $model;
}
?>
```
note: in model file rule "maxFiles" is required
```php
<?php
[['files'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 10, 'extensions' => 'txt, jpg']
?>
```

get a file by hash key
```php
<?php
$hashKey = 'XXX';
return FlysystemWrapper::getByHash($hashKey);
?>
```

read a file by hash key
```php
<?php
$hashKey = 'XXX';
return FlysystemWrapper::readByHash($hashKey);
?>
```

delete a file by hash key
```php
<?php
$hashKey = 'XXX';
return FlysystemWrapper::deleteByHash($hashKey);
?>
```
note: delete method is logical

search file(s) by metadatas or file model spesial attributes
```php
<?php
$params = ['meta1' => 1, 'version' => 2];
return FlysystemWrapper::searchByParams($params);
?>
```