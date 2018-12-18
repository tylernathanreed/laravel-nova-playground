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
		<style>
			body { margin: 20px; }
			.w-dropdown {
				width: 200px;
			}
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
			<div class="relative">
				<button class="px-3" type="button" data-toggle="dropdown">
					Tutorials
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu absolute pin-l float-left w-dropdown mt-1 list-reset bg-white border-20 rounded shadow-md">
					<li>
						<a tabindex="-1" href="#" class="block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">HTML</a>
					</li>
					<li>
						<a tabindex="-1" href="#" class="block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">CSS</a>
					</li>
					<li class="h-px my-2 overflow-hidden bg-50"></li>
					<li class="dropdown-submenu cursor-pointer hover:text-primary">
						<a tabindex="-1" href="#" class="test block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">
							New dropdown <span class="caret"></span>
						</a>
						<ul class="dropdown-menu absolute pin-l float-left w-dropdown mt-1 list-reset bg-white border-20 rounded shadow-md">
							<li>
								<a tabindex="-1" href="#" class="block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">2nd level dropdown</a>
							</li>
							<li class="disabled">
								<a tabindex="-1" href="#" class="block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">2nd level dropdown</a>
							</li>
							<li class="dropdown-submenu cursor-pointer hover:text-primary">
								<a href="#" class="test block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">
									Another dropdown <span class="caret"></span>
								</a>
								<ul class="dropdown-menu absolute pin-l float-left w-dropdown mt-1 list-reset bg-white border-20 rounded shadow-md">
									<li>
										<a href="#" class="block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">3rd level dropdown</a>
									</li>
									<li>
										<a href="#" class="block p-4 cursor-pointer text-black hover:text-primary whitespace-no-wrap no-underline outline-none hover:bg-30">3rd level dropdown</a>
									</li>
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
