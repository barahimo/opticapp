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
Route::get('/search', 'ClientController@search')->name('client.search');
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
Route::get('/searchctg', 'CategorieController@search')->name('categorie.search');
Route::resource('categorie', 'CategorieController');
/*
|--------------------------------------------------------------------------
| Web Produits
|--------------------------------------------------------------------------
*/
## AJAX ##
Route::get('/searchProduit', 'ProduitController@searchProduit')->name('produit.searchProduit');
## ## ##
Route::get('/searchpr', 'ProduitController@search')->name('produit.search');
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
Route::get('/searchFa', 'FactureController@search')->name('facture.search');
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
// Route::post('/storeP', 'CategorieController@storeP')->name('categorie.storeP');
// Route::get('/lignecommandeajoute/{id}', 'LignecommandeController@ajoute')->name('lignecommande.ajoute');
// Route::put('/affecte', 'LignecommandeController@affecte')->name('lgcommande.affecte');
// Route::get('/searchl', 'LignecommandeController@search')->name('lignecommande.search');
// Route::resource('lignecommande', 'LignecommandeController');
// Route::post('/store', 'CommandeController@storeL')->name('commande.storeL');
// Route::post('/storelp', 'CommandeController@storeLP')->name('commande.storeLP');
// Route::post('/reglement', 'CommandeController@storeLR')->name('commande.storeLR');
// Route::post('/facture', 'CommandeController@storefacture')->name('facture.store');
// Route::put('/lignecommandeupdate/{lignecommande}', 'CommandeController@updateL')->name('lgcommande.updateL');
// Route::get('/affiche', 'CommandeController@affiche')->name('commande.affiche');
// Route::get('/prodview','CommandeController@prodfunct');
// Route::get('/findProductName','CommandeController@findProductName');
// Route::get('/findPrice','CommandeController@findPrice');
// Route::get('/searchc', 'CommandeController@search')->name('commande.search');
// Route::get('/commande22', 'CommandeController@index22')->name('commande.index22');
// Route::get('/gestioncommande', 'CommandeController@index22')->name('commande.index22');
// Route::get('/gestioncommande2', 'CommandeController@index222')->name('commande.index222');
// Route::get('/getCommandes', 'CommandeController@getCommandes')->name('commande.getCommandes');
// Route::get('/getCommandes2', 'CommandeController@getCommandes2')->name('commande.getCommandes2');
// Route::get('/lignecommandedit/{lignecommande}', 'CommandeController@editL')->name('lgcommande.editL');
// Route::get('/reglements','ReglementController@index2')->name('reglement.index2');
// Route::get('/reglements2','ReglementController@index22')->name('reglement.index22');
// Route::get('/getReglements','ReglementController@getReglements')->name('reglement.getReglements');
// Route::get('/getReglements2','ReglementController@getReglements2')->name('reglement.getReglements2');
// Route::get('/searchreg', 'ReglementController@search')->name('reglement.search');
######################################################################################################
// Route::get('/admin/login', 'Auth\Admin\LoginController@showLoginForm');
// Route::post('/admin/login', 'Auth\Admin\LoginController@login')->name('adminlogin');
// Route::get('/admin/register', 'Auth\Admin\RegisterController@showRegisterForm');
// Route::post('/admin/register', 'Auth\Admin\RegisterController@register')->name('adminregister');
// Route::post('/updateF/{facture}', 'CommandeController@updateF')->name('update.facturation');
// Route::get('/index', 'FactureController@index')->name('facture.index');
// Route::get('/create', 'FactureController@create')->name('facture.create');
// Route::get('/facturation2', 'CommandeController@facture2')->name('commande.facture2');
// Route::get('/facturation22', 'CommandeController@facture22')->name('commande.facture22');
// Route::get('/select', 'HomeController@select')->name('select');
// Route::get('/selectpr', 'HomeController@selectProduit')->name('selectproduit');
// Route::get('/commandes', 'CommandeController@index2')->name('commande.index2');//commande.create
// Route::post('/storeCommande','CommandeController@store2')->name('commande.store2');//commande.store
// Route::get('/edit2/{id}','CommandeController@edit2')->name('commande.edit2');//commande.edit
// Route::post('/update2','CommandeController@update2')->name('commande.update2');//commande.update
// Route::get('/facture2/{facture}','FactureController@show2')->name('facture.show2');
// Route::get('/showCommande/{id}','CommandeController@show2')->name('commande.show2');//commande.show
// Route::get('/showReglement/{id}','ReglementController@show2')->name('reglement.show2');//reglement.show
// Route::get('/index5', 'CommandeController@index5')->name('commande.index5');//commande.index
// Route::delete('/deleteCommande/{commande}', 'CommandeController@delete')->name('commande.delete');//commande.destroy
######################################################################################################