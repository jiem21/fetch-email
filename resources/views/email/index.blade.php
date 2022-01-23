@extends('layouts.app')

@section( 'content' )
    <div class="w-4/5 mx-auto shadow-lg shadow-grey-100/50 my-8">
        @include('layouts.alert')

        <div class="buttons-wrapper flex px-8 py-4">
            <a href="{{ url('fetch-emails') }}" class="p-4 bg-green-300 text-black font-bold mr-3 rounded">Fetch emails</a>
        </div>

        <div class="wrapper p-4">
            @if ( count( $emails ) > 0 )
                <div class="table-wrapper mb-4">
                    <div class="flex">
                        <div class="border text-center py-2 w-1/4">Sender</div>
                        <div class="border text-center py-2 w-1/4">Date</div>
                        <div class="border text-center py-2 w-1/4">Title</div>
                        <div class="border text-center py-2 w-1/4">Content</div>
                    </div>
    
                    @foreach ($emails as $email)
                        <div class="flex">
                            <div class="border text-center py-2 w-1/4">{{ $email->sender }}</div>
                            <div class="border text-center py-2 w-1/4">{{ $email->received_date }}</div>
                            <div class="border text-center py-2 w-1/4">{{ $email->title }}</div>
                            <div class="border text-center py-2 w-1/4">{{ Str::limit( $email->content, 150,'...' ) }}</div>
                        </div>
                    @endforeach
                </div>

                {{ $emails->links() }}
            @else
                <h2 class="w-full text-center font-bold text-lg">No emails found</h2>
            @endif
        </div>
    </div>
@endsection