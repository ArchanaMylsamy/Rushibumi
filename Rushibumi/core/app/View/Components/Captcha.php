<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Captcha extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $path;
    public $hasLevel;

    public function __construct($path = null, $hasLevel=null)
    {
        $this->path = $path;
        $this->hasLevel = $hasLevel;
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Temporarily disable captcha rendering across all forms.
        return '';
    }
}
