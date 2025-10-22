@extends('layouts.tailwind')

@section('bg_body', 'bg-base')

@section('content')
  <div class="wrapper max-width-auth mx-auto  h-full">
    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="flex items-center justify-center pt-5 md:pt-10">
        <div class="w-full py-5 px-5 bg-white rounded-md">
          <h1 class="text-center font-semibold text-2xl">Login</h1>
          <p class="text-center text-lg mb-3">Vendor Management System</p>
          <div class="pt-2">
            <label for="username"  class="text-sm font-light mb-2">Username<sup class="sup">*</sup></label>
            <input type="text" class="w-full py-2 px-3 border rounded-lg" placeholder="Username" name="username" autofocus required>
          </div>
          <div class="pt-2">
            <label for="password"  class="text-sm font-light mb-2">Password<sup class="sup">*</sup></label>
            <input type="password" class="w-full py-2 px-3 border rounded-lg" placeholder="Password" name="password" required>
          </div>
          <div class="mt-3"></div>
          <button class="w-full rounded-md bg-button-primary text-white py-3 font-bold text-lg">Login</button>
        </div>
      </div>
    </form>
  </div>
@endsection