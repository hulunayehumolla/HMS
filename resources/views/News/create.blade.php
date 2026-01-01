@extends('layouts.app')

@section('content')
<style>
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
.image-box img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}
.image-box .btn {
    padding: 0.2rem 0.4rem;
}
</style>

<div class="row justify-content-center">
    <div class="col-md-10 col-lg-12">
        <div class="card shadow-lg">
            <div class="card-header bg-secondary text-white text-center">
                <h2 class="h4 card-title mb-0">Create New Announcement</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" id="announcementForm" class="card shadow-sm p-4 position-relative">
                    @csrf

                    <h5 class="mb-3 fw-bold text-info"><i class="fa-solid fa-bullhorn" style="color: #34b77a;"></i> New Announcement</h5>

                    {{-- Title with Quill --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <div id="editorTitle" class="form-control"></div>
                        <input type="hidden" name="title" id="title_input">
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Message with Quill --}}
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <div id="editorMessage" class="form-control"></div>
                        <input type="hidden" name="message" id="message_input">
                        @error('message')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                  {{-- Category --}}
<div class="mb-3">
    <label for="category" class="form-label">Category (<code>For whom to be posted</code>)</label>
    <select name="category[]" id="category" multiple class="form-select @error('category') is-invalid @enderror chosen-select" required>
        <option value="All" {{ old('category') && in_array('All', old('category')) ? 'selected' : '' }}>All</option>
        <option value="Announcements" {{ old('category') && in_array('Announcements', old('category')) ? 'selected' : '' }}>Announcements</option>
        <option value="Article" {{ old('category') && in_array('Article', old('category')) ? 'selected' : '' }}>Article</option>
        <option value="News" {{ old('category') && in_array('News', old('category')) ? 'selected' : '' }}>News</option>
        <option value="Publication" {{ old('category') && in_array('Publication', old('category')) ? 'selected' : '' }}>Publication</option>
        <option value="Scholarship" {{ old('category') && in_array('Scholarship', old('category')) ? 'selected' : '' }}>Scholarship</option>
        <option value="Training" {{ old('category') && in_array('Training', old('category')) ? 'selected' : '' }}>Training</option>
    </select>
    @error('category')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                    {{-- Drag & Drop Images --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Images</label>
                        <div id="dropArea" class="text-center p-2 border-dashed rounded bg-light">
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
                    <div class="position-absolute bottom-0 end-0 mb-3 mt-2 me-3 my-2">
                        <button type="submit" id="submitButton" class="btn btn-info mt-2 px-4 shadow">
                            <i class="fas fa-paper-plane me-1"></i> Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Quill CSS & JS --}}
<link href="{{ asset('css/quill.snow.css') }}" rel="stylesheet">
<script src="{{ asset('js/quill.min.js') }}"></script>

<script>
    $(".chosen-select").chosen({ no_results_text: "Oops, nothing found!", width:"100%" });
    
document.addEventListener('DOMContentLoaded', function() {
    // === Toolbar Options ===
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

    // === Initialize Editors ===
    const editorTitle = new Quill('#editorTitle', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });

    const editorMessage = new Quill('#editorMessage', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });

    // === Sync hidden inputs on form submit ===
    document.getElementById('announcementForm').addEventListener('submit', function(e) {
        document.getElementById('title_input').value = editorTitle.root.innerHTML.trim();
        document.getElementById('message_input').value = editorMessage.root.innerHTML.trim();

        if(!document.getElementById('title_input').value || !document.getElementById('message_input').value) {
            e.preventDefault();
            alert('Title and Message are required!');
            return false;
        }

        const button = document.getElementById('submitButton');
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Posting...';
        button.disabled = true;
    });

    // === Drag & Drop File Upload ===
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('images');
    const previewImages = document.getElementById('previewImages');
    let dt = new DataTransfer();

    dropArea.addEventListener('click', () => fileInput.click());

    ['dragenter','dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.add('bg-light');
        });
    });

    ['dragleave','drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.remove('bg-light');
        });
    });

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
            col.classList.add('col-3','mb-3');
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
});
</script>
@endsection
