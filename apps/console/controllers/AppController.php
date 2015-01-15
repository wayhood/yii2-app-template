<?php
/**
 * @link http://www.wayhood.com/
 */

namespace console\controllers;

/**
 * Create or Delete to web or console application
 *
 * #create a web application
 * scripts/yii app/create-web-app frontend
 *
 * #create a console application
 * scripts/yii app/create-console-app queue
 *
 * #delete a web application
 * scripts/yii app/delete-web-app frontend
 *
 * #delete a console application
 * scripts/yii app/delete-console-app queue
 *
 * @package console\controllers
 * @author Song Yeung <netyum@163.com>
 * @date 12/2/14
 */
class AppController extends \yii\console\Controller
{

    /**
     * Create a web application
     * @param $appName app's name
     */
    public function actionCreateWebApp($appName)
    {
        $this->checkAppName($appName);
        $this->generateWebApp($appName);
        $this->addAppNameToCommon($appName);

        $this->generateWebAppEnvironments($appName);
    }

    /**
     * Create a console application
     * @param $appName app's name
     * @param null $enterName enter script's name
     */
    public function actionCreateConsoleApp($appName, $enterName = null)
    {
        $this->checkAppName($appName);
        $this->generateConsoleApp($appName);
        $this->addAppNameToCommon($appName);

        $this->generateConsoleAppEnvironments($appName, $enterName);
    }

    /**
     * Delete a web application
     * @param $appName app's name
     * @return mixed
     */
    public function actionDeleteWebApp($appName)
    {
        if ($appName == 'common' || $appName == 'console') {
            $this->stderr('Error: App name can\'t was common or console'."\n");
            return self::EXIT_CODE_ERROR;
        }
        $ret = $this->confirm('Delete WebApp '. $appName .'? Are you sure?');
        if ($ret) {
            $this->deleteWebApp($appName);
            $this->deleteRuntime($appName);
        }
    }

    /**
     * Delete a console application
     * @param $appName app's name
     * @param null $enterName enter script's name
     * @return mixed
     */
    public function actionDeleteConsoleApp($appName, $enterName = null)
    {
        if ($appName == 'common' || $appName == 'console') {
            $this->stderr('Error: App name can\'t was common, console or yii'."\n");
            return self::EXIT_CODE_NORMAL;
        }

        if ($enterName == 'yii' || is_null($enterName)) {
            $enterName = $appName;
        }

        $ret = $this->confirm('Delete ConsoleApp '. $appName .'? Are you sure?');
        if ($ret) {
            $this->deleteConsoleApp($appName, $enterName);
            $this->deleteRuntime($appName);
        }
    }

    /**
     * Delete app dir at runtimes
     * @param $appName app's name
     */
    protected function deleteRuntime($appName)
    {
        $runtimePath = ROOT_DIR .'/runtimes/' . $appName;
        $this->destroyDir($runtimePath);
    }

    /**
     * Delete console application
     * @param $appName
     * @param $enterName
     */
    protected function deleteConsoleApp($appName, $enterName)
    {
        $this->stdout("Remove ConsoleApp $appName\n");
        $appPath = APPS_DIR .'/'. $appName;
        $this->destroyDir($appPath);
        $this->stdout("... ok\n");

        $envs = ['dev', 'prod'];
        $this->stdout("Remove ConsoleApp Environments\n");
        $environmentPath = ROOT_DIR .'/environments';
        foreach($envs as $env) {
            $envPath = $environmentPath .'/'.$env.'/apps/'.$appName;
            $this->destroyDir($envPath);
            $enterFile = $environmentPath .'/'.$env.'/scripts/'. $enterName;
            @unlink($enterFile);
        }

        @unlink(ROOT_DIR .'/scripts/'. $enterName);

        //unset evn config;
        $environmentsConfigFile = ROOT_DIR .'/environments/index.php';
        $environmentsConfig = require($environmentsConfigFile);

        if (in_array($enterName, $environmentsConfig['Development']['setExecutable'])) {
            $keys = array_keys($environmentsConfig['Development']['setExecutable'], $enterName);

            foreach($keys as $key) {
                unset($environmentsConfig['Development']['setExecutable'][$key]);
            }
        }

        if (in_array($enterName, $environmentsConfig['Production']['setExecutable'])) {
            $keys = array_keys($environmentsConfig['Production']['setExecutable'], $enterName);

            foreach($keys as $key) {
                unset($environmentsConfig['Production']['setExecutable'][$key]);
            }
        }

        file_put_contents($environmentsConfigFile, "<?php\nreturn ". var_export($environmentsConfig, true).';');

        $this->stdout("... ok\n");
    }

