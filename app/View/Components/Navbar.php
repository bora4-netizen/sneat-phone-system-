<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Navbar extends Component
{
  /**
     * The route.
     *
     * @var string
     */
    public $route;

    /**
     * The lang.
     *
     * @var string
     */
    public $lang;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
      $this->lang = app()->getLocale() == 'en' ? 'kh' : 'en';
      $routeName = Route::currentRouteName();
      $parameters = request()->route()->parameters();
      $parameters['lang'] = $this->lang;
      $this->route = route($routeName, $parameters);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
