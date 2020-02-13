<?php

namespace Ljsystem\Prohibited;

use Illuminate\Support\ServiceProvider;
use Ljsystem\Prohibited\Rules\Prohibited;
use Ljsystem\Prohibited\Rules\ProhibitedIf;
use Ljsystem\Prohibited\Rules\ProhibitedUnless;
use Ljsystem\Prohibited\Rules\ProhibitedWith;
use Ljsystem\Prohibited\Rules\ProhibitedWithAll;
use Ljsystem\Prohibited\Rules\ProhibitedWithout;
use Ljsystem\Prohibited\Rules\ProhibitedWithoutAll;

class ProhibitedServiceProvider extends ServiceProvider
{
    private $package = 'prohibited';
    private $translationPath = __DIR__.'/../resources/lang';

    public function boot()
    {
        $this->registerTranslations();
        $this->publishTranslations();
        $this->registerValidations();
    }

    private function registerTranslations(): void
    {
        $this->loadTranslationsFrom($this->translationPath, $this->package);
    }

    private function publishTranslations(): void
    {
        $this->publishes([
            $this->translationPath => resource_path('lang/vendor/'.$this->package),
        ]);
    }

    private function registerValidations(): void
    {
        Prohibited::register();
        ProhibitedIf::register();
        ProhibitedUnless::register();
        ProhibitedWith::register();
        ProhibitedWithAll::register();
        ProhibitedWithout::register();
        ProhibitedWithoutAll::register();
    }
}
