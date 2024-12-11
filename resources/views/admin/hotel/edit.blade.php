<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
@endsection

<!-- main containts -->
@section('main_contents')
<div class="container">
    <h1>Edit Hotel</h1>

    <form action="{{ route('adminHotelEditProcess', ['id' => $hotel['hotel_id']]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Hotel Name -->
        <div class="form-group">
            <label for="hotel_name">Hotel Name:</label>
            <input type="text" id="hotel_name" name="hotel_name" class="form-control" value="{{ old('hotel_name', $hotel->hotel_name) }}">
            @if($errors->has('hotel_name'))
                <div class="error text-danger">{{ $errors->first('hotel_name') }}</div>
            @endif
        </div>

        <!-- Prefecture Dropdown -->
        <div class="form-group">
            <label for="prefecture_id">Prefecture:</label>
            <select id="prefecture_id" name="prefecture_id" class="form-control">
                <option value="" disabled>Select a Prefecture</option>
                @foreach ($prefectures as $prefecture)
                    <option value="{{ $prefecture->prefecture_id }}"
                        {{ old('prefecture_id', $hotel->prefecture_id) == $prefecture->prefecture_id ? 'selected' : '' }}>
                        {{ $prefecture->prefecture_name }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('prefecture_id'))
                <div class="error text-danger">{{ $errors->first('prefecture_id') }}</div>
            @endif
        </div>

        <!-- File Upload with Preview -->
        <div class="form-group">
            <label for="file_path">File (optional):</label>
            <input type="file" id="file_path" name="file_path" class="form-control" onchange="previewFile()">
            @if($errors->has('file_path'))
                <div class="error text-danger">{{ $errors->first('file_path') }}</div>
            @endif

            <!-- Image or File Preview Section -->
            <div class="preview-container" style="margin-top: 10px;">
                <img id="preview" src="{{ $hotel->file_path ? asset('assets/img/' . $hotel->file_path) : '' }}" alt="Preview" style="max-width: 200px; display: {{ $hotel->file_path ? 'block' : 'none' }};">
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Hotel</button>
    </form>
</div>
@endsection

<script>
function previewFile() {
    const fileInput = document.getElementById('file_path');
    const preview = document.getElementById('preview');

    const file = fileInput.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}
</script>
