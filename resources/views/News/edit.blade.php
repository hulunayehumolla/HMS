@extends('layouts.app')

@section('content')
<style>
.image-box img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}
.image-box .btn {
    padding: 0.2rem 0.4rem;
}
#dropArea {
    width: 100%;
    min-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #555;
    border: 2px dashed #0c8cb2;
    border-radius: 8px;
    background-color: #fff;
    cursor: pointer;
    transition: background-color 0.2s, border-color 0.2s;
}
#dropArea.bg-light {
    background-color: #f8f9fa;
    border-color: #0a6f8a;
}
#dropArea p {
    margin: 0;
    font-weight: 500;
}
#editorTitle, #editorMessage {
    min-height: 120px;
    border: 1px solid #ced4da;
    border-radius: .375rem;
    padding: 8px;
    background: #fff;
}
</style>

@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
});
</script>
@endif

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-12">
        <div class="card shadow-lg">
            <div class="card-header bg-secondary text-white text-center">
                <h2 class="h4 card-title mb-0">Edit news</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="newsForm" class="card shadow-sm p-4 position-relative">
                    @csrf

                    <h5 class="mb-3 fw-bold text-info">📢 Edit news</h5>

                    {{-- Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <div id="editorTitle">{!! old('title', $news->title) !!}</div>
                        <input type="hidden" name="title" id="hiddenTitle">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <div id="editorMessage">{!! old('message', $news->message) !!}</div>
                        <input type="hidden" name="message" id="hiddenMessage">
                        @error('message')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

               {{-- Category --}}
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category[]" id="category" multiple class="form-select @error('category') is-invalid @enderror chosen-select" required>
                        <option value="All" {{ in_array('All', old('category', $news->category) ?: []) ? 'selected' : '' }}>All</option>
                        <option value="Announcements" {{ in_array('Announcements', old('category', $news->category) ?: []) ? 'selected' : '' }}>Announcements</option>
                        <option value="Article" {{ in_array('Article', old('category', $news->category) ?: []) ? 'selected' : '' }}>Article</option>
                        <option value="News" {{ in_array('News', old('category', $news->category) ?: []) ? 'selected' : '' }}>News</option>
                        <option value="Publication" {{ in_array('Publication', old('category', $news->category) ?: []) ? 'selected' : '' }}>Publication</option>
                        <option value="Scholarship" {{ in_array('Scholarship', old('category', $news->category) ?: []) ? 'selected' : '' }}>Scholarship</option>
                        <option value="Training" {{ in_array('Training', old('category', $news->category) ?: []) ? 'selected' : '' }}>Training</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                    {{-- Existing Images --}}
                    @if (!empty($news->images))
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Existing Images</label>
                            <div class="row mt-2" id="existingImages">
                                @foreach ($news->images as $image)
                                    <div class="col-3 mb-3 position-relative image-box">
                                        <img src="{{ asset($image) }}" class="img-fluid rounded shadow-sm">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-existing" data-image="{{ $image }}" style="border-radius:50%;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Drag & Drop New Images --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Add New Images</label>
                        <div id="dropArea" class="text-center p-4 border-dashed rounded bg-light">
                            <i class="fas fa-cloud-upload-alt fa-2x text-info mb-2"></i>
                            <p class="mb-0">Drag & Drop images here or click to select</p>
                            <input type="file" name="images[]" id="images" class="form-control d-none" multiple>
                        </div>
                        <div class="row mt-2" id="previewImages"></div>
                        @error('images.*')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="position-absolute bottom-0 end-0 my-3 mb-3 mr-3">
                        <button type="submit" id="submitButton" class="btn btn-info mt-2 px-4 shadow">
                            <i class="fas fa-paper-plane me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Quill --}}
<link href="{{ asset('css/quill.snow.css') }}" rel="stylesheet">
<script src="{{ asset('js/quill.min.js') }}"></script>

<script>
$(".chosen-select").chosen({ no_results_text: "Oops, nothing found!", width:"100%" });

document.addEventListener('DOMContentLoaded', function() {
    const toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, false] }],
        ['bold', 'italic', 'underline', 'strike', 'blockquote'],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'align': [] }],
        ['link', 'image', 'video'],
        [{ 'color': [] }, { 'background': [] }],
        ['code-block', 'clean']
    ];

    const editorTitle = new Quill('#editorTitle', { theme: 'snow', modules: { toolbar: toolbarOptions } });
    const editorMessage = new Quill('#editorMessage', { theme: 'snow', modules: { toolbar: toolbarOptions } });

    // Drag & Drop
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('images');
    const previewImages = document.getElementById('previewImages');
    let dt = new DataTransfer();

    dropArea.addEventListener('click', () => fileInput.click());
    ['dragenter','dragover'].forEach(eName => dropArea.addEventListener(eName, e => { e.preventDefault(); e.stopPropagation(); dropArea.classList.add('bg-light'); }));
    ['dragleave','drop'].forEach(eName => dropArea.addEventListener(eName, e => { e.preventDefault(); e.stopPropagation(); dropArea.classList.remove('bg-light'); }));
    dropArea.addEventListener('drop', e => addFiles(e.dataTransfer.files));
    fileInput.addEventListener('change', function() { addFiles(this.files); });

    function addFiles(files) {
        Array.from(files).forEach(file => { dt.items.add(file); previewFile(file); });
        fileInput.files = dt.files;
    }

    function previewFile(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.classList.add('col-3', 'mb-3');
            col.innerHTML = `
                <div class="position-relative image-box">
                    <img src="${e.target.result}" class="img-fluid rounded shadow-sm">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-new" style="border-radius:50%;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>`;
            previewImages.appendChild(col);

            col.querySelector('.remove-new').addEventListener('click', () => {
                col.remove();
                dt = new DataTransfer();
                Array.from(previewImages.querySelectorAll('img')).forEach((img,index) => {
                    const currentFile = fileInput.files[index];
                    if(img.src !== e.target.result) dt.items.add(currentFile);
                });
                fileInput.files = dt.files;
            });
        }
        reader.readAsDataURL(file);
    }

    // Remove existing
    document.querySelectorAll('.remove-existing').forEach(btn => {
        btn.addEventListener('click', function() {
            const image = this.dataset.image;
            const wrapper = this.closest('.image-box');
            Swal.fire({
                title: 'Are you sure?',
                text: "This image will be removed from the news.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0c8cb2',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    wrapper.remove();
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove_images[]';
                    input.value = image;
                    document.getElementById('newsForm').appendChild(input);
                }
            });
        });
    });

    // Submit
    document.getElementById('newsForm').addEventListener('submit', function() {
        document.getElementById('hiddenTitle').value = editorTitle.root.innerHTML;
        document.getElementById('hiddenMessage').value = editorMessage.root.innerHTML;

        const button = document.getElementById('submitButton');
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';
        button.disabled = true;
    });

});
</script>
@endsection
