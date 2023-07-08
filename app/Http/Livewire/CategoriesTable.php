<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class CategoriesTable extends PowerGridComponent
{
    use ActionButton;


    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'refreshTable',
                'deleteCategory',
            ]);
    }

    public function refreshTable() {
        $this->fillData();
    }


    public function deleteCategory($id) {
        // $subCategoryId = $id[0];

        $category = Category::find($id)->first();
        if ($category) {
            if ($category->delete()) {
                $msg = ['success' => 'Kategori dihapus'];
            } else {
                $msg = ['danger' => 'Terjadi kesalahan'];
            }
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->fillData();
            $this->emitTo('sub-categories-table', 'refreshTable');
        }
    }





    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Category>
     */
    public function datasource(): Builder
    {
        return Category::with('sub_categories');
        // return Category::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('description')
            ->addColumn('sub_categories_count', fn (Category $model) => $model->sub_categories->count())
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Category $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->hidden()
                ->sortable(),

            Column::make('Kategori', 'name')
                ->searchable(),
                
            Column::make('Deskripsi', 'description')
                ->searchable(),
                
            Column::make('Jumlah sub kategori', 'sub_categories_count'),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->searchable()
                ->hidden()
        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            // Filter::inputText('name'),
            // Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Category Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
            Button::make('edit', 'Hapus')
                ->class('btn table-delete-button')
                ->emit('deleteCategory', ['id']),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Category Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($category) => $category->id === 1)
                ->hide(),
        ];
    }
    */
}
