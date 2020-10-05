<?php

namespace Samrat131\ColumnSortable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ColumnSortableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('sortable_link', function($name) {
            $name = str_replace(["(",")"], ["",""], $name);
            return "<?php echo app()->make('sortcolumn')->getLink($name); ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton('sortcolumn', function () {
            return new SortColumn;
        });
    }
}
