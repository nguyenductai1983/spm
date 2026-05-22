@extends(request()->has('modal') ? 'layouts.empty' : 'layouts.app')

@section('content')
    @if(request()->has('modal'))
        <div class="px-2 py-1">
            @include('prints._select_form')
        </div>
    @else
        <div class="container mx-auto p-6 max-w-4xl">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">Chọn Mẫu In (Shipping Mark)</h2>
                @include('prints._select_form')
            </div>
        </div>
    @endif
@endsection
