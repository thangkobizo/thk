@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/search.scss')
@endsection

@section('main_contents')
<div class="page-wrapper search-page-wrapper">
    <h2 class="title">予約情報検索</h2>
    <hr>
    <div class="search-booking-form">
        <form action="{{ route('adminBookingSearchResult') }}" method="get">
            @csrf
            <input 
                type="text" 
                name="customer_name" 
                value="{{ old('customer_name') }}"
                placeholder="顧客名"
            >
            <input 
                type="text" 
                name="customer_contact" 
                value="{{ old('customer_contact') }}"
                placeholder="顧客連絡先"
            >
            <input 
                type="datetime-local" 
                name="checkin_time" 
                value="{{ old('checkin_time') }}"
                placeholder="チェックイン日時"
            >
            <input 
                type="datetime-local" 
                name="checkout_time" 
                value="{{ old('checkout_time') }}"
                placeholder="チェックアウト日時"
            >
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
        @error('checkout_time')
            <div class="error text-danger">チェックアウト日時はチェックイン日時より後である必要があります</div>
        @enderror
    </div>
    <hr>
</div>
@yield('search_results')
@endsection
