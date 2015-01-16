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
    console
        config/          contains console configurations
        controllers/     contains console controllers (commands)
        migrations/      contains database migrations
        models/          contains console-specific model classes
scripts
    init                 init project
    yii                  yii command tool
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

1. 运行 `scripts/init` 初始化项目 (生成对应环境的scripts/yii 命令
2. 运行 `scripts/yii app/create-web-app "appname" 创建一个web app 到 apps/ 下
3. 运行 `scripts/init` 再次初始化项目

更多app命令

- 运行 `scripts/yii app/delete-web-app "appname" 删除一个web应用， 不可回复，请慎用。
- 运行 `scripts/yii app/create-console-app "appname" "entryname"  创建一个控制台应用，entryname为入口文件名，不能是yii
- 运行 `scripts/yii app/delete-console-app "appname" "entryname" 删除一个控制台应用，不可恢复，请慎用

Set document roots of your Web server:

- for appname `/path/to/yii-application/apps/"appname"/web/` and using the URL `http://frontend/`

Run a Console App:

- scripts/"entryname"
