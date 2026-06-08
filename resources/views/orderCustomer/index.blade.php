@extends('layouts.pos')

@push('styles')

<script src="https://cdn.tailwindcss.com"></script>

@endpush

@section('content')
<div class="h-[calc(100vh-60px)] w-full overflow-hidden p-0 flex flex-row">

    {{-- ===== SIDEBAR ===== --}}
    <div class="flex flex-col items-center border-r border-black m-[5px] p-[10px] gap-2">

        {{-- Apple icon --}}
        <a href="/" class="inline-block px-6 py-3 bg-[#0052a3] color-white text-white no-underline rounded-lg font-sans font-bold shadow-md">
            <i class="fa-brands fa-apple"></i>
        </a>

        {{-- Search Button --}}
        <div class="relative">
            <button onclick="toggleSearch()"
                class="flex items-center gap-2.5 bg-[#0052a3] border-none rounded-full px-4 py-2.5 cursor-pointer w-full">
                <i class="fa-solid fa-magnifying-glass text-[18px] text-white"></i>
                <span class="text-[14px] text-white font-medium">Search...</span>
            </button>

            {{-- Search Dropdown --}}
            <div id="searchPanel"
                class="hidden absolute top-0 left-[calc(100%+16px)] w-[300px] bg-white border border-[#ddd] rounded-xl p-3.5 shadow-lg z-[999] animate-drop-in">

                <div class="flex items-center gap-2 border-b border-[#eee] pb-2.5 mb-2.5">
                    <i class="fa-solid fa-magnifying-glass text-[#0052a3] text-[16px]"></i>
                    <input id="searchInput" type="text"
                        placeholder="Search by name, brand, price..."
                        oninput="liveSearch(this.value)"
                        onclick="event.stopPropagation()"
                        class="border-none outline-none text-[14px] text-[#333] flex-1 bg-transparent" />
                    <i class="fa-solid fa-xmark text-[#aaa] text-[15px] cursor-pointer" onclick="closeSearch()"></i>
                </div>

                <div id="searchLoading" class="hidden text-center p-2.5">
                    <i class="fa-solid fa-spinner fa-spin text-[#0052a3]"></i>
                </div>
                <div id="noResults" class="hidden text-center text-[13px] text-[#aaa] p-2.5">
                    No phones found.
                </div>
                <div id="searchResults"></div>
            </div>
        </div>

        {{-- All Phone Button --}}
        <button onclick="showAllPhones()"
            class="px-7 py-2.5 bg-[#0052a3] text-white border-none rounded-lg font-bold shadow-md flex flex-col justify-center items-center cursor-pointer">
            <i class="fa-solid fa-mobile-screen-button text-[45px] mb-1"></i>
            <span class="text-[10px]">All Phone</span>
        </button>

        {{-- Apple Button --}}
        <button onclick="filterByBrand('Apple')"
            class="px-10 py-2.5 bg-[#0052a3] text-white border-none rounded-lg font-bold shadow-md flex flex-col justify-center items-center cursor-pointer">
            <i class="fa-brands fa-apple text-[40px] mb-1"></i>
            <span class="text-[10px]">Apple</span>
        </button>

    </div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 overflow-hidden flex flex-col">


        {{-- Phone Grid Container --}}
        <div id="phoneGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4 overflow-y-auto h-full content-start">
            {{-- Default: Blade initialization loop --}}
            @forelse($products as $product)
            <div class="bg-white border border-[#e5e7eb] rounded-2xl p-5 flex flex-col items-center text-center gap-3 cursor-pointer w-full box-border transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5"
                data-brand="{{ $product->brand->name ?? '' }}"
                onclick="selectPhone({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">

                <i class="fa-solid fa-mobile-screen-button text-[36px] text-[#0052a3]"></i>

                <div class="flex flex-col gap-1 w-full">
                    <div class="text-[14px] font-semibold text-[#333] truncate" title="{{ $product->name }}">{{ $product->name }}</div>
                    <div class="text-[12px] text-[#888]">{{ $product->brand->name ?? '-' }}</div>
                </div>

                <div class="text-[14px] text-[#0052a3] font-bold mt-auto">${{ number_format($product->price, 2) }}</div>
            </div>
            @empty
            <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 flex flex-col items-center justify-center h-64 text-[#aaa] gap-2.5">
                <i class="fa-solid fa-box-open text-[48px]"></i>
                <p>No phones available</p>
            </div>
            @endforelse
        </div>

    </div>

    
    <div class="w-[280px] h-full border-l border-gray-300 flex flex-col text-[13px] text-gray-700">
    
    <form action="{{ route('orders.store') }}" method="POST" class="h-full flex flex-col m-0">
        @csrf

        <div class="p-4 border-b border-gray-100 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-500">
                    Order: <strong class="text-gray-800 font-bold">#{{ str_pad($nextOrderId, 6, '0', STR_PAD_LEFT) }}</strong>
                </span>
                <input type="hidden" name="order_id" value="{{ $nextOrderId }}">
            </div>
            
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                
                <select name="customer_id" class="w-full pl-9 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-md appearance-none focus:outline-none focus:border-blue-500 font-sans text-[14px]">
                    @foreach($customers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>

                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div id="cart-container" class="flex-grow overflow-y-auto p-4 space-y-3">
            <div id="empty-cart-msg" class="h-full flex flex-col items-center justify-center text-gray-400 py-12">
                <p>No items added yet</p>
            </div>
        </div>

        <div class="p-4 border-t border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 font-medium text-sm">Total</span>
                <span class="text-lg font-bold text-gray-900">$ <span id="cart-total-display">0</span></span>
                <input type="hidden" name="total_amount" id="cart-total-input" value="0">
            </div>

            <div class="flex gap-2">
                <button type="submit" name="action" value="print" class="flex flex-col items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-500 font-medium px-4 py-2.5 rounded-lg transition-colors w-[70px]">
                    <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-[11px]">Bill</span>
                </button>

                <button type="submit" name="action" value="submit" class="flex-1 flex items-center justify-center gap-2 text-white font-medium py-2.5 rounded-lg transition-colors shadow-sm bg-blue-600 hover:bg-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3v-3m-3 3v-3m12 1h-18a2 2 0 01-2-2V5a2 2 0 012-2h18a2 2 0 012 2v12a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Submit Order</span>
                </button>
            </div>
        </div>
    </form>
</div>

</div>
@endsection

@push('script')
<script>
    const allProducts = @json($products);

    function showAllPhones() {
        document.getElementById('contentTitle').textContent = 'All Phones';
        renderCards(allProducts);
    }

    function filterByBrand(brand) {
        document.getElementById('contentTitle').textContent = brand + ' Phones';
        const filtered = allProducts.filter(p => p.brand && p.brand.name === brand);
        renderCards(filtered);
    }

    // ======= RENDER CARDS (Tailwind Strings Edition) =======
    function renderCards(products) {
        const grid = document.getElementById('phoneGrid');
        document.getElementById('productCount').textContent = `(${products.length})`;

        if (products.length === 0) {
            grid.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-[#aaa] gap-2.5">
                    <i class="fa-solid fa-box-open text-[48px] text-[#ddd]"></i>
                    <p>No phones found</p>
                </div>`;
            return;
        }

        grid.innerHTML = products.map(p => `
            <div class="bg-white border border-[#e5e7eb] rounded-2xl p-4 px-5 flex flex-row items-center gap-5 cursor-pointer w-full box-border transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5" 
                 onclick="selectPhone(${p.id}, '${p.name}', ${p.price})">
                <i class="fa-solid fa-mobile-screen-button text-[32px] text-[#0052a3]"></i>
                <div class="flex flex-col gap-1 flex-grow">
                    <div class="text-[14px] font-semibold text-[#333]">${p.name}</div>
                    <div class="text-[12px] text-[#888]">${p.brand ? p.brand.name : '-'}</div>
                </div>
                <div class="text-[14px] text-[#0052a3] font-bold ml-auto">$${parseFloat(p.price).toFixed(2)}</div>
            </div>
        `).join('');
    }

    function selectPhone(id, name, price) {
        console.log('Selected:', id, name, price);
    }

    let searchTimer = null;
    let isOpen = false;

    function liveSearch(query) {
        clearTimeout(searchTimer);
        if (query.trim() === '') {
            document.getElementById('searchResults').innerHTML = '';
            document.getElementById('noResults').style.display = 'none';
            return;
        }
        searchTimer = setTimeout(() => {
            document.getElementById('searchLoading').style.display = 'block';
            document.getElementById('noResults').style.display = 'none';
            document.getElementById('searchResults').innerHTML = '';

            fetch(`/{{ app()->getLocale() }}/order-customer/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(phones => {
                    document.getElementById('searchLoading').style.display = 'none';
                    if (phones.length === 0) {
                        document.getElementById('noResults').style.display = 'block';
                        return;
                    }
                    document.getElementById('contentTitle').textContent = `Results for "${query}"`;
                    renderCards(phones);

                    document.getElementById('searchResults').innerHTML = phones.map(p => `
                        <div onclick="selectPhone(${p.id}, '${p.name}', ${p.price}); closeSearch();"
                             class="flex items-center gap-2.5 p-2 rounded-lg cursor-pointer text-[#333] hover:bg-[#f0f4ff] transition-colors">
                            <i class="fa-solid fa-mobile-screen text-[#0052a3] text-[16px]"></i>
                            <div>
                                <div class="text-[14px] font-medium">${p.name}</div>
                                <div class="text-[12px] text-[#888]">${p.brand ? p.brand.name : '-'} · $${parseFloat(p.price).toFixed(2)}</div>
                            </div>
                        </div>
                    `).join('');
                })
                .catch(() => {
                    document.getElementById('searchLoading').style.display = 'none';
                });
        }, 400);
    }

    function toggleSearch() {
        isOpen = !isOpen;
        document.getElementById('searchPanel').style.display = isOpen ? 'block' : 'none';
        if (isOpen) setTimeout(() => document.getElementById('searchInput').focus(), 100);
    }

    function closeSearch() {
        isOpen = false;
        document.getElementById('searchPanel').style.display = 'none';
        document.getElementById('searchInput').value = '';
        document.getElementById('searchResults').innerHTML = '';
        document.getElementById('noResults').style.display = 'none';
    }

    document.addEventListener('click', function(e) {
        if (isOpen && !e.target.closest('#searchPanel') && !e.target.closest('button')) {
            closeSearch();
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeSearch();
    });

    document.getElementById('productCount').textContent = `(${allProducts.length})`;
</script>
@endpush