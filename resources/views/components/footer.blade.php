<!-- Footer -->
<footer class="footer bg-light">
    <div class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3">
        <div>
        ©2023　,
            <a href="#" target="_blank" class="footer-link fw-bolder">Management System - MS</a>
        </div>
        <div>
            <a href="{{ route('logout', withLang()) }}" class="btn btn-sm btn-outline-danger"onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class="bx bx-log-out-circle"></i> {{ __('Logout') }}
            </a>
                <form id="logout-form" action="{{ route('logout', withLang()) }}" method="POST" class="d-none">
                    @csrf
                </form>
        </div>
    </div>
</footer>
<!-- / Footer -->
