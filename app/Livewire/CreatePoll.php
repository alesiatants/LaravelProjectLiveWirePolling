<?php

namespace App\Livewire;
use Livewire\Attributes\Validate;
use App\Models\Pool;
use Livewire\Component;

class CreatePoll extends Component
{
	#[Validate('required|min:3|max:255')]

	public $title;
	#[Validate([
			'options' => 'required|array|min:1|max:10',
			'options.*' => 'required|min:3|max:255'
	], message:
	[
		'options.*'=>"The option can't be empty!"
	])]
		public $options = [''];
		
	
    public function render()
    {
        return view('livewire.create-poll');
    }
		public function addOption(){
			$this->options[]='';
		}
		public function removeOption($index){
				unset($this->options[$index]);
				$this->options=array_values($this->options);
		}
		public function updated($prop) {
			$this->validateOnly($prop);
	 }
		public function createPoll(){
			$this->validate();
			Pool::create([
				'title' => $this->title
			])->options()->createMany(collect($this->options)
			->map(fn($option)=> ['name'=>$option])
			->all()
		);
			/*foreach($this->options as $optionName){
				$poll->options()->create([
					'name'=>$optionName
				]);
			}*/
			$this->reset(['title','options']);
			$this->dispatch('pollCreated');
		}
}
