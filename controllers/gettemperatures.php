<?php
include_once('../php_helpers/utils.php');

$uri = "http://dmiprivateservices.azurewebsites.net/DMIService.svc/temperatures";

$jsondata = file_get_contents($uri);

$convertToAssociativeArray = true;

$temperatures = json_decode($jsondata,$convertToAssociativeArray);

foreach ($temperatures as &$temp) {
    $temp['CaptureTime'] = parseUnixTimestamp($temp['CaptureTime']);
}

require_once '../vendor/autoload.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader,array('auto_reload'=> true));

$template = $twig->loadTemplate('temperatures.html.twig');


$parametersToTwig = array("temperatures"=>$temperatures);
echo $template->render($parametersToTwig);