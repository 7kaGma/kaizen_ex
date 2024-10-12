<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn flex items-center justify-center gap-2 py-3 px-4 w-40 text-sm font-semibold rounded-lg  bg-blue-600 text-white cursor-pointer hover:border-blue-500 hover:text-blue-500 disabled:opacity-50 disabled:pointer-events-none']) }}>
  <div class="w-[20px] h-[20px]">
    <p class="core {{ $attributes->get('coreClass') }}"></p>
  </div>
  <p>いいね！</p>
  <p>{{ $slot }}</p>
</button>

  

