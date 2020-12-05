<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Ejemplo extends Component
{

    public $message;
    public $posts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message, $posts)
    {
        $this->message = $message;
        $this->posts = $posts;
    }

    public function my_list($item4){
        return [
            "Item 1",
            "Item 2",
            "Item 3",
            $item4
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ejemplo');
    }
}
