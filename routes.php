<?php

/**
 * Created by PhpStorm.
 * User: Christoph Heich
 * Date: 02.06.2018
 * Time: 22:28
 */

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Pensoft\Calendar\Models\Entry;

Route::prefix('api/pensoft/calendar/')->group(function () {

	/**
	 * Route for the feed.
	 *
	 * @return json_array
	 */

	Route::get('feed/{count?}/{category?}', function ($count = null, $category = null, Request $request) {
		return Entry::formatted($count, $category);
	})->middleware('web');

});
