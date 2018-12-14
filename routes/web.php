<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Nova::routes();
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('dropdown', function() {

	return '
		<link href="' . asset('css/app.css') . '" rel="stylesheet">
		<link href="' . asset('vendor/dropdown/bootstrap.css') . '" rel="stylesheet">
		<link href="' . asset('vendor/dropdown/bootstrap-theme.css') . '" rel="stylesheet">
		<style>
			body { margin: 20px; }
			.dropdown-submenu {
				position: relative;
			}

			.dropdown-submenu .dropdown-menu {
				top: 0;
				left: 100%;
				margin-top: -1px;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="' . asset('vendor/dropdown/bootstrap.js') . '" defer></script>
		<div class="bg-30 hover:bg-40 mr-3 rounded">
			<div class="dropdown relative">
				<button class="px-3" type="button" data-toggle="dropdown">
					Tutorials
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline">
						<a tabindex="-1" href="#">HTML</a>
					</li>
					<li class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline">
						<a tabindex="-1" href="#">CSS</a>
					</li>
					<li class="dropdown-submenu cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline">
						<a class="test" tabindex="-1" href="#">New dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a tabindex="-1" href="#">2nd level dropdown</a></li>
							<li><a tabindex="-1" href="#">2nd level dropdown</a></li>
							<li class="dropdown-submenu">
								<a class="test" href="#">Another dropdown <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#">3rd level dropdown</a></li>
									<li><a href="#">3rd level dropdown</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				$("a.test").on("click", function(e) {
					$(this).next("ul").toggle();
					e.stopPropagation();
					e.preventDefault();
				});
			});
		</script>
	';

});
