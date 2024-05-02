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
    public $new_id;
    
    #[Validate('required|min:3|max:50', )]
    public $new_name; 

    public function create(){
        $validated = $this->validateOnly('name');
        Todo::create($validated);
        $this->reset('name');
        session()->flash('success',"created succesfully");
        $this->resetPage();
    }
    public function delete($todoid)
    {   try{
        Todo::findOrFail($todoid)->delete();
        }catch(Exception $e) {

            session()->flash('error','Failed to delete todo!');
            return;
        }
        
    }
    public function toggle($todoid)
    {
        $todo = todo::find($todoid);
        $todo->completed = !$todo->completed;
        $todo->save();
    }
     public function update_todos($todoid)
    {
        $this->new_id= $todoid;
        $this->name = todo::find($todoid)->name;
       
    } 
    public function canceledit(){
        $this->reset('new_id','new_name');

    }
    public function update()
    {
        $this->validateOnly(('new_name'));
        Todo::find($this->new_id)->update(
            [
                'name' => $this->new_name

            ]
        );
        $this->canceledit();
    }
    public function render()
    {
        
        return view('livewire.to-do-list',
        ['todos' => Todo::latest()->where('name','like', "%{$this->search}%")->paginate(5)]);

    }
}
