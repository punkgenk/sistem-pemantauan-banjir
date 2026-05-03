@extends(auth()->user()->role === 'pemerintah'
    ? 'layouts.pemerintah'
    : 'layouts.masyarakat')

@section('title','Chat')
@section('content')

<div class="max-w-4xl mx-auto flex flex-col h-[80vh] bg-white rounded-xl shadow overflow-hidden">

{{-- CHATBOT PANEL --}}
<div class="max-w-4xl mx-auto mt-4 bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-3 bg-emerald-600 text-white font-semibold flex items-center gap-2">
        <i class="fa-solid fa-robot"></i> Tanya Chatbot Banjir
    </div>

    <div id="chatbotBox" class="px-4 py-4 space-y-3 max-h-60 overflow-y-auto bg-gray-50">
        <p class="text-sm text-gray-400 text-center">Tanyakan seputar banjir, evakuasi, atau informasi darurat.</p>
    </div>

    <div class="border-t px-4 py-3 flex gap-2 bg-white">
        <input type="text" id="chatbotInput"
               placeholder="Contoh: Apa yang harus dilakukan saat banjir?"
               class="flex-1 border rounded-lg px-4 py-2 text-sm focus:ring-emerald-500">
        <button onclick="askChatbot()"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>
</div>

    {{-- HEADER --}}
    <div class="px-6 py-4 border-b flex items-center gap-3 bg-gray-50">
        <img src="https://ui-avatars.com/api/?name={{ $conversation->otherUser()->name }}"
             class="w-10 h-10 rounded-full">
        <div>
            <p class="font-semibold">{{ $conversation->otherUser()->name }}</p>
            <p class="text-xs text-gray-500 capitalize">
                {{ $conversation->otherUser()->role }}
            </p>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div id="chatBox"
         class="flex-1 overflow-y-auto px-4 py-6 space-y-4 bg-[#efeae2]">

        @foreach($messages as $msg)
            @php $isMe = $msg->sender_id === auth()->id(); @endphp

            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs rounded-xl px-4 py-2 text-sm
                    {{ $isMe ? 'bg-[#dcf8c6]' : 'bg-white' }} shadow">

                    {{-- IMAGE --}}
                    @if($msg->image)
                        <img src="{{ asset('storage/'.$msg->image) }}"
                             class="rounded-lg mb-2 max-w-full">
                    @endif

                    {{-- TEXT --}}
                    @if($msg->message)
                        <p class="text-gray-800">{{ $msg->message }}</p>
                    @endif

                    {{-- WAKTU --}}
                    <p class="text-[10px] text-right text-gray-500 mt-1">
                        {{ $msg->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- IMAGE PREVIEW --}}
    <div id="imagePreview" class="hidden border-t p-4 bg-gray-50">
        <p class="text-sm mb-2 text-gray-600">Preview gambar:</p>
        <div class="relative inline-block">
            <img id="previewImg" class="rounded-lg max-h-40">
            <button type="button"
                    onclick="removeImage()"
                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 text-xs">
                ✕
            </button>
        </div>
    </div>

    {{-- INPUT --}}
    <form method="POST"
          action="{{ route('chat.store', $conversation) }}"
          enctype="multipart/form-data"
          class="border-t px-4 py-3 flex items-end gap-2 bg-white">

        @csrf

        {{-- IMAGE PICKER --}}
        <input type="file" name="image" id="imageInput"
               accept="image/*" class="hidden">

        <label for="imageInput"
               class="cursor-pointer text-gray-500 text-xl">
            <i class="fa-solid fa-image"></i>
        </label>

        {{-- TEXT --}}
        <textarea name="message"
                  rows="1"
                  placeholder="Tulis pesan..."
                  class="flex-1 resize-none border rounded-lg px-4 py-2 focus:ring-emerald-500"></textarea>

        <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>

</div>

{{-- JS --}}
<script>

    async function askChatbot() {
    const input = document.getElementById('chatbotInput');
    const box = document.getElementById('chatbotBox');
    const msg = input.value.trim();
    if (!msg) return;

    // Tampilkan pesan user
    box.innerHTML += `<div class="flex justify-end"><div class="bg-emerald-100 text-sm rounded-xl px-4 py-2 max-w-xs">${msg}</div></div>`;
    input.value = '';
    box.scrollTop = box.scrollHeight;

    // Loading indicator
    box.innerHTML += `<div id="botLoading" class="flex justify-start"><div class="bg-white text-sm rounded-xl px-4 py-2 max-w-xs text-gray-400 shadow">Mengetik...</div></div>`;
    box.scrollTop = box.scrollHeight;

    try {
        const res = await fetch('{{ route("chatbot.ask") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg })
        });

        const data = await res.json();
        document.getElementById('botLoading')?.remove();
        box.innerHTML += `<div class="flex justify-start"><div class="bg-white text-sm rounded-xl px-4 py-2 max-w-xs shadow">${data.reply}</div></div>`;
    } catch (e) {
        document.getElementById('botLoading')?.remove();
        box.innerHTML += `<div class="flex justify-start"><div class="bg-red-100 text-sm rounded-xl px-4 py-2 max-w-xs">Gagal menghubungi chatbot.</div></div>`;
    }

    box.scrollTop = box.scrollHeight;
    }

    // Kirim dengan Enter
    document.getElementById('chatbotInput')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') askChatbot();
    });

    // IMAGE PREVIEW
    const imageInput = document.getElementById('imageInput');
    const previewBox = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewBox.classList.remove('hidden');
        }
    });

    function removeImage() {
        imageInput.value = '';
        previewBox.classList.add('hidden');
    }

    // AUTO SCROLL KE BAWAH
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>

@endsection
