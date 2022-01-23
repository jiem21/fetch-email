@extends('layouts.app')

@section( 'content' )
    <!-- <h1 class="text-4xl">Welcome</h1> -->
    <div class="w-1/2 mx-auto shadow-lg shadow-grey-100/50 my-8">
        @include('layouts.alert')

        <div class="form-wrapper px-8 py-4">
            <form method="POST" action="{{ url('/user/register') }}" class="mx-auto w-1/2">
                {{ csrf_field() }}
                <div class="form-group flex flex-col mb-2">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" class="rounded border border-grey-100 w-full">
                </div>

                <div class="form-group flex flex-col mb-2">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" class="rounded border border-grey-100 w-full">
                </div>

                <button class="bg-sky-500 text-white bold p-2 rounded">Save Email</button>
            </form>
        </div>

        <div class="wrapper p-4">
            @if ( count( $users ) > 0 )
                <div class="flex">
                    <div class="border text-center py-2 w-1/3">Email Address</div>
                    <div class="border text-center py-2 w-1/3">Password</div>
                    <div class="border text-center py-2 w-1/3">Action</div>
                </div>

                @foreach ($users as $user)
                <div class="flex">
                    <div class="border text-center py-2 w-1/3">{{ $user->email }}</div>
                    <div class="border text-center py-2 w-1/3">{{ $user->password }}</div>
                    <div class="flex row border p-2 w-1/3 justify-between">
                        <a href="{{ url('user/email') . '/' . $user->id }}" class="font-bold">View Mails</a>
                        <a href="{{ url('user/delete') . '/' . $user->id }}" class="font-bold text-red-600">Delete</a>
                    </div>
                </div>
                @endforeach
            @else
                <h2 class="w-full text-center font-bold text-lg">No users found</h2>
            @endif
        </div>
    </div>
@endsection