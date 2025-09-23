<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landing::index');

// Auth
$routes->get('/login', 'Auth::login');        // show form
$routes->post('/login', 'Auth::loginJWT');    // process login
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::store');
$routes->get('/logout', 'Auth::logout');


$routes->group('', ['filter' => 'jwt-auth'], function($routes){
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'jwt-auth']);

  $routes->get('dashboard', 'Dashboard::index');
    $routes->get('doctors', 'Doctors::index');
    $routes->get('patients', 'Patients::index');
 


    // Dashboard / web routes (forms, pages)
$routes->get('doctors', 'Doctors::index');
$routes->get('doctors/create', 'Doctors::create');
$routes->post('doctors/store', 'Doctors::store');
$routes->get('doctors/edit/(:num)', 'Doctors::edit/$1');
$routes->post('doctors/update/(:num)', 'Doctors::update/$1');
$routes->get('doctors/delete/(:num)', 'Doctors::delete/$1');




    $routes->get('patients/create', 'Patients::create');
    $routes->post('patients/store', 'Patients::store');
    $routes->get('patients/edit/(:num)', 'Patients::edit/$1');
    $routes->post('patients/update/(:num)', 'Patients::update/$1');
    $routes->get('patients/delete/(:num)', 'Patients::delete/$1');
    $routes->get('patients/profile/(:num)', 'Patients::profile/$1');

    $routes->get('patients/profile/(:num)', 'Patients::profile/$1');



  // Appointments
$routes->get('appointments', 'Appointments::index');
$routes->get('appointments/create', 'Appointments::create');
$routes->post('appointments/store', 'Appointments::store');

// Appointment actions
$routes->get('appointments/reschedule/(:num)', 'Appointments::create/$1'); // show form prefilled
$routes->post('appointments/reschedule/(:num)', 'Appointments::store/$1'); // submit reschedule

$routes->get('appointments/delete/(:num)', 'Appointments::delete/$1');
$routes->get('appointments/markCompleted/(:num)', 'Appointments::markCompleted/$1');
$routes->get('appointments/export/csv', 'Appointments::exportCSV');
$routes->get('appointments/complete/(:num)', 'Appointments::markCompleted/$1');
$routes->get('appointments/cancel/(:num)', 'Appointments::delete/$1');
$routes->get('api/doctors-appointments', 'Appointments::doctorsWithAppointments');


 
});





