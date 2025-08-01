<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PlaceholderImage extends Component
{
    public $src;
    public $default;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src, $default = 'https://placehold.co/400x300/E5E5E5/000000/png?text=Foto+Tidak+Tersedia')
    {
        $this->src = $src;
        $this->default = $default;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.placeholder-image');
    }
}