<nav class="navbar navbar-expand-lg navbar-light bg-primary shadow-sm rounded-bottom">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#">Phòng Khám</a>
        <button class="navbar-toggler border-0 focus-ring focus-ring-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded 
                        {{ Request::is('dashboard') ? 'bg-warning text-dark' : 'text-white' }} 
                        focus-ring focus-ring-primary"
                        href="/dashboard">
                        Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded 
                        {{ Request::is('patients') ? 'bg-warning text-dark' : 'text-white' }} 
                        focus-ring focus-ring-primary"
                        href="/patients">
                        Quản lý bệnh nhân
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded 
                        {{ Request::is('service') ? 'bg-warning text-dark' : 'text-white' }} 
                        focus-ring focus-ring-primary"
                        href="/service">
                        Quản lý dịch vụ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded 
                        {{ Request::is('medication') ? 'bg-warning text-dark' : 'text-white' }} 
                        focus-ring focus-ring-primary"
                        href="/medication">
                        Quản lý thuốc
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded 
                        {{ Request::is('examination') ? 'bg-warning text-dark' : 'text-white' }} 
                        focus-ring focus-ring-primary"
                        href="/examination">
                        Khám nội khoa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded 
                        {{ Request::is('examination/x-ray') ? 'bg-warning text-dark' : 'text-white' }} 
                        focus-ring focus-ring-primary"
                        href="/examination/x-ray">
                        Cận lâm sàng
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
