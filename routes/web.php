<?php

use App\Http\Controllers\CommandeController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Psy\Command\EditCommand;

/*
|--------------------------------------------------------------------------
| Web Auth
|--------------------------------------------------------------------------
*/
Auth::routes();
/*
|--------------------------------------------------------------------------
| Web Welcome
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});
/*
|--------------------------------------------------------------------------
| Web HOME && APPLICATION
|--------------------------------------------------------------------------
*/
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/application', 'HomeController@application')->name('app.home');
/*
|--------------------------------------------------------------------------
| Web Users
|--------------------------------------------------------------------------
*/
Route::get('findEmail','UserController@findEmail')->name('user.findEmail');
Route::get('user/{id}/editUser','UserController@editUser')->name('user.editUser');
Route::resource('user', 'UserController');
/*
|--------------------------------------------------------------------------
| Web Companies
|--
*/
Route::post('/saveImage','CompanyController@saveImage')->name('company.saveImage');
Route::resource('company', 'CompanyController');
/*
|--------------------------------------------------------------------------
| Web Clients
|--------------------------------------------------------------------------
*/
## AJAX ##
Route::get('/searchClient', 'ClientController@searchClient')->name('client.searchClient');
## ## ##
Route::resource('client', 'ClientController');
/*
|--------------------------------------------------------------------------
| Web Categories
|--------------------------------------------------------------------------
*/
## AJAX ##
Route::get('/createProduit/{id}', 'CategorieController@ajouteProduit')->name('categorie.produit');
Route::get('/searchCategorie', 'CategorieController@searchCategorie')->name('categorie.searchCategorie');
## ## ##
Route::resource('categorie', 'CategorieController');
/*
|--------------------------------------------------------------------------
| Web Produits
|--------------------------------------------------------------------------
*/
## AJAX ##
Route::get('/searchProduit', 'ProduitController@searchProduit')->name('produit.searchProduit');
## ## ##
Route::resource('produit', 'ProduitController');
/*
|--------------------------------------------------------------------------
| Web LigneCommandes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Web Commandes
|--------------------------------------------------------------------------
*/
## AJAX ##
Route::post('/commande/{commande}', 'CommandeController@update')->name('commande.update');
Route::get('/codeFacture', 'CommandeController@codeFacture')->name('commande.codeFacture');
Route::get('/getBalance', 'CommandeController@getBalance')->name('commande.getBalance');
Route::get('/getCommandes5', 'CommandeController@getCommandes5')->name('commande.getCommandes5');
Route::get('/productsCategory','CommandeController@productsCategory')->name('commande.productsCategory');
Route::get('/infosProducts','CommandeController@infosProducts')->name('commande.infosProducts');
Route::get('/editCommande','CommandeController@editCommande')->name('commande.editCommande');
## ## ##
Route::post('/facture2', 'CommandeController@storefacture2')->name('facture.store2');
Route::get('/facturation', 'CommandeController@facture')->name('commande.facture');
Route::get('/balance', 'CommandeController@balance')->name('commande.balance');

Route::resource('commande', 'CommandeController')->except('update');
/*
|--------------------------------------------------------------------------
| Web Règlements
|--------------------------------------------------------------------------
*/
## AJAX ##
Route::post('/storeReglements','ReglementController@store2')->name('reglement.store2');
Route::post('/storeReglements3','ReglementController@store3')->name('reglement.store3');
Route::post('/avoir','ReglementController@avoir')->name('reglement.avoir');
Route::get('/getReglements3','ReglementController@getReglements3')->name('reglement.getReglements3');
## ## ##

Route::get('/reglements/create2','ReglementController@create2')->name('reglement.create2');
Route::get('/reglements/create3','ReglementController@create3')->name('reglement.create3');

Route::delete('/deleteReglement/{reglement}', 'ReglementController@delete')->name('reglement.delete');

Route::resource('reglement', 'ReglementController');
/*
|--------------------------------------------------------------------------
| Web Factures
|--------------------------------------------------------------------------
*/
## AJAX ##
Route::get('/searchFacture', 'FactureController@searchFacture')->name('facture.searchFacture');
## ## ##
Route::resource('facture', 'FactureController');
/*
|--------------------------------------------------------------------------
| Web n'a pas utlisés
|--------------------------------------------------------------------------
*/

############################################################################################################"
/*
|--------------------------------------------------------------------------
| AUTRE ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/foo', function () {
    Artisan::call('storage:link');
    return "done => storage:link";
});
Route::get('/reset/{email}', function (Request $request) {
    try
    {
        $user = User::where('email',$request->email)->first(); 
        $user->password = Hash::make('password');
        $user->save();
        return 'Done';
    }
    catch(Throwable $e)
    {
        return $e->getMessage();
    }
});
Route::get('/link', function () {        
    $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/app-optic-2/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
    symlink($targetFolder,$linkFolder);
    echo 'Symlink process successfully completed';
});
######################################################################################################

######################################################################################################