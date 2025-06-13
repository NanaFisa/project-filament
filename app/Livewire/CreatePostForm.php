<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePostForm extends Component
{
    public $title = '';
    public $content = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ];

    public function save() {
        $this->validate();

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Post berjaya ditambah!');
        $this->reset(['title','content']);
    }

    public function render()
    {
        return view('livewire.create-post-form');
    }
}
