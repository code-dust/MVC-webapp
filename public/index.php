
<?php

//Front Controller
//PHP version 5.4
//echo "<p>hello world</p>";
//echo 'Requested URL = "'.$_SERVER['QUERY_STRING'].'"';	

//Require the controller class
require '../App/Controllers/Posts.php';  

//Routing
require'../Core/Router.php';

$router = new Router();
//echo get_class($router);

//add the routes
$router->add('',['controller'=>'Home','action'=>'index']);
$router->add('{controller}/{action}',[]);//notice here the second parameter is not left out but is declared as an empty array
$router->add('{controller}/{id:\d+}/{action}',[]);

//Display the routing table
//echo '<pre>';
//var_dump($router->getRoutes());
//echo '</pre>';

$url = $_SERVER['QUERY_STRING'];
/*if ($router->match($url)){
	echo '<pre>';
	var_dump($router->getParams());
	echo '</pre>';
}else{
	echo "No route found for URL '$url'";
}
*/
$router->dispatch($url);
?>	
