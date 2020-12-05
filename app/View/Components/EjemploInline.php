<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EjemploInline extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius
</div>
blade;
    }
}
