@props(['pdfRoute', 'pdfData', 'printRoute', 'printData', 'routeSelectSearch'])

<li class="nav-item d-flex align-items-center gap-1" style="margin-left: auto">

    @if($routeSelectSearch != 'false')
    <div class="report-filter-wrapper" style="position: relative;">
        <button
            type="button"
            id="reportFilterBtn"
            class="btn btn-icon btn-outline-secondary {{ request('select') ? 'active' : '' }}"
            onclick="toggleReportFilter(event)"
            aria-expanded="false"
        >
            <i class="fa-solid fa-filter"></i>
        </button>

        <ul
            id="reportFilterMenu"
            class="dropdown-menu"
            style="display:none; position:absolute; right:0; top:calc(100% + 4px); z-index:9999; min-width:150px;"
        >
            <li>
                <a class="dropdown-item {{ request('select') == '1' ? 'active' : '' }}"
                   href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '1'])) }}">
                    {{ __('report.today') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request('select') == '2' ? 'active' : '' }}"
                   href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '2'])) }}">
                    {{ __('report.this_week') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request('select') == '3' ? 'active' : '' }}"
                   href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '3'])) }}">
                    {{ __('report.this_month') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request('select') == '4' ? 'active' : '' }}"
                   href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '4'])) }}">
                    {{ __('report.this_year') }}
                </a>
            </li>
        </ul>
    </div>
    @endif

    <a target="_blank"
       href="{{ route($pdfRoute, $pdfData) }}"
       class="btn btn-icon btn-outline-secondary">
        <i class="fa-solid fa-file-pdf"></i>
    </a>

    <a target="_blank"
       href="{{ route($printRoute, $printData) }}"
       class="btn btn-icon btn-outline-secondary">
        <i class="fa-solid fa-print"></i>
    </a>

    <button type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#searchModal">
        <i class='bx bx-search'></i>
    </button>
</li>

<script>
function toggleReportFilter(e) {
    e.stopPropagation();
    var menu = document.getElementById('reportFilterMenu');
    var btn  = document.getElementById('reportFilterBtn');
    var isOpen = menu.style.display === 'block';
    menu.style.display = isOpen ? 'none' : 'block';
    btn.setAttribute('aria-expanded', String(!isOpen));
}

document.addEventListener('click', function(e) {
    var wrapper = document.querySelector('.report-filter-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        var menu = document.getElementById('reportFilterMenu');
        var btn  = document.getElementById('reportFilterBtn');
        if (menu) menu.style.display = 'none';
        if (btn)  btn.setAttribute('aria-expanded', 'false');
    }
});
</script>