<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

/**
 * This is a basic benchmark test for Engine...
 */
include '../vendor/autoload.php';

$engine = new \StringTemplate\Engine;
$template = "These are {foo} and {bar}. Those are {goo.b} and {goo.v}";
$vars = array(
    'foo' => 'bar',
    'baz' => 'friend',
    'goo' => array('a' => 'b', 'c' => 'd')
);
$replace = function () use ($engine, $template, $vars)
{
    $engine->render($template, $vars);
};

$templateSprintf = "These are %s and %s. Those are %s and %s";
$varsSprintf = array(
    'bar', 'friend', 'b', 'd'
);
$sprintf = function () use ($template, $varsSprintf)
{
    $args = array_merge(array($template), $varsSprintf);
    call_user_func_array('sprintf', $args);
};

$varsSearch = array(
    'foo', 'baz', 'goo.a', 'goo.c'
);
$varsReplace = array(
    'bar', 'friend', 'b', 'd'
);

$strReplace = function () use ($template, $varsSearch, $varsReplace)
{
    str_replace($varsSearch, $varsReplace, $template);
};

function benchmark($f, $title = '', $iterations = 100000)
{
    echo '<br><b>', $title, '</b><br>';
    $start = microtime(true);
    for ($i = 0; $i < $iterations; $i++)
        $f();
    $time = microtime(true) - $start;
    echo 'Time: ', $time, '<br>';
    echo 'Average: ', $time / $iterations, '<br>';
    echo 'MemoryPeak: ', memory_get_peak_usage(), ' (meaningful only if you run one benchmark at time)';
}

benchmark($replace, 'Engine benchmark');
benchmark($sprintf, 'Sprintf benchmark');
benchmark($strReplace, 'StrReplace benchmark');