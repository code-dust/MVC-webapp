<?php
namespace App\Controllers;

//Posts Controller
//PHP version 5.4

class Posts
{
	//Show index page
	//return void
	public function index()
	{
		echo 'Hello from the index action in the Posts controller!';
	}
	
	
	//Show the add new page
	//return void
	
	public function addNew()
	{
		echo 'Hello from the addNew action in the Posts controller';
	}
}