<?php 
namespace App\Routing;

use App\Routing\Route;
use App\System\TemplateRenderer;
use App\Validators\FormValidator;

$renderer = new TemplateRenderer();

Route::get('/', 'Default@index');

Route::get('/deneme', function() use ($renderer){
    $renderer->render_template('default');
});

Route::post('/deneme', function(){
    $validator = new FormValidator();
    $response = $validator->validator($_POST)
        ->textMin(['text', 'text2'], [5, 5])
        ->textMax(['text', 'text2'], [20, 20])
        ->require(['text', 'text2'])
        ->validate();

    $response2 = $validator->validator($_POST)
    ->textMin(['text', 'text2'], [5, 5])
    ->textMax(['text', 'text2'], [20, 20])
    ->regex(['text', 'text2'], ['/[0-9]+/', '/[a-z]+/'], ['containNumber', 'containChar'], ['sayı içermeli', 'harf içermeli']) 
    ->csrf()
    ->validate();

    echo '<pre>';
    print_r($response);
    echo '<br>';
    print_r($response2);
    echo '</pre>';

});

Route::get('/deneme/{id}', function($id){
    echo $id;
});

Route::get('/deneme/{id}/{id}', function($id, $ids){
    echo $id;
    echo '<br>';
    echo $ids;
});

Route::get('/deneme/{name}', 'Test@index');

Route::get('/middleware', function(){
    echo 'middleware test page';
}, ['Auth']);

Route::get('/{name}', function($name){
    echo $name;
});

?>