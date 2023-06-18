<?php
namespace App\View\Components;

use Illuminate\View\Component;

class LeafletMarker extends Component
{
    public $point;
    public $popupContent;

    public function __construct($point, $popupContent)
    {
        $this->point = $point;
        $this->popupContent = $popupContent;
    }

    public function render()
    {
        return view('components.leaflet-marker');
    }
}
