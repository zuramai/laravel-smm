<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\News;
use App\Activity;
use App\User;
use App\Ticket;
use App\Config;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $web_config = Config::all()->pluck('value', 'name');
        config(['web_config' => $web_config]);

        view()->composer('*', function($view) {
            

            if(Auth::check()){
                $news = News::orderBy('id','desc')->limit(5)->get(); 
                $last_login = Activity::where('user_id',auth()->user()->id)->where('type','Login')->orderBy('id','desc')->first();
                $unread_user = Ticket::where('read_by_user', false)->where('user_id',Auth::user()->id)->count();
                config(['unread_ticket_user'=> $unread_user]);
                config(['news'=>$news]);

                if(Auth::user()->level == 'Developer') {
                    $unread_dev = Ticket::where('read_by_admin', false)->count();
                    config(['unread_ticket_dev'=> $unread_dev]);
                }
            }

        });

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
