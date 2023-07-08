@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/category-page.css') }}">
@endpush

<div class="page-content category-page">
    <div class="container">
        <div class="page-title">
            <h1>Tambah Kategori Temuan</h1>
        </div>

        <form wire:submit.prevent='store_category' class="page-card">
            <div class="row-wrapper">
                <div class="row-item-wrapper form-wrapper">
                    <div class="form-input-wrapper row">
                        <span class="form-title">Nama Kategori</span>
                        <div class="form-items">
                            <input wire:model='category_name' class="form-input-default" type="text" placeholder="Nama Kategori">
                            @error('category_name')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper column">
                        <span class="form-title">Deskripsi</span>
                        <div class="form-items">
                            <textarea wire:model='category_desc' rows="4" class="form-input-default" type="text" placeholder="Deskripsi kategori ..."></textarea>
                            @error('category_desc')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row-item-wrapper">
                    <div class="button-wrapper">
                        <button class="btn submit-button">Tambah Kategori</button>
                    </div>
                </div>
            </div>
        </form>

        <form wire:submit.prevent='store_sub_category' class="page-card">
            <h2 class="card-title">Tambah Sub Kategori</h2>
            <div class="form-wrapper">
                <div class="form-input-wrapper row">
                    <span class="form-title">Kategori</span>
                    <div class="form-items">
                        <select wire:model='bind_category_id' id="input-category-select">
                            <option value="" selected hidden>Pilih kategori</option>
                            @foreach ($Categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('bind_category_id')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div wire:ignore.self class="row-wrapper sub-category-form">
                <div class="row-item-wrapper form-wrapper">
                    <div class="form-input-wrapper column">
                        <span class="form-title">Deskripsi</span>
                        <div class="form-items">
                            <textarea wire:model='sub_category_desc' rows="4" class="form-input-default" type="text" placeholder="Deskripsi sub kategori ..."></textarea>
                            @error('sub_category_desc')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row-item-wrapper">
                    <div class="button-wrapper">
                        <button type="submit" class="btn submit-button">Tambah Sub Kategori</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="page-title mt-2">
            <h1>List Kategori / Sub Kategori</h1>
        </div>

        <div class="page-card">
            <h2 class="card-title">Daftar Kategori</h2>
            <div class="table-container">
                <livewire:categories-table />
            </div>
        </div>

        <div class="page-card">
            <h2 class="card-title">Daftar Sub Kategori</h2>
            <div class="table-container">
                <livewire:sub-categories-table />
            </div>
        </div>


    </div>
</div>

@push('script')
<script>

    // // handle sub_categories, category select
    function handleCategorySelect() {
        let selectedCategory = $('#input-category-select').val()

        if (selectedCategory) {
            $('.sub-category-form').addClass('show')
        } else {
            $('.sub-category-form').removeClass('show')
        }
    }

    $('#input-category-select').change(function () {
        handleCategorySelect()
        @this.sub_category_desc = ''
    })
    
    $( window ).on('reset-subcategory', function (e) {
        handleCategorySelect()
    })


    
    // Toggle SideBar
    $( document ).ready(function () {
        
        setTimeout(() => {
            $('.admin-sidebar').addClass('hide');
            $('.sidebar-shadow').addClass('hide') ;
            $('#sidebar-toggle').addClass('expand');            
        }, 1500);
    })    

</script>
@endpush