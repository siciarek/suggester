<?php

/**
 * Volt engine extension
 *
 * Class Volt
 */
class Volt extends \Phalcon\Mvc\View\Engine\Volt
{
    public function getCompiler()
    {
        // Load macros:
        if (empty($this->_compiler)) {
            parent::getCompiler();
            $this->partial('macros');
        }

        $compiler = parent::getCompiler();

        // View filters:

        $compiler->addFilter('merge', 'array_merge');

        $compiler->addFilter('md5', 'md5');

        $compiler->addFilter('split', function ($resolvedArgs, $exprArgs) {
            $a = explode(',', $resolvedArgs);
            $cmd = 'explode(' . trim($a[1]) . ', ' . $a[0] . ')';
            return $cmd;
        });

        $compiler->addFilter('trans', function ($resolvedArgs, $exprArgs) {
            $a = explode(',', $resolvedArgs);
            return '$this->di->getTrans()->query(' . $a[0] . ')';
        });

        $compiler->addFilter('date', function ($resolvedArgs, $exprArgs) {
            $a = explode(',', $resolvedArgs);
            return 'date(' . $a[1] . ', strtotime(' . $a[0] . '))';
        });

        $compiler->addFunction('is_granted', function($args) {
            return '$this->di->getAccess()->isGranted(' . $args . ')';
        });

        $compiler->addFunction('render', function($args) {
            return 'file_get_contents(sprintf(\'%s://%s\', $_SERVER[\'REQUEST_SCHEME\'], $_SERVER[\'HTTP_HOST\']).' . $args . ')';
        });

        $compiler->addFunction('square', function($arg) {
            return $arg . ' * ' . $arg;
        });


        return $compiler;
    }
}

$di->set('volt', function ($view, $di) {

    $cacheBaseDir = $di->getConfig()->dirs->cache . DIRECTORY_SEPARATOR . 'volt';

    if (!is_dir($cacheBaseDir)) {
        $umask = umask(0000);
        mkdir($cacheBaseDir, 0777, true);
        umask($umask);
    }

    $cacheBaseDir = realpath($cacheBaseDir);

    $options = array(
        'compiledPath' => function ($templatePath) use ($cacheBaseDir) {

            // Create cached file path
            $templatePath = realpath($templatePath);
            $cachedFilePath = $cacheBaseDir . str_replace(APPLICATION_PATH, '', $templatePath);
            $cachedFileDir = dirname($cachedFilePath);

            if (!is_dir($cachedFileDir)) {
                $umask = umask(0000);
                mkdir($cachedFileDir, 0777, true);
                umask($umask);
            }

            return $cachedFilePath;
        },
        'compileAlways' => $di->getConfig()->application->env === 'dev',
    );

    $volt = new \Volt($view, $di);
    $volt->setOptions($options);

    return $volt;
});

$di->set('view', function () use ($di) {

    $view = new \Phalcon\Mvc\View();

    $view->registerEngines(array(
        '.volt' => 'volt'
    ));

    $view->setVar('app_name', $di->getConfig()->application->name);
    $view->setVar('app_short_name', $di->getConfig()->application->short_name);
    $view->setVar('app_description', $di->getConfig()->application->description);

    return $view;
});