    /**
     * @param $appName
     */
    protected function deleteWebApp($appName)
    {
        $this->stdout("Remove WebApp $appName\n");
        $appPath = APPS_DIR .'/'. $appName;
        $this->destroyDir($appPath);
        $this->stdout("... ok\n");

        $envs = ['dev', 'prod'];
        $this->stdout("Remove WebApp Environments\n");
        $environmentPath = ROOT_DIR .'/environments';
        foreach($envs as $env) {
            $envPath = $environmentPath .'/'.$env.'/apps/'.$appName;
            $this->destroyDir($envPath);
        }

        //unset evn config;
        $environmentsConfigFile = ROOT_DIR .'/environments/index.php';
        $environmentsConfig = require($environmentsConfigFile);

        $webAssetsPath = 'apps/'. $appName .'/web/assets';
        if (in_array($webAssetsPath, $environmentsConfig['Development']['setWritable'])) {
            $keys = array_keys($environmentsConfig['Development']['setWritable'], $webAssetsPath);

            foreach($keys as $key) {
                unset($environmentsConfig['Development']['setWritable'][$key]);
            }
        }

        if (in_array($webAssetsPath, $environmentsConfig['Production']['setWritable'])) {
            $keys = array_keys($environmentsConfig['Production']['setWritable'], $webAssetsPath);

            foreach($keys as $key) {
                unset($environmentsConfig['Production']['setWritable'][$key]);
            }
        }

        $validationKeyFile = 'apps/'. $appName .'/config/main-local.php';
        if (in_array($validationKeyFile, $environmentsConfig['Development']['setCookieValidationKey'])) {
            $keys = array_keys($environmentsConfig['Development']['setCookieValidationKey'], $validationKeyFile);

            foreach($keys as $key) {
                unset($environmentsConfig['Development']['setCookieValidationKey'][$key]);
            }
        }


        $validationKeyFile = 'apps/'. $appName .'/config/main-local.php';
        if (in_array($validationKeyFile, $environmentsConfig['Production']['setCookieValidationKey'])) {
            $keys = array_keys($environmentsConfig['Production']['setCookieValidationKey'], $validationKeyFile);

            foreach($keys as $key) {
                unset($environmentsConfig['Production']['setCookieValidationKey'][$key]);
            }
        }

        file_put_contents($environmentsConfigFile, "<?php\nreturn ". var_export($environmentsConfig, true).';');

        $this->stdout("... ok\n");
    }

