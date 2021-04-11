<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ExamplesTest extends TestCase
{
    public function testDoctrineExample()
    {
        $exampleDir = dirname(__DIR__) . '/examples/doctrine';

        $ret = 0;
        $out = '';
        exec("cd '{$exampleDir}' && composer install -o 2>&1", $out, $ret);
        static::assertSame(0, $ret, implode("\n", $out));

        $ret = 0;
        $out = '';
        exec(PHP_BINARY . " '{$exampleDir}/example.php' 2>&1", $out, $ret);
        static::assertSame(0, $ret, implode("\n", $out));
    }
}
