<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 17:42
 */
namespace Notadd\Administration;

use Illuminate\Contracts\Foundation\Application;
use Notadd\Administration\Controllers\AdminController;
use Notadd\Foundation\Administration\Administration;
use Notadd\Foundation\Module\Abstracts\Module;

/**
 * Class Extension.
 */
class ModuleServiceProvider extends Module
{
    /**
     * @var \Notadd\Foundation\Administration\Administration
     */
    protected $administration;

    /**
     * ModuleServiceProvider constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->administration = $app[Administration::class];
    }

    /**
     * Boot service provider.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $administrator = new Administrator($this->app['events'], $this->app['router']);
        $administrator->registerPath('admin');
        $administrator->registerHandler(AdminController::class . '@handle');
        $this->administration->setAdministrator($administrator);
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../resources/translations'), 'administration');
        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'admin');
        $this->publishes([
            realpath(__DIR__ . '/../resources/mixes/administration/dist/assets/admin') => public_path('assets/admin'),
            realpath(__DIR__ . '/../resources/mixes/neditor')                          => public_path('assets/neditor'),
        ], 'public');
    }

    /**
     * Install module.
     *
     * @return bool
     */
    public static function install()
    {
        return true;
    }

    /**
     * Uninstall module.
     *
     * @return mixed
     */
    public static function uninstall()
    {
        return true;
    }
}
