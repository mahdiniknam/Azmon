<?php
namespace App\Providers;

use App\Models\AdminActivityLog;
use App\Models\SystemLog;
use App\Support\helpers\RequestContext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RequestContext::class, fn() => new RequestContext());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        App::setLocale(Session::get('locale', config('app.locale')));
        //jalali
        Blade::directive('jdate', function ($expression) {
            // استفاده: @jdate($date) یا @jdate($date, 'Y/m/d')
            return "<?php echo jdate(...[$expression]); ?>";
        });
        Event::listen('eloquent.updated: *', function (string $event, array $data) {

            [$model] = $data;
            $this->logChange('update', $model);
        });

        Event::listen('eloquent.created: *', function (string $event, array $data) {
            [$model] = $data;
            $this->logChange('create', $model);
        });

        Event::listen('eloquent.deleted: *', function (string $event, array $data) {
            [$model] = $data;
            $this->logChange('delete', $model);
        });
    }
    protected function logChange(string $action, Model $model): void
    {
        $context       = app(RequestContext::class);
        $ignoredModels = [
            AdminActivityLog::class,
            SystemLog::class,
        ];

        if (in_array(get_class($model), $ignoredModels, true)) {
            return;
        }
//        ignore change with console or ....
        if (! $context->route) {
            return;
        }

        // فقط admin route
        if (! $context->isAdmin) {
            return;
        }

        $changes = null;
        if ($action === 'create') {
            foreach ($model->getAttributes() as $field => $value) {
                $changes[$field] = [
                    'old' => null,
                    'new' => $value,
                ];
            }
        }

        if ($action === 'update') {
            foreach ($model->getDirty() as $field => $newValue) {
                $changes[$field] = [
                    'old' => $model->getOriginal($field),
                    'new' => $newValue,
                ];
            }
        }

        // حذف فیلدهای سیستمی
        foreach (['updated_at', 'created_at'] as $ignore) {
            unset($changes[$ignore]);
        }

        AdminActivityLog::create([
            'admin_id'   => auth()->user()->id ?? null,
            'model_type' => $model->getMorphClass(),
            'model_id'   => $model->getKey(),
            'route'      => $context->route,
            'ip'         => $context->ip,
            'changes'    => json_encode($changes),
        ]);
    }
}
