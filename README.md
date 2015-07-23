Yii2 youtube extension
======================
Yii2 youtube extension

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tuyakhov/yii2-youtube/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tuyakhov/yii2-youtube/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/tuyakhov/yii2-youtube/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tuyakhov/yii2-youtube/build-status/master) [![Code Climate](https://codeclimate.com/github/tuyakhov/yii2-youtube/badges/gpa.svg)](https://codeclimate.com/github/tuyakhov/yii2-youtube)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tuyakhov/yii2-youtube "*"
```

or add

```
"tuyakhov/yii2-youtube": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

Widget

```php
    \tuyakhov\youtube\EmbedWidget::widget([
        'code' => 'vs5ZF9fRDzA',
        'playerParameters' => [
            'controls' => 2
        ],
        'iframeOptions' => [
            'width' => '600',
            'height' => '450'
        ]
    ]);
```

Validator

```php
    public function rules()
    {
        return [
            ['youtube_code', CodeValidator::className()],
        ];
    }
```
