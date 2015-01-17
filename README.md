Yii 2 Application Template
==========================

DIRECTORY STRUCTURE
-------------------

```
apps
    common
        config/          contains shared configurations
        mail/            contains view files for e-mails
        models/          contains model classes used in both backend and frontend
scripts
    init                 init project
    app                  app creation/deletion tool
    requirements         php environment check.
runtimes/                contains files generated during runtime by app name
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```

INSTALLATION
------------
~~~
php composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta4"
php composer.phar create-project --prefer-dist --stability=dev wayhood/yii2-app-template app
~~~

GETTING STARTED
---------------

1. 运行 `scripts/app` 创建 web 或 console 的应用程序， 会在apps下创建
2. 运行 `scripts/init` 初始化项目

Set document roots of your Web server:

- for appname `/path/to/yii-application/apps/"appname"/web/` and using the URL `http://webserver/pato/to/`

Run a Console App:

- scripts/"entryname"

yii系统的命令，使用 `vendor/bin/yii`


快速还原官方的 yii2-app-advanced: 

1. `scripts/app --act=Create --type=Web --name=backend`
2. `scripts/app --act=Create --type=Web --name=frontend`
3. `scirpts/app --act=Create --type=Console --name=console --enter=yii`
