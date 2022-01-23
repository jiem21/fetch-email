@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="m-2 p-4 bg-red-300 text-red-600 border border-red-500 rounded font-bold text-base">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="m-2 p-4 bg-green-300 text-green-600 border border-green-500 rounded font-bold text-base">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="m-2 p-4 bg-red-300 text-red-600 border border-red-500 rounded font-bold text-base">
        {{session('error')}}
    </div>
@endif