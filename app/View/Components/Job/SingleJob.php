<?php

namespace App\View\Components\Job;

use Illuminate\View\Component;

class SingleJob extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $title,
        public string $type,
        public string $location,
        public string $salary,
        public string $description = '',
        public string $url,
        public string $image,
        public string $classType,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.job.single-job');
    }
}
