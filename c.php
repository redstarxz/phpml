<?php
$samples = [[1], [2], [3], [4], [5]];
$targets = [31.8,14.5,10.9,9.1,7.7];


function meanSquare($samples, $targets)
{
	$func = function($value) {
		return log($value/100);
	};
	$func_sample = function($value) {
		return [log($value[0])];
	};
	// 参数变换为一元一次线性函数的参数
	$samples= array_map($func_sample, $samples);
	$targets = array_map($func, $targets);
	$func_combine = function($key, $value) {
		return $key*$value;
	};

	$n = count($samples);
	$cc = array_column($samples,0);

	$xy = array_sum(array_map($func_combine, $cc, $targets));

	$xx = array_sum($cc);
	$yy = array_sum($targets);

	$func_ss = function($v) {
		return $v*$v;
	};
	$ss_xx = array_sum(array_map($func_ss, $cc));

	// 变换后的截距 
	$b = ($xy - $xx*$yy/$n)/($ss_xx - $xx*$xx/$n);

	// 变换后的斜率 a = y' -b x'
	$a = array_sum($targets)/$n - $b*array_sum($cc)/$n;

	return ['a' => $a, 'b' => $b];
}
$ret = meanSquare($samples, $targets);

	var_dump($ret);

