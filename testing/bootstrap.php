<?php

require dirname(__FILE__) . '/../application/bootstrap.php';

function unpackRepository($name)
{
	$uid = md5(microtime());
	$path = '/tmp/gitfixture' . $uid;

	exec("mkdir $path");
	$source = dirname(__FILE__) . '/fixtures/' . $name . '.tar';
	exec("tar xf $source -C $path");

	return $path . '/' . $name;
}