    /**
     * @param $appName
     * @param null $enterName
     */
    protected function generateConsoleAppEnvironments($appName, $enterName = null)
    {
        $this->stdout("Generate ConsoleApp $appName Environments\n");

        $envs = ['dev', 'prod'];

        foreach($envs as $env) {
            $distPath = ROOT_DIR .'/environments/'. $env .'/apps/'. $appName;
            $templatePath = APPS_DIR .'/console/templates/consoleenvironment/'. $env;

            $files = [
                'config/main-local.php',
                'config/params-local.php',
            ];
            foreach($files as $file) {
                $replace = null;
                if (is_array($file)) {
                    $file = $file[0];
                    $replace = $appName;
                }
                $source = $templatePath .'/'. $file;
                $dist = $distPath .'/'. $file;
                $this->copyFile($source, $dist, $replace);
            }
        }

        foreach($envs as $env) {
            $distPath = ROOT_DIR .'/environments/'. $env ;
            $templatePath = APPS_DIR .'/console/templates/consoleenvironment/'. $env;

            $files = [
                ['scripts/enter']
            ];


            $distFile = $appName;
            if (!is_null($enterName)) {
                $distFile = $enterName;
            }

            foreach($files as $file) {
                $replace = null;
                if (is_array($file)) {
                    $file = $file[0];
                    $replace = $appName;
                }
                $source = $templatePath .'/'. $file;
                $dist = $distPath .'/'. $distFile;
                $this->copyFile($source, $dist, $replace);
            }
        }

        $environmentsConfigFile = ROOT_DIR .'/environments/index.php';
        $environmentsConfig = require($environmentsConfigFile);

        if (!in_array($distFile, $environmentsConfig['Development']['setExecutable'])) {
            $environmentsConfig['Development']['setExecutable'][] = $distFile;
        }

        if (!in_array($distFile, $environmentsConfig['Production']['setExecutable'])) {
            $environmentsConfig['Production']['setExecutable'][] = $distFile;
        }

        file_put_contents($environmentsConfigFile, "<?php\nreturn ". var_export($environmentsConfig, true).';');

        $this->stdout("... ok\n");
    }

    /**
     * @param $appName
     */
    protected function generateWebAppEnvironments($appName) {
        $this->stdout("Generate WebApp $appName Environments\n");

        $envs = ['dev', 'prod'];

        foreach($envs as $env) {
            $distPath = ROOT_DIR .'/environments/'. $env .'/apps/'. $appName;
            $templatePath = APPS_DIR .'/console/templates/webenvironment/'. $env;

            $files = [
                'config/main-local.php',
                'config/params-local.php',
                'web/index.php',
                ['web/index-test.php'],
            ];
            foreach($files as $file) {
                $replace = null;
                if (is_array($file)) {
                    $file = $file[0];
                    $replace = $appName;
                }
                $source = $templatePath .'/'. $file;
                $dist = $distPath .'/'. $file;
                $this->copyFile($source, $dist, $replace);
            }
        }

        $environmentsConfigFile = ROOT_DIR .'/environments/index.php';
        $environmentsConfig = require($environmentsConfigFile);

        $webAssetsPath = 'apps/'. $appName .'/web/assets';
        if (!in_array($webAssetsPath, $environmentsConfig['Development']['setWritable'])) {
            $environmentsConfig['Development']['setWritable'][] = $webAssetsPath;
        }

        if (!in_array($webAssetsPath, $environmentsConfig['Production']['setWritable'])) {
            $environmentsConfig['Production']['setWritable'][] = $webAssetsPath;
        }

        $validationKeyFile = 'apps/'. $appName .'/config/main-local.php';
        if (!in_array($validationKeyFile, $environmentsConfig['Development']['setCookieValidationKey'])) {
            $environmentsConfig['Development']['setCookieValidationKey'][] = $validationKeyFile;
        }


        $validationKeyFile = 'apps/'. $appName .'/config/main-local.php';
        if (!in_array($validationKeyFile, $environmentsConfig['Production']['setCookieValidationKey'])) {
            $environmentsConfig['Production']['setCookieValidationKey'][] = $validationKeyFile;
        }

        file_put_contents($environmentsConfigFile, "<?php\nreturn ". var_export($environmentsConfig, true).';');

        $this->stdout("... ok\n");
    }

    /**
     * @param $appName
     */
    protected function generateConsoleApp($appName)
    {
        $sourcePath = APPS_DIR .'/console/templates/consoleapp';
        $distPath = APPS_DIR .'/'. $appName;

        $this->stdout("Generate ConsoleApp $appName\n");

        $files = [
            'config/.gitignore',
            'config/bootstrap.php',
            ['config/main.php'],
            ['config/params.php'],
            'controllers/.gitkeep',
            'models/.gitkeep',
        ];

        foreach($files as $file) {
            $replace = null;
            if (is_array($file)) {
                $file = $file[0];
                $replace = $appName;
            }
            $source = $sourcePath .'/'. $file;
            $dist = $distPath .'/'. $file;
            $this->copyFile($source, $dist, $replace);
        }
        $this->stdout("... ok\n");
    }

