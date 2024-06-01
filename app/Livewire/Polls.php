<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Pool;
use Livewire\Component;

class Polls extends Component
{
	protected $listeners = [
		'pollCreated'=>'render'
	];
    public function render()
    {
			$polls = Pool::with("options.votes")->latest()->get();
        return view('livewire.polls', ['polls'=>$polls]);

    }
		public function vote(Option $option){
			$option->votes()->create();
		}
}
