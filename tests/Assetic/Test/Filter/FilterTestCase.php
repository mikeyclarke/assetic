<?php

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2012 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Assetic\Test\Filter;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\ProcessBuilder;

abstract class FilterTestCase extends \PHPUnit_Framework_TestCase
{
    public static function assertMimeType($expected, $data, $message = null)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);

        $actual = file_exists($data) ? $finfo->file($data) : $finfo->buffer($data);

        self::assertEquals($expected, $actual, $message);
    }

    protected function findExecutable($name, $serverKey = null)
    {
        if (isset($_SERVER[$serverKey])) {
            return $_SERVER[$serverKey];
        }

        $finder = new ExecutableFinder();

        return $finder->find($name);
    }

    protected function checkNodeModule($bin, $path, $module)
    {
        $pb = new ProcessBuilder(array($bin, '-e', 'require(\''.$module.'\')'));
        $pb->setEnv('NODE_PATH', $path);

        return 0 === $pb->getProcess()->run();
    }
}