    /**
     * @param $appName
     */
    protected function generateWebApp($appName)
    {
        $sourcePath = APPS_DIR .'/console/templates/webapp';
        $distPath = APPS_DIR .'/'. $appName;

        $this->stdout("Generate WebApp $appName\n");

        $files = [
            ['assets/AppAsset.php'],
            'config/.gitignore',
            'config/bootstrap.php',
            ['config/main.php'],
            'config/params.php',
            ['controllers/SiteController.php'],
            'models/.gitkeep',
            ['views/layouts/main.php'],
            ['views/site/error.php'],
            ['views/site/index.php'],
            ['views/site/login.php'],
            'web/assets/.gitignore',
            'web/css/site.css',
            'web/.gitignore',
            'web/favicon.ico',
            'web/robots.txt'
        ];

        foreach($files as $file) {
            $replace = null;
            if (is_array($file)) {
                $file = $file[0];
                $replace = $appName;
            }
            $source = $sourcePath .'/'. $file;
            $dist = $distPath .'/'. $file;
            $this->copyFile($source, $dist, $replace);
        }
        $this->stdout("... ok\n");
    }

    /**
     * @param $appName
     */
    public function addAppNameToCommon($appName)
    {
        //添加命名空间到common里
        $commonBootstrapFile = APPS_DIR .'/common/config/bootstrap.php';
        $content = file_get_contents($commonBootstrapFile);
        $pattern = "#Yii::setAlias\('". $appName ."'#";
        if (!preg_match($pattern, $content)) {
            $content .= "\n". "Yii::setAlias('". $appName ."', dirname(dirname(__DIR__)) . '/". $appName ."');\n";
            file_put_contents($commonBootstrapFile, $content);
        }
    }

    /**
     * @param $appName
     */
    protected function checkAppName($appName)
    {
        $appPath = APPS_DIR .'/' . $appName;

        if (!is_readable(APPS_DIR)) {
            $this->stderr('Error: '. APPS_DIR .' readable fail'."\n");
            exit(self::EXIT_CODE_ERROR);
        }

        if (!is_writable(APPS_DIR)) {
            $this->stderr('Error: '. APPS_DIR .' writable fail'."\n");
            exit(self::EXIT_CODE_ERROR);
        }

        #检测是否在存
        if (is_dir($appPath)) {
            $this->stderr('Error: '. $appName ." already exists\n");
            exit(self::EXIT_CODE_ERROR);
        }

        if (strpos($appName, '/') !== false || strpos($appName, '\\') !== false ) {
            $this->stderr('Error: App name can\'t contain \\ or / characters'. "\n");
            exit(self::EXIT_CODE_ERROR);
        }

        $pattern = '#^[a-z]+$#';
        if (!preg_match($pattern, $appName)) {
            $this->stderr('Error: App name only allowed to contain a-z characters'. "\n");
            exit(self::EXIT_CODE_ERROR);
        }
    }

    /**
     * @param $source
     * @param $dist
     * @param null $appName
     */
    protected function copyFile($source, $dist, $appName = null)
    {
        @mkdir(dirname($dist), 0777, true);
        if (is_file($source)) {
            $content = file_get_contents($source);
            if (!is_null($appName)) {
                $content = str_replace('{appName}', $appName, $content);
            }
            file_put_contents($dist, $content);
        }
    }

    /**
     * @param $dir
     * @param bool $virtual
     * @return bool
     */
    protected function destroyDir($dir, $virtual = false)
    {
        $ds = DIRECTORY_SEPARATOR; 
        if (is_dir($dir) && $handle = opendir($dir)) {
            while ($file = readdir($handle)) {
                if ($file == '.' || $file == '..') {
                    continue;
                } elseif (is_dir($dir.$ds.$file)) {
                    $this->destroyDir($dir.$ds.$file);
                } else {
                    @unlink($dir.$ds.$file);
                }
            }
            closedir($handle);
            @rmdir($dir);
            return true;
        } else {
            return false;
        }
    } 
}
