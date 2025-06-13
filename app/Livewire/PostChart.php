<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostChart extends Component
{
    public $chartData = [];

    public function mount() {
        $this->chartData = Post::selectRaw('DATE(created_at) as date, COUNT(*) as total')->groupBy('date')->orderBy('date')->pluck('total', 'date')->toArray();
    }

    public function render()
    {
        return view('livewire.post-chart');
    }
}
