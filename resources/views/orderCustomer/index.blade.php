@extends('layouts.pos')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
@endpush

@section('content')
<div class="content-wrapper" style="height: calc(100vh - 60px); width: 100%; overflow: hidden; padding: 0; display: flex; flex-direction: row; ">

    <div style="display: flex; flex-direction: column; align-items: flex-start; border-right: 1px solid black; margin: 5px; padding: 10px; gap: 8px; justify-content: top; align-items: center;">
        <a href="/" style="display: inline-block; padding: 12px 24px; background-color: #0052a3; color: #ffffff;
        text-decoration: none; border-radius: 8px; font-family: sans-serif; font-weight: bold;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fa-brands fa-apple"></i>
        </a>
        <a href="" style="display: inline-block; padding: 12px 24px; background-color: #0052a3; color: #ffffff;
        text-decoration: none; border-radius: 8px; font-family: sans-serif; font-weight: bold;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding:10px 42px;">
            <i class="fa-solid fa-magnifying-glass" style="font-size: 20px;"></i>
        </a>
        <a href="/" style="display: inline-block; padding: 12px 24px; background-color: #0052a3; color: #ffffff;
        text-decoration: none; border-radius: 8px; font-family: sans-serif; font-weight: bold;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding:10px 30px; display:flex; flex-direction: column; justify-content: center; align-items: center; ">
            <i class="fa-solid fa-mobile-screen-button" style="font-size: 45px; margin-bottom: 5px;"></i>
            <span style="font-size: 10px;">
                All Phone
            </span>
        </a>

        <a href="/" style="display: inline-block; padding: 12px 24px; background-color: #0052a3; color: #ffffff;
        text-decoration: none; border-radius: 8px; font-family: sans-serif; font-weight: bold;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding:10px 40px; display:flex; flex-direction: column; justify-content: center; align-items: center; ">
            <i class="fa-brands fa-apple" style="font-size: 40px; margin-bottom: 5px;"></i>
            <span style="font-size: 10px;">
                Apple
            </span>
        </a>
    </div>
    <div style=" display: flex; align-items: center; justify-content: center;">
        <h1>hi</h1>
    </div>

    <div style="display: flex; align-items: center; justify-content: center; border-left: 1px solid black;">
        <p>Right content here</p>
    </div>

</div>

@endsection

@push('script')
@endpush