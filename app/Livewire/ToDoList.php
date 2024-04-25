<?php

namespace App\Livewire;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Todo;
use Livewire\WithPagination;

class ToDoList extends Component
{
    
    use WithPagination;
    #[Validate('required|min:3|max:50', )]
    public $name ; 
    public $search;
    public function create(){
        $validated = $this->validateOnly('name');
        Todo::create($validated);
        $this->reset('name');
        session()->flash('success',"created succesfully");
        
        
    }
    public function delete($todoid)
    {
        Todo::findOrFail($todoid)->delete();
    }
    public function render()
    {
        
        return view('livewire.to-do-list',
        ['todos' => Todo::latest()->where('name','like', "%{$this->search}%")->paginate(5)]);

    }
}
