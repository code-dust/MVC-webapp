<?php 

namespace Core;

class Router
{
//Associative array of routes (the routing table)
//@var array
protected $routes = [];
	
	
//Parameters from the matched route
//@var array
protected $params = [];
	
	
//Add a route to the routing table
//@param string $route The route URL
//@param array Parameters (controller, action, etc.)
//@return void
	
	
public function add($route, $params){
	//$this->routes[$route] = $params;
	
	//convert the route to a regular expression: escape forward slashes
	$route = preg_replace('/\//', '\\/', $route);
	
	//convert variables e.g {controller}
	$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
	
	//Add start and end dilimiters,  and case insensitive flag
	$route = '/^' . $route . '$/i';
	
	$this->routes[$route] = $params;
	
}
	
	
	
//Get all the routes from the routing table
//@return array	
public function getRoutes(){
	return $this->routes;
}
	
//Match the route to the routes in the routing table, setting the $params property if a route is found.
//@param string $url The route URL
//@return boolean true if a match is found, false otherwise
public function match($url)
{
	/*foreach ($this->routes as $route => $params){
		if ($url == $route){
			$this->params = $params;
			return true;
		}
	}
	return false;
	*/
	
	
	
	//Match to the fixed URL format : controller/action
	//$reg_exp = "/^(?P<controller>[a-z]+)\/(?P<action>[a-z]+)$/";
	
	foreach ($this->routes as $route => $params){
			if (preg_match($route,$url,$matches)){
		       //Get named capture group values
		       //$params = [];
		 
		       foreach ($matches as $key => $match){
			       if (is_string($key)){
				       $params[$key] = $match;
			       }
		       }
		
		       $this->params = $params;
		       return true;//allows it exit this block of code as soons as the url matches a rregular expression out of a list of regular expressions
	     }

	}
	return false;    
}

	
//Get the currently matched parameters
//@return array
public function getParams()
{
    return $this->params;
}
	
public function dispatch($url)
{
	if ($this->match($url)){
		$controller = $this->params['controller'];
		$controller = $this->convertToStudlyCaps($controller);
		$controller = "App\Controllers\\$controller";
		
		if(class_exists($controller)){
			$controller_object = new $controller();
			
			$action = $this->params['action'];
			$action = $this->convertToCamelCase($action);
			
			if (is_callable([$controller_object, $action])){
				$controller_object->$action();
			}
			else{
				echo "Method $action (in controller $controller) not found";
			}
		}
		else{
			echo "Controller class $controller not found";
		}	
	}
	else{
		echo "No route matched.";
	}
	}
	
	
	
	
	
	protected function convertToStudlyCaps($string)
	{
		return str_replace(' ','', ucwords(str_replace('-',' ',$string)));
	}
	
	protected function convertToCamelCase($string)
	{
		return lcfirst($this->convertToStudlyCaps($string));
	}
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	






















































?>