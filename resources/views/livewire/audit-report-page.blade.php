@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/audit-report-page.css') }}">
@endpush


<div class="page-content audit-report-page">
    <div class="container">
        <div class="page-title">
            <h1>Laporan Audit</h1>
        </div>

        <div class="page-card">
            <h2 class="card-title">Daftar Audit</h2>
            <div class="date-container">
                <span class="title">Filter Tanggal</span>
                <div class="row-wrapper">
                    <span class="row-title">Tanggal Mulai</span>
                    <div wire:ignore class="input-container">
                        <x-flatpickr clearable onChange="startDateChange" />
                    </div>
                </div>
                <div class="row-wrapper">
                    <span class="row-title">Tanggal Selesai</span>
                    <div wire:ignore class="input-container">
                        <x-flatpickr clearable onChange="endDateChange" />
                    </div>
                </div>
                
            </div>
            <div class="table-container">
                <livewire:audit-report-table 
                    start_date='{{ $date_filter_start }}'
                    end_date='{{ $date_filter_end }}'
                />
            </div>
        </div>


    </div>
</div>

@push('script')
<script>

    // Toggle SideBar
    $( document ).ready(function () {
        setTimeout(() => {
            $('.admin-sidebar').addClass('hide');
            $('.sidebar-shadow').addClass('hide') ;
            $('#sidebar-toggle').addClass('expand');            
        }, 1500);
    })


    function startDateChange(selectedDates, dateStr, instance) {
        @this.date_filter_start = dateStr
    }

    function endDateChange(selectedDates, dateStr, instance) {
        @this.date_filter_end = dateStr
    }


</script>
@endpush