<div class="mb-6 p-4 bg-gray-50 border rounded text-gray-700">
    <p><strong>COMMODITY:</strong> {{ $data->COMMODITY ?? '' }}</p>
    <p><strong>MODEL:</strong> {{ $data->MODEL ?? '' }}</p>
    <p><strong>SỐ LƯỢNG IN:</strong> {{ $data->NumSerial ?? 1 }} trang</p>
</div>

<form action="{{ route('prints.generate', $data->ID) }}" method="POST" target="_blank" id="printSelectForm">
    @csrf
    <input type="hidden" name="source" value="{{ $source ?? 'default' }}">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach ($templates as $tid)
            <label
                class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors flex flex-col items-center">
                <input type="radio" name="template_id" value="{{ $tid }}"
                    {{ $loop->first ? 'required' : '' }} class="mb-3 w-5 h-5 text-blue-600">
                <span class="font-bold text-lg mb-2 text-center">{{ $tid }}</span>

                <!-- Template Preview -->
                <div class="w-full flex justify-center items-center bg-white border border-gray-300 rounded shadow-sm mb-3 relative"
                    style="height: 180px; overflow: hidden;">
                    <div style="width: 189px; height: 160px; position: relative;">
                        <iframe
                            src="data:text/html;base64,{{ base64_encode(view('prints.templates.' . $tid, ['data' => $data, 'pages' => [['serial' => $data->StartSerial ?? '1']]])->render()) }}"
                            style="width: 378px; height: 321px; border: none; pointer-events: none; transform: scale(0.5); transform-origin: top left; position: absolute; top: 0; left: 0; background: white;">
                        </iframe>
                    </div>
                </div>
            </label>
        @endforeach
    </div>

    <div class="input-group mb-3">
        @if (!request()->has('modal'))
            <a href="{{ url()->previous() }}" class="form-control btn btn-outline-secondary me-1">Quay lại</a>
        @else
            <button type="button" class="form-control btn btn-outline-secondary me-1"
                data-bs-dismiss="modal">Đóng</button>
        @endif

        <button type="submit" name="action" value="sample" class="form-control btn btn-outline-warning me-1">
            <i class="bi bi-file-earmark-ruled me-1"></i>In mẫu (trang 1)
        </button>
        <button type="submit" name="action" value="print" class="form-control btn btn-success">
            <i class="bi bi-printer me-1"></i>In trực tiếp
        </button>
    </div>
</form>
