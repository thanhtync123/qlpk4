<nav class="navbar navbar-expand bg-primary shadow-sm rounded-bottom position-absolute" style="top: 50px; left: 0; z-index: 999;">
    <div class="container-fluid">
        <ul class="navbar-nav ms-0">
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ Request::is('examination/x-ray') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                    href="/examination/x-ray"
                    style="transition: 0.3s;"
                    onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                    onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                    X - Quang
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ Request::is('examination/ultrasound') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                    href="/examination/ultrasound"
                    style="transition: 0.3s;"
                    onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                    onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                    Siêu âm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ Request::is('examination/test') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                    href="/examination/test"
                    style="transition: 0.3s;"
                    onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                    onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                    Xét nghiệm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ Request::is('examination/ecg') ? 'bg-warning text-dark rounded' : 'text-white' }}" 
                    href="/examination/ecg"
                    style="transition: 0.3s;"
                    onmouseover="this.style.backgroundColor='#ffc107'; this.style.color='#000'; this.style.borderRadius='5px';"
                    onmouseout="if (!this.classList.contains('bg-warning')) { this.style.backgroundColor='transparent'; this.style.color='white'; }">
                    Điện tim
                </a>
            </li>
        </ul>
    </div>
</nav>
