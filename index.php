<?php
// Practice routing

// Start a session
session_start();

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload file
require_once('vendor/autoload.php');

// Create an instance of the Base class
$f3 = Base::instance();

// Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// Define a default route
$f3->route('GET /', function() {
    // Display a view
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a breakfast route
$f3->route('GET /breakfast', function(){
   // Display breakfast view
    $view = new Template();
    echo $view->render('views/breakfast.html');
});

// Define a lunch route
$f3->route('GET /lunch', function(){
    // Display lunch view
    $view = new Template();
    echo $view->render('views/lunch.html');
});

// Define a continental breakfast route
$f3->route('GET /breakfast', function(){
    // Display continental breakfast view
    $view = new Template();
    echo $view->render('views/bfast-cont.html');
});

// Define a brunch buffet route
$f3->route('GET /lunch/brunch/buffet', function(){
    // Display brunch view
    $view = new Template();
    echo $view->render('views/buffet.html');
});

// Define a route with a parameter
$f3->route('GET /@item', function($f3, $params){
    $item = $params['item'];
    $foodsWeServe = array('spaghetti', 'enchiladas', 'pad thai', 'lumpia');

    if(!in_array($item, $foodsWeServe))
    {
        echo "We don't serve $item";
    }

    switch($item)
    {
        case 'spaghetti' : echo "<h3>I like $item with meatballs.</h3>";
        break;
        case 'pizza' : echo "<h3> Pepperoni or veggie?</h3>";
        break;
        case 'tacos' : echo "<h3>We don't have $item</h3>";
        break;
        case 'bagel' : $f3->reroute("/breakfast");
        default: $f3->error(404);
    }
});

// Define a route with 2 parameters (first and last name)
$f3->route('GET /@first/@last', function($f3, $params){
    $first = ucfirst($params['first']);
    $last = ucfirst($params['last']);
    echo "<h3>Hello, $first $last!</h3>";
});

// Define an order route
$f3->route('GET /order', function(){

    // Display form1
    $view = new Template();
    echo $view->render('views/form1.html');
});

// Define a meal route
$f3->route('POST /order-process', function(){

    //print_r($_POST);
    $_SESSION['food'] = $_POST['food'];

    // Display form2
    $view = new Template();
    echo $view->render('views/form2.html');
});

// Define a summary route
$f3->route('POST /summary', function(){

    //print_r($_POST);
    $_SESSION['meal'] = $_POST['meal'];

    // Display form2
    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run Fat-free
$f3->run();
