<?php

namespace Ykocaman\LaravelTurkce\Commands;

use Illuminate\Auth\Console\AuthMakeCommand;

class AuthMakeTrCommand extends AuthMakeCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'make:auth:tr';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Üye giriş ve kayıt ekranlarını Türkçe\'ye çevirir';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $this->createDirectories();

        $this->exportViews();

        file_put_contents(
            app_path('Http/Controllers/HomeController.php'),
            $this->compileControllerStub()
        );

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/../../stubs/routes.stub'),
            FILE_APPEND
        );

        $this->info('Üye paneli oluşturuldu.');
    }

    /**
     * Export the authentication views.
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            $view = resource_path('views/' . $value);

            copy(
                __DIR__ . '/../../stubs/views/' . $key,
                $view
            );
        }
    }

    /**
     * Compiles the HomeController stub.
     * @return string
     */
    protected function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__ . '/../../stubs/controllers/HomeController.stub')
        );
    }
}
