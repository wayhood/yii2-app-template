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

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

1. Run command `init` to initialize the application with a specific environment.
2. Run command `scripts/yii app/create-web-app "appname".
3. Run command `scripts/yii app/delete-web-app "appname" will remove app.
4. Run command `scripts/yii help app` show all.
5. Create a new database and adjust the `components['db']` configuration in `common/config/main-local.php` accordingly.
6. Apply migrations with console command `yii migrate`. This will create tables needed for the application to work.
7. Set document roots of your Web server:

- for frontend `/path/to/yii-application/apps/frontend/web/` and using the URL `http://frontend/`
- for backend `/path/to/yii-application/apps/backend/web/` and using the URL `http://backend/`


To login into the application, you need to first sign up, with any of your email address, username and password.
Then, you can login into the application with same email address and password at any time.
