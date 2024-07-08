<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Space;

class Chart extends Component
{
    public $labels;
    public $data;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $spaces = Space::where('provider_id', auth()->id())
            ->withCount(['bookings as unique_bookings_count' => function($query) {
                $query->select(\DB::raw('count(distinct user_id)'));
            }])
            ->get();

        $this->labels = $spaces->pluck('space_name');
        $this->data = $spaces->pluck('unique_bookings_count');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chart', [
            'labels' => $this->labels,
            'data' => $this->data,
        ]);
    }
}
