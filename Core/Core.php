<?php

namespace Asmoria;

use Asmoria\Modules\Handler\HandlerController;

class Core
{

    public static $classMap = [];

    public static $aliases = ['@Asmoria' => __DIR__];

    private static $list = [];

    public static $dirs = [
        'Core' => ROOT_DIR . "\\Core",
        'Modules' => ROOT_DIR . "\\Modules"
    ];

    public static $namespace = "";

    public static function Create($root = null, $mapFile = null)
    {
        if ($root === null) {
            $root = ROOT_DIR;
        }
        $root = self::makePath($root);
        if ($mapFile === null) {
            $mapFile = ROOT_DIR . '/Core/classes.php';
        }
        $options = [
            'filter' => function ($path) {
                if (is_file($path)) {
                    $file = basename($path);
                    if ($file[0] < 'A' || $file[0] > 'Z') {
                        return FALSE;
                    }
                }
                return null;
            },
            'only' => ['*.php'],
            'except' => [
                '/index.html',
                '/Core.php',
                '/.git/',
            ],
        ];

        $files = self::findFiles($root, $options);

        $map = [];
        foreach ($files as $file) {
            if (strpos($file, $root) !== 0) {
                die("Something wrong: $file\n");
            }
            $path = str_replace('\\', '/', substr($file, strlen($root)));
            $map[$path] = "'".ALIAS . substr(str_replace('/', '\\', $path), 0, -4) . "' => ROOT_DIR . '$path',";
        }
        ksort($map);
        $map = implode("\n", $map);
        $output = <<<EOD
<?php

return [
$map
];
EOD;
        if (is_file($mapFile) && file_get_contents($mapFile) === $output) {
//            echo "Nothing changed.\n";
        } else {
            file_put_contents($mapFile, $output);
//            echo "Class map saved in $mapFile\n";
        }
    }

    public static function makePath($path, $ds = DIRECTORY_SEPARATOR)
    {
        $path = rtrim(strtr($path, '/\\', $ds . $ds), $ds);
        if (strpos($ds . $path, "{$ds}.") === FALSE && strpos($path, "{$ds}{$ds}") === FALSE) {
            return $path;
        }

        $parts = [];
        foreach (explode($ds, $path) as $part) {
            if ($part === '..' && !empty($parts) && end($parts) !== '..') {
                array_pop($parts);
            } elseif ($part === '.' || $part === '' && !empty($parts)) {
                continue;
            } else {
                $parts[] = $part;
            }
        }
        $path = implode($ds, $parts);
        return $path === '' ? '.' : $path;
    }

    public static function findFiles($dir, $options = [])
    {
        if (!is_dir($dir)) {
            die("The dir argument must be a directory: $dir");
        }
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);

        if (!isset($options['basePath'])) {
            // this should be done only once
            $options['basePath'] = realpath($dir);
        }
        $handle = opendir($dir);

        if ($handle === FALSE) {
            die("Unable to open directory: $dir");
        }

        while (($file = readdir($handle)) !== FALSE) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $file;

            if (self::checkDir($path) === TRUE && is_file($path)) {

                $f = new \SplFileInfo($path);
                if ($f->getExtension() == "php") {
                    self::$list[] = $path;
                }
            } elseif (is_dir($path)) {
                static::findFiles($path, $options);
            }
        }
        closedir($handle);

        return self::$list;
    }

    private static function checkDir($path)
    {
        if (strpos($path, self::$dirs['Core']) === FALSE && strpos($path, self::$dirs['Modules']) === FALSE) {
            return FALSE;
        }
        return TRUE;
    }


    public static function getAlias($alias, $throwException = true)
    {
        if (strncmp($alias, '@', 1)) {
            // not an alias
            return $alias;
        }
        $pos = strpos($alias, '/');
        $root = $pos === FALSE ? $alias : substr($alias, 0, $pos);
        if (isset(static::$aliases[$root])) {
            if (is_string(static::$aliases[$root])) {
                return $pos === false ? static::$aliases[$root] : static::$aliases[$root] . substr($alias, $pos);
            } else {
                foreach (static::$aliases[$root] as $name => $path) {
                    if (strpos($alias . '/', $name . '/') === 0) {
                        return $path . substr($alias, strlen($name));
                    }
                }
            }
        }
        if ($throwException) {
            die("Invalid path alias: $alias");
        } else {
            return FALSE;
        }
    }

    public static function autoload($className)
    {
        self::$namespace = $className;
        if (isset(static::$classMap[$className])) {
            $classFile = static::$classMap[$className];
            if ($classFile[0] === '@') {
                $classFile = static::getAlias($classFile);
            }
        } elseif (strpos($className, '\\') !== FALSE) {
            $classFile = static::getAlias('@' . str_replace('\\', '/', $className) . '.php', FALSE);
            if ($classFile === FALSE || !is_file($classFile)) {
                return;
            }
        } else {
            \Asmoria::Create();
            throw new HandlerController(new \Exception('Cannot find file "'.$className.'" Try reload page...'));
        }
        if(!file_exists($classFile))
            throw new HandlerController(new \Exception("Wrong way"));
        require_once($classFile);

        if (!class_exists($className, FALSE) && !interface_exists($className, FALSE) && !trait_exists($className, FALSE)) {
            die("<br>Unable to find '$className' in file: $classFile. Namespace missing?");
        }
    }

}
