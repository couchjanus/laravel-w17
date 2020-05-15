<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Blade;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		/*
		 * Регистрируется директива шаблонизатора Blade
		 * Пример обращения к виджету: @widget('menu')
		 * Можно передать параметры в виджет:
		 * @widget('menu', [$data1,$data2...])
		 */
		Blade::directive('widget', function ($name) {			
			return "<?php echo app('widget')->show($name); ?>";
		});
		
		/*
		 * Регистрируется (добавляем) каталог для хранения шаблонов виджетов
		 * views/widgets
		 */
        $this->loadViewsFrom(resource_path('views/widgets'), 'widgets');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        App::singleton('widget', function(){
			return new \App\Widgets\Widget();
		});

    }
}
