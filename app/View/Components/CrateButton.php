<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CrateButton extends Component
{
    public $text;
    public $icon;
    public $buttonColor;
    public $buttonShadow;
    public $link;

    /**
     * Create a new component instance.
     *
     * @param string $text
     * @param string $icon
     * @param string $color
     * @param string $shadow
     * @param string $link
     */
    public function __construct($text, $icon, $color = '', $shadow = '', $link = '')
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->buttonColor = $color;
        $this->buttonShadow = $shadow;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.crate-button');
    }
}
