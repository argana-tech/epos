<?php


$lock2=lock2();
	$lock=lock2ex();
	fclose($lock);
sleep(2);
	echo "B";
fclose($lock2);


function lock()
{
	$lock = 'C:\xampp\jsnr43\fuel\app\config/../files/ppt.lock';

	if (!$fp=fopen($lock, "a")) die("can't lock");
	flock($fp, LOCK_EX);
	return $fp;
}

function lock2()
{
	$lock = 'C:\xampp\jsnr43\fuel\app\config/../files/ppt2.lock';

	if (!$fp=fopen($lock, "a")) die("can't lock");
	flock($fp, LOCK_SH | LOCK_NB);
	return $fp;
}

function lock2ex()
{
	$lock = 'C:\xampp\jsnr43\fuel\app\config/../files/ppt2.lock';

	if (!$fp=fopen($lock, "a")) die("can't lock");
	flock($fp, LOCK_EX | LOCK_NB);
	return $fp;
}