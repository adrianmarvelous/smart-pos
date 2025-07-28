<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Store;
use App\Models\UserHasRole;
use App\Models\Main_menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('dashboard.index', function ($view) {
            $user_id = session('user_id');
            $store_id = session('store_id');
            $role = UserHasRole::with('hasRole')
                                ->where('user_id',$user_id)
                                ->where('store_id',$store_id)
                                ->first();

            // dd($role);
            $menu = Main_menu::with('menu_sub')
                                ->where('role','>=',$role->role_id)
                                ->get();
            // dd($menu);
            $roles = UserHasRole::with('hasRole')
                                ->where('user_id',$user_id)
                                ->get();
                                
            foreach ($roles as $key => $value) {
                $store = Store::where('id',$value->store_id)->first();
                $user_store[] = $store;
            }
            
            $view->with([
                'user_store' => $user_store,
                'role_info' => $role,
                'main_menu' => $menu
            ]);
        });
    }
}
