<?php
require 'vendor/autoload.php';
use Phpml\Regression\LeastSquares;
use Phpml\ModelManager;


// y = AX^m =====>y' = ax' + b, y' = lny, x' = lnx, a=m, b = lnA
$samples = [[1], [2], [3], [4], [5]];
$targets = [31.8,14.5,10.9,9.1,7.7];
$func = function($value) {
    return log($value/100);
};
$func_sample = function($value) {
    return [log($value[0])];
};
// 参数变换为一元一次线性函数的参数
$samples= array_map($func_sample, $samples);
$targets = array_map($func, $targets);

$regression = new LeastSquares();
$regression->train($samples, $targets);

// save modle to file

$filepath = 'retain_liner';
$modelManager = new ModelManager();
$modelManager->saveToFile($regression, $filepath);
// 斜率
$a = $regression->getCoefficients();
// 截距
$b = $regression->getIntercept();

// y = ax +b 
echo "变换后线性函数的斜率a: ", $a[0], "\n";
echo "变换后线性函数的截距b: ", $b, "\n";
echo "y = AX^m, m=" , $a[0], "\n";
echo "y = AX^m, A=" , exp($b), "\n";

function square($a)
{
	return pow($a,2);
}
$avg = array_sum($targets)/count($targets);
$ssr = $sst = 0;
foreach ($samples as $k => $t ) {
    $ssr += square($regression->predict($t)-$avg);	
    $sst += square($targets[$k] - $avg);
}
echo "判断系数R^2= ", (float)$ssr/$sst, "\n";
// 
//
echo "预测第7天的留存 用回归, y=", exp($regression->predict([log(6)])),"\n";
echo "预测第7天的留存 用公式y = A*6^m, y=", exp($b)*pow(6,$a[0]),"\n";
