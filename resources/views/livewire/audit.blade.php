@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/audit-page.css') }}">
@endpush

<div class="page-content audit-page">
    <div class="container">
        <div class="page-title">
            <h1>AUDIT FORM</h1>
        </div>

        <form wire:submit.prevent='upload_audit' class="page-card" enctype="multipart/form-data">
            <div class="row-wrapper">
                <div class="row-item-wrapper form-wrapper">
                    <div class="form-input-wrapper row">
                        <span class="form-title">Tanggal</span>
                        <div class="form-items">
                            <input wire:model='audit_date' class="form-input-default" type="date">
                            @error('audit_date')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Kategori</span>
                        <div class="form-items">
                            <select wire:model='category' id="input-category-select">
                                <option value="" selected hidden>Pilih kategori</option>
                                @foreach ($Categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Sub Kategori</span>
                        <div class="form-items">
                            <select wire:model='sub_category' id="input-category-select">
                                <option value="" selected hidden>Pilih sub kategori</option>
                                @forelse ($SubCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                @empty
                                    <option value="">...</option>
                                @endforelse
                            </select>
                            @error('sub_category')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Upload Foto</span>
                        <div class="form-items">
                            <input wire:model='image' id="image-upload-form" class="form-control" type="file" accept="image/*" capture="camera" >
                            @error('image')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper column">
                        <span class="form-title">Deskripsi</span>
                        <div class="form-items">
                            <textarea wire:model='description' rows="4" class="form-input-default" type="text" placeholder="Deskripsi kategori ..."></textarea>
                            @error('description')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row-item-wrapper">
                    <div class="preview-image-wrapper">
                        <div class="image-container">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="audit_preview_image">
                            @else
                                <div id="no-image-container" class="no-image">
                                    <i class="fa-regular fa-image"></i>
                                    <span>upload foto ...</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="button-wrapper">
                        <button type="submit" class="btn submit-button">Upload Audit</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

@push('script')
<script>

    $('#no-image-container').click(function () {
        $('#image-upload-form').click()
    })

</script>
@endpush