<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class UsersTable extends PowerGridComponent
{
    use ActionButton;

    
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'refreshTable',
                'deleteUser',
            ]);
    }

    public function refreshTable() {
        $this->fillData();
    }

    public function deleteUser($id) {
        $user = User::find($id)->first();

        if ($user) {
            if ($user->delete()) {
                $msg = ['success' => 'User dihapus'];
            } else {
                $msg = ['danger' => 'Terjadi kesalahan'];
            }
            $this->dispatchBrowserEvent('display-message', $msg);
            $this->fillData();
        }
    }

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return User::where('id', '!=', Auth::user()->id);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('user_type')
            ->addColumn('email')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->hidden(),

            Column::make('Tipe User', 'user_type')
                ->searchable()
                ->sortable(),

            Column::make('Nama', 'name')
                ->searchable(),

            Column::make('Email', 'email')
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->hidden(),
                
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->searchable()
                ->hidden(),
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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
       return [
           Button::make('delete', 'Hapus')
               ->class('btn table-delete-button')
               ->emit('deleteUser', ['id']),

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
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($user) => $user->id === 1)
                ->hide(),
        ];
    }
    */
}
