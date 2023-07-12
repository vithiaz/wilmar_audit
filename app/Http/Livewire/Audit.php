<?php

namespace App\Http\Livewire;

use App\Models\Audits;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;

class Audit extends Component
{
    use WithFileUploads;

    // Binding Variable
    public $audit_date;
    public $category;
    public $sub_category;
    public $image;
    public $rating;
    public $description;

    // Model Variable
    public $Categories;
    public $SubCategories;

    protected $rules = [
        'audit_date' => 'required|date',
        'category' => 'nullable',
        'sub_category' => 'nullable',
        'image' => 'required|image|max:8192',
        'description' => 'nullable',
    ];

    public function updatedCategory() {
        $this->SubCategories = $this->Categories->where('id', '=', $this->category)->first()->sub_categories;
        $this->sub_category = '';
    }

    public function mount() {
        $this->Categories = CategoryModel::with('sub_categories')->get();
        $this->SubCategories = [];

        $this->audit_date = '';
        $this->category = '';
        $this->sub_category = '';
        $this->image = '';
        $this->description = '';
    }
    
    public function render()
    {
        return view('livewire.audit')->layout('layouts.app');
    }


    public function upload_audit() {
        $this->validate();

        $Audit = new Audits;
        $Audit->audit_date = $this->audit_date;
        $Audit->rating = $this->rating;
        $Audit->description = $this->description;
        if ($this->sub_category) {
            $Audit->sub_category_id = $this->sub_category;
        }
        $image_path = $this->image->store('audit_image');
        $Audit->picture = $image_path;

        if ($Audit->save()) {
            $msg = ['success' => 'Audit berhasil diupload'];
        } else {
            $msg = ['danger' => 'Terjadi kesalahan'];
        }

        $this->dispatchBrowserEvent('display-message', $msg);
        
        $this->audit_date = '';
        $this->category = '';
        $this->sub_category = '';
        $this->image = '';
        $this->rating = '';
        $this->description = '';
    }
}
