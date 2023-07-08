<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;

class CategoryPage extends Component
{
    // Binding Variable
    public $category_name;
    public $category_desc;
    public $bind_category_id;
    public $sub_category_desc;

    // Model Variable
    public $Categories;

    public function mount() {
        $this->category_name = '';
        $this->category_desc = '';
        $this->bind_category_id = '';
        $this->sub_category_desc = '';

        $this->Categories = Category::get();
    }

    public function render()
    {
        return view('livewire.category-page')->layout('layouts.app');
    }

    public function store_category() {
        $this->validate([
            'category_name' => 'required|string',
            'category_desc' => 'nullable',
        ]);

        $Category = new Category;
        $Category->name = $this->category_name;
        $Category->description = $this->category_desc;
        $Category->save();

        $msg = ['success' => 'Kategori berhasil tersimpan'];
        $this->dispatchBrowserEvent('display-message', $msg);
        $this->category_name = '';
        $this->category_desc = '';
        $this->Categories = Category::get();

        $this->emitTo('categories-table', 'refreshTable');
    }

    public function store_sub_category() {
        $this->validate([
            'bind_category_id' => 'required',
            'sub_category_desc' => 'required',
        ]);

        $SubCategory = new SubCategory;
        $SubCategory->name = $this->sub_category_desc;
        $SubCategory->category_id = $this->bind_category_id;
        
        if ($SubCategory->save()) {
            $msg = ['success' => 'Sub Kategori berhasil tersimpan'];
        } else {
            $msg = ['danger' => 'Terjadi kesalahan'];
        }

        $this->dispatchBrowserEvent('display-message', $msg);
        $this->dispatchBrowserEvent('reset-subcategory');

        $this->sub_category_desc = '';
        $this->bind_category_id = '';
        $this->emitTo('sub-categories-table', 'refreshTable');
    }
    
    
    
}