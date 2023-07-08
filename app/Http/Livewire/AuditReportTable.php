<?php

namespace App\Http\Livewire;

use App\Models\Audits;
use App\Exports\AuditsExport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// use PowerComponents\LivewirePowerGrid\Detail;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, Detail, PowerGrid, PowerGridComponent, PowerGridColumns};

final class AuditReportTable extends PowerGridComponent
{
    use ActionButton;

    // Binding Variable
    public string $start_date;
    public string $end_date;


    // Listeners
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'setStartDate',
                'setEndDate',
                'deleteCategory',
            ]);
    }

    public function setStartDate($param_date) {
        $this->start_date = $param_date;
        $this->fillData();
    }

    public function setEndDate($param_date) {
        $this->end_date = $param_date;
        $this->fillData();
    }

    
    
    // Custom Functions
    public function xlsx_export() {
        $current_time = Carbon::now()->timestamp;
        $filename = 'audit_report_' . $current_time . '.xlsx';
        return (new AuditsExport($this->start_date, $this->end_date))->download($filename);
    }
    
    

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Header::make()
                ->includeViewOnTop('components.audit-report-table-header-export')
                ->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            Detail::make()
                ->view('components.audit-report-table-row-details')
                // ->options(['picture' => 'picture'])
                ->showCollapseIcon(),

        ];
    }

    public function datasource(): Builder
    {
        if ($this->end_date) {
            $builder = Audits::with([
                'category',
                'sub_category',
            ])->where([
                ['audit_date', '>=', $this->start_date],
                ['audit_date', '<=', $this->end_date],
            ]);
        } else {
            $builder = Audits::with([
                'category',
                'sub_category',
            ])->where('audit_date', '>=', $this->start_date);
        }

        return $builder;
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
        return [
            'sub_category' => [
                'name',
            ],
        ];
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
            ->addColumn('audit_date')
            ->addColumn('audit_date_formatted', fn (Audits $model) => Carbon::parse($model->audit_date)->format('d/m/Y'))
            ->addColumn('description')
            ->addColumn('picture')
            ->addColumn('category', fn(Audits $model) => $model->category ? $model->category->name : '')
            ->addColumn('sub_category', fn(Audits $model) => $model->sub_category ? $model->sub_category->name : '')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Audits $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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
            
            Column::make('Tanggal', 'audit_date_formatted', 'audit_date')

            
                ->searchable()
                ->sortable(),
            
            Column::make('Kategori', 'category')
                ->searchable(),
            
            Column::make('Sub Kategori', 'sub_category')
                ->searchable(),
            
            Column::make('Deskripsi Audit', 'description')
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->searchable()
                ->hidden()
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::datepicker('audit_date_formatted', 'audit_date'),

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
     * PowerGrid Audits Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('audits.edit', ['audits' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('audits.destroy', ['audits' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Audits Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($audits) => $audits->id === 1)
                ->hide(),
        ];
    }
    */
}
