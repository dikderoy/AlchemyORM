<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 06.01.14
 * Time: 6:39
 */

class TestedClass
{
	public $text;
}

$time = microtime(true);
for ($i = 0; $i < 10000; $i++) {
	$instance       = new TestedClass();
	$instance->text = 'abc';
	unset($instance);
}
$time = microtime(true) - $time;

print "\nhard coded: $time\n";

$class = 'TestedClass';
$time  = microtime(true);
for ($i = 0; $i < 10000; $i++) {
	$instance       = new $class();
	$instance->text = 'abc';
	unset($instance);
}
$time = microtime(true) - $time;

print "casted: $time\n";