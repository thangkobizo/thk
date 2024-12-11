<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="container">
        <h1>Create Hotel</h1>

        <form action="{{ route('adminHotelCreateProcess') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hotel Name -->
            <div class="form-group">
                <label for="hotel_name">Hotel Name:</label>
                <input type="text" id="hotel_name" name="hotel_name" class="form-control" value="{{ old('hotel_name') }}">
                @if ($errors->has('hotel_name'))
                    <div class="error text-danger">{{ $errors->first('hotel_name') }}</div>
                @endif
            </div>


            <div class="form-group">
                <label for="prefecture_id">Prefecture:</label>
                <select id="prefecture_id" name="prefecture_id" class="form-control">
                    <option value="" disabled selected>Select a Prefecture</option>
                    @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}"
                            {{ old('prefecture_id') == $prefecture->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->prefecture_name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('prefecture_id'))
                    <div class="error text-danger">{{ $errors->first('prefecture_id') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="file_path">File (optional):</label>
                <input type="file" id="file_path" name="file_path" class="form-control">
                @if ($errors->has('file_path'))
                    <div class="error text-danger">{{ $errors->first('file_path') }}</div>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Create Hotel</button>
        </form>
    </div>
@endsection
