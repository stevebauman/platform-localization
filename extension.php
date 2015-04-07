<?php

use Illuminate\Foundation\Application;
use Cartalyst\Extensions\ExtensionInterface;
use Cartalyst\Settings\Repository as Settings;
use Cartalyst\Permissions\Container as Permissions;

return [

	/*
	|--------------------------------------------------------------------------
	| Name
	|--------------------------------------------------------------------------
	|
	| This is your extension name and it is only required for
	| presentational purposes.
	|
	*/

	'name' => 'Localization',

	/*
	|--------------------------------------------------------------------------
	| Slug
	|--------------------------------------------------------------------------
	|
	| This is your extension unique identifier and should not be changed as
	| it will be recognized as a new extension.
	|
	| Ideally, this should match the folder structure within the extensions
	| folder, but this is completely optional.
	|
	*/

	'slug' => 'stevebauman/localization',

	/*
	|--------------------------------------------------------------------------
	| Author
	|--------------------------------------------------------------------------
	|
	| Because everybody deserves credit for their work, right?
	|
	*/

	'author' => 'Steve Bauman',

	/*
	|--------------------------------------------------------------------------
	| Description
	|--------------------------------------------------------------------------
	|
	| One or two sentences describing the extension for users to view when
	| they are installing the extension.
	|
	*/

	'description' => 'A localization manager for platform',

	/*
	|--------------------------------------------------------------------------
	| Version
	|--------------------------------------------------------------------------
	|
	| Version should be a string that can be used with version_compare().
	| This is how the extensions versions are compared.
	|
	*/

	'version' => '1.0.0',

	/*
	|--------------------------------------------------------------------------
	| Requirements
	|--------------------------------------------------------------------------
	|
	| List here all the extensions that this extension requires to work.
	| This is used in conjunction with composer, so you should put the
	| same extension dependencies on your main composer.json require
	| key, so that they get resolved using composer, however you
	| can use without composer, at which point you'll have to
	| ensure that the required extensions are available.
	|
	*/

	'require' => [
        'platform/access'
    ],

	/*
	|--------------------------------------------------------------------------
	| Autoload Logic
	|--------------------------------------------------------------------------
	|
	| You can define here your extension autoloading logic, it may either
	| be 'composer', 'platform' or a 'Closure'.
	|
	| If composer is defined, your composer.json file specifies the autoloading
	| logic.
	|
	| If platform is defined, your extension receives convetion autoloading
	| based on the Platform standards.
	|
	| If a Closure is defined, it should take two parameters as defined
	| bellow:
	|
	|	object \Composer\Autoload\ClassLoader      $loader
	|	object \Illuminate\Foundation\Application  $app
	|
	| Supported: "composer", "platform", "Closure"
	|
	*/

	'autoload' => 'composer',

	/*
	|--------------------------------------------------------------------------
	| Service Providers
	|--------------------------------------------------------------------------
	|
	| Define your extension service providers here. They will be dynamically
	| registered without having to include them in app/config/app.php.
	|
	*/

	'providers' => [
        'Stevebauman\Translation\TranslationServiceProvider',
        'Stevebauman\Localization\LocalizationServiceProvider',
	],

	/*
	|--------------------------------------------------------------------------
	| Routes
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| any custom routing logic here.
	|
	| The closure parameters are:
	|
	|	object \Cartalyst\Extensions\ExtensionInterface  $extension
	|	object \Illuminate\Foundation\Application        $app
	|
	*/

	'routes' => function(ExtensionInterface $extension, Application $app)
	{
        Route::group(array(
            'prefix' => admin_uri() . '/localization',
            'namespace' => 'Stevebauman\Localization\Controllers\Admin'
        ), function()
        {
            Route::group(array('prefix' => 'locales'), function()
            {
                Route::get('/' , ['as' => 'admin.localization.locales.index', 'uses' => 'LocaleController@index']);
                Route::post('/', ['as' => 'admin.localization.locales.index', 'uses' => 'LocaleController@executeAction']);

                Route::get('grid', ['as' => 'admin.localization.locales.grid', 'uses' => 'LocaleController@grid']);

                Route::get('create', ['as' => 'admin.localization.locales.create', 'uses' => 'LocaleController@create']);
                Route::post('create', ['as' => 'admin.localization.locales.create', 'uses' => 'LocaleController@store']);

                Route::get('{id}'   , ['as' => 'admin.localization.locales.edit'  , 'uses' => 'LocaleController@edit']);
                Route::post('{id}'  , ['as' => 'admin.localization.locales.edit'  , 'uses' => 'LocaleController@update']);
                Route::delete('{id}', ['as' => 'admin.localization.locales.delete', 'uses' => 'LocaleController@delete']);

                Route::group(array('prefix' => '{locale_id}/translations'), function()
                {
                    Route::get('/', ['as' => 'admin.localization.locales.translations.index', 'uses' => 'TranslationController@index']);

                    Route::get('grid', ['as' => 'admin.localization.locales.translations.grid', 'uses' => 'TranslationController@grid']);

                    Route::get('create', ['as' => 'admin.localization.locales.translations.create', 'uses' => 'TranslationController@create']);
                    Route::post('create', ['as' => 'admin.localization.locales.translations.create', 'uses' => 'TranslationController@store']);

                    Route::get('{id}'   , ['as' => 'admin.localization.locales.translations.edit'  , 'uses' => 'TranslationController@edit']);
                    Route::post('{id}'  , ['as' => 'admin.localization.locales.translations.edit'  , 'uses' => 'TranslationController@update']);
                    Route::delete('{id}', ['as' => 'admin.localization.locales.translations.delete', 'uses' => 'TranslationController@delete']);
                });
            });
        });
	},

	/*
	|--------------------------------------------------------------------------
	| Database Seeds
	|--------------------------------------------------------------------------
	|
	| Platform provides a very simple way to seed your database with test
	| data using seed classes. All seed classes should be stored on the
	| `database/seeds` directory within your extension folder.
	|
	| The order you register your seed classes on the array below
	| matters, as they will be ran in the exact same order.
	|
	| The seeds array should follow the following structure:
	|
	|	Vendor\Namespace\Database\Seeds\FooSeeder
	|	Vendor\Namespace\Database\Seeds\BarSeeder
	|
	*/

	'seeds' => [

	],

	/*
	|--------------------------------------------------------------------------
	| Permissions
	|--------------------------------------------------------------------------
	|
	| Register here all the permissions that this extension has. These will
	| be shown in the user management area to build a graphical interface
	| where permissions can be selected to allow or deny user access.
	|
	| For detailed instructions on how to register the permissions, please
	| refer to the following url https://cartalyst.com/manual/permissions
	|
	*/

	'permissions' => function(Permissions $permissions)
	{
        $permissions->group('localization', function($g)
        {
            $g->name = 'Localization';

            $g->permission('localization.locales.index', function($p)
            {
                $p->label = 'View Locales';

                $p->controller('Stevebauman\Localization\Controllers\Admin\LocaleController', 'index, grid');
            });

            $g->permission('localization.local.create', function($p)
            {
                $p->label = 'Create Locales';

                $p->controller('Stevebauman\Localization\Controllers\Admin\LocaleController', 'create, store');
            });

            $g->permission('localization.local.edit', function($p)
            {
                $p->label = 'Update Locales';

                $p->controller('Stevebauman\Localization\Controllers\Admin\LocaleController', 'edit, update');
            });

            $g->permission('localization.local.delete', function($p)
            {
                $p->label = 'Delete Locales';

                $p->controller('Stevebauman\Localization\Controllers\Admin\LocaleController', 'delete');
            });
        });
	},

	/*
	|--------------------------------------------------------------------------
	| Widgets
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| all your custom widgets here. Of course, Platform will guess the
	| widget class for you, this is just for custom widgets or if you
	| do not wish to make a new class for a very small widget.
	|
	*/

	'widgets' => function()
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Settings
	|--------------------------------------------------------------------------
	|
	| Register any settings for your extension. You can also configure
	| the namespace and group that a setting belongs to.
	|
	*/

	'settings' => function(Settings $settings, Application $app)
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Menus
	|--------------------------------------------------------------------------
	|
	| You may specify the default various menu hierarchy for your extension.
	| You can provide a recursive array of menu children and their children.
	| These will be created upon installation, synchronized upon upgrading
	| and removed upon uninstallation.
	|
	| Menu children are automatically put at the end of the menu for extensions
	| installed through the Operations extension.
	|
	| The default order (for extensions installed initially) can be
	| found by editing app/config/platform.php.
	|
	*/

	'menus' => [

		'admin' => [

			[
				'slug'  => 'admin-stevebauman-localization',
				'name'  => 'Localization',
				'class' => 'fa fa-language',
				'uri'   => 'localization',
				'regex' => '/:admin\/localization/i',
                'children' => [
                    [
                        'slug'  => 'admin-stevebauman-localization-locales',
                        'name'  => 'Locales',
                        'class' => 'fa fa-globe',
                        'uri'   => 'localization/locales',
                        'regex' => '/:admin\/localization/locales/i',
                    ],
                ]
			],

		],

		'main' => [

		],

	],

];
