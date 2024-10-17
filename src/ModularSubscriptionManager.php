<?php

namespace HoceineEl\LaravelModularSubscriptions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use HoceineEl\LaravelModularSubscriptions\Modules\BaseModule;

class ModularSubscriptionManager
{
    protected Collection $modules;

    public function __construct()
    {
        $this->modules = collect();
        $this->loadModulesFromConfig();
    }

    protected function loadModulesFromConfig(): void
    {
        $configModules = Config::get('modular-subscriptions.modules', []);
        foreach ($configModules as $moduleClass) {
            $this->registerModule($moduleClass);
        }
    }

    public function registerModule(string $moduleClass): void
    {
        $module = new $moduleClass();

        if (!$module instanceof BaseModule) {
            throw new \InvalidArgumentException("Module must be an instance of BaseModule");
        }

        $this->modules->put($module->getName(), $module);
    }

    public function getRegisteredModules(): Collection
    {
        return $this->modules;
    }

    public function getActiveModules(): Collection
    {
        $moduleModel = config('modular-subscriptions.models.module');
        $activeModuleNames = $moduleModel::where('is_active', true)->pluck('name');

        return $this->modules->filter(function ($module, $key) use ($activeModuleNames) {
            return $activeModuleNames->contains($key);
        });
    }
}
