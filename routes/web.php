<?php

use Illuminate\Support\Facades\Route;


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
/*
Route::group(['prefix' => '{locale}'], function () {
    Route::get('home','Controller@method');
    Route::get('otherurl','Controller@method');
});
*/

Route::get('/', [
    'as' => 'main.index',
    'uses' => 'App\Http\Controllers\MainController@index',
]);

/* 로그인이 되지 않은 페이지에 접근 했을시에 로그인 페이지로 이동 */
Route::get('login', [
    'as' => 'login',
    'uses' => 'App\Http\Controllers\auth\LoginController@index',
]);

/* 다국어 변환 */
Route::get('multilingual/{type}', [
    'as' => 'multilingual',
    'uses' => 'App\Http\Controllers\Multilingual_session@store',
]);

/*
Route::get('{locale}', function ($locale) {
    App::setLocale($locale);
    return view('auth/login');
});
*/

/* 사용자 등록 */
Route::get('auth/join', [
    'as' => 'join.create',  //form 같은 곳에서 {{ route('join.store') }}  쓰기 위해
    'uses' => 'App\Http\Controllers\auth\JoinController@index',
]);

Route::post('auth/join', [
    'as' => 'join.store',
    'uses' => 'App\Http\Controllers\auth\JoinController@store',
]);

/* 이메일 인증 리턴 */
Route::get('auth/confirm/{code}',[
    'as' => 'join.confirm',
    'uses' => 'App\Http\Controllers\auth\JoinController@confirm',
]);

/* 사용자 로그인 */
Route::get('auth/login', [
    'as' => 'login.index',
    'uses' => 'App\Http\Controllers\auth\LoginController@index',
]);

Route::post('auth/login', [
    'as' => 'login.store',
    'uses' => 'App\Http\Controllers\auth\LoginController@store',
]);

/* 사용자 아웃 */
Route::get('auth/logout', [
    'as' => 'logout.destroy',
    'uses' => 'App\Http\Controllers\auth\LoginController@destroy',
]);

/* 비번 찾기 */
Route::get('auth/pwchange', [
    'as' => 'pwchange.index',
    'uses' => 'App\Http\Controllers\auth\PwchangeController@index',
]);

Route::post('auth/pwchange', [
    'as' => 'pwchange.store',
    'uses' => 'App\Http\Controllers\auth\PwchangeController@store',
]);

/*비밀번호 변경 리턴 */
Route::get('auth/reset/{token}', [
    'as' => 'reset.index',
    'uses' => 'App\Http\Controllers\auth\ResetController@index',
]);

Route::post('auth/reset', [
    'as' => 'reset.store',
    'uses' => 'App\Http\Controllers\auth\ResetController@store',
]);

/* 로그인 사용자만 볼수 있는 페이지를 group 로 묶는다 */
Route::group(['middleware' => ['auth']], function () {
    /* 마이페이지 */
    Route::get('member/mypage', [
        'as' => 'mypage.index',
        'uses' => 'App\Http\Controllers\member\MypageController@index',
    ]);

    Route::post('member/mypage', [
        'as' => 'mypage.pw_change',
        'uses' => 'App\Http\Controllers\member\MypageController@pw_change',
    ]);

    Route::post('member/infosave', [
        'as' => 'mypage.infosave',
        'uses' => 'App\Http\Controllers\member\InfosaveController@store',
    ]);

    //type = member_id = 순번
    Route::get('filedown/{type}', [
        'as' => 'filedown',
        'uses' => 'App\Http\Controllers\FiledownController@store',
    ]);
 });
