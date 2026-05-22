<!-- resources/views/components/action-buttons.blade.php -->

@props(['pdfRoute', 'pdfData', 'printRoute', 'printData', 'routeSelectSearch'])

<li class="nav-item" style="margin-left: auto">
    @if($routeSelectSearch != 'false')
    <span class="dropdown">
      <button type="button" class="btn p-0 dropdown-toggle hide-arrow btn btn-icon btn-outline-secondary" data-bs-toggle="dropdown">
        <i class="fa-solid fa-filter"></i>
      </button>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '1'])) }}">{{__('report.today')}}</a>
        <a class="dropdown-item" href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '2'])) }}">{{__('report.this_week')}}</a>
        <a class="dropdown-item" href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '3'])) }}">{{__('report.this_month')}}</a>
        <a class="dropdown-item" href="{{ route($routeSelectSearch, withLang(['search' => true, 'select' => '4'])) }}">{{__('report.this_year')}}</a>
      </div>
    </span>
    @endif
    <a target="_blank" href="{{ route($pdfRoute, $pdfData) }}" class="btn btn-icon btn-outline-secondary">
        <i class="fa-solid fa-file-pdf"></i>
    </a>
    <a target="_blank" href="{{ route($printRoute, $printData) }}" class="btn btn-icon btn-outline-secondary">
        <i class="fa-solid fa-print"></i>
    </a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
        <i class='bx bx-search'></i>
    </button>
</li>
