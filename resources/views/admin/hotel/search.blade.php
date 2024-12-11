<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

<!-- main containts -->
@section('main_contents')
<div class="page-wrapper search-page-wrapper">
    <h2 class="title">検索画面</h2>
    <hr>
    <div class="search-hotel-name">
        <form action="{{ route('adminHotelSearchResult') }}" method="get">
            @csrf
            <input 
                type="text" 
                name="hotel_name" 
                value="{{ old('hotel_name') }}"
                placeholder="ホテル名"
            >
            <select name="prefecture_id" class="form-control">
                <option value="">Select Prefecture (Optional)</option>
                @foreach ($prefectures as $prefecture)
                    <option value="{{ $prefecture->prefecture_id }}"
                        {{ old('prefecture_id') == $prefecture->prefecture_id ? 'selected' : '' }}>
                        {{ $prefecture->prefecture_name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">検索</button>
            @error('hotel_name')
                <div class="error text-danger">何も入力されていません</div>
            @enderror
        </form>
    </div>
    <hr>
</div>
@yield('search_results')
@endsection
