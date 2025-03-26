<nav class="navbar navbar-expand-lg navbar-light bg-primary shadow-sm rounded-bottom">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#">Phòng Khám</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fw-semibold 
                        {{ Request::is('dashboard') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                        href="/dashboard"
                        style="transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                        onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                        Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold 
                        {{ Request::is('patients') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                        href="/patients"
                        style="transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                        onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                        Quản lý bệnh nhân
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold 
                        {{ Request::is('service') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                        href="/service"
                        style="transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                        onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                        Quản lý dịch vụ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold 
                        {{ Request::is('medication') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                        href="/medication"
                        style="transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                        onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                        Quản lý thuốc
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold 
                        {{ Request::is('examination/x-ray') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                        href="/examination/x-ray"
                        style="transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                        onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                        Khám bệnh
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold 
                        {{ Request::is('appointments') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                        href="/appointments"
                        style="transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                        onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                        Lịch hẹn
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
