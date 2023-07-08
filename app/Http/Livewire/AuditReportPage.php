<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AuditReportPage extends Component
{
    // Binding Variable
    public $date_filter_start;
    public $date_filter_end;

    public function updatedDateFilterStart() {
        $this->emitTo('audit-report-table', 'setStartDate', $this->date_filter_start);
    }
    
    public function updatedDateFilterEnd() {
        $this->emitTo('audit-report-table', 'setEndDate', $this->date_filter_end);
    }

    public function mount() {
        $this->date_filter_start = '';
        $this->date_filter_end = '';
    }


    public function render()
    {
        return view('livewire.audit-report-page')->layout('layouts.app');
    }
}
