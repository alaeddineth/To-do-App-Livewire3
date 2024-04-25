<?php

namespace App\Livewire;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Todo;

class ToDoList extends Component
{
    
    #[Validate('required|min:3|max:50', )]
    public $name ; 
    public function create(){
        $validated = $this->validateOnly('name');
        Todo::create($validated);
        $this->reset('name');
        session()->flash('success',"created succesfully");
        
        
    }
    public function render()
    {
        return view('livewire.to-do-list');

    }
}
