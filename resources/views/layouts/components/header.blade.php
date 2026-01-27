<div class="header shadow-sm bg-white px-3 py-2 position-fixed top-0 start-0 end-0" style="z-index:1030;">
    <div class="row align-items-center no-gutters">
        <!-- Logo -->
        <div class="col-auto d-flex align-items-center">
            <img src="{{ asset('assets/images/big/pesona1.jpg') }}" 
                 alt="Logo" 
                 class="rounded-circle border border-2 border-primary me-2" 
                 style="width:40px; height:40px; object-fit:cover;">
        </div>

        <!-- Title -->
        <div class="col text-center">
            <span class="fw-bold text-dark" style="font-size: 15px; letter-spacing:0.5px;">
                HOM
            </span>
        </div>

        <!-- Actions -->
        <div class="col-auto d-flex align-items-center gap-1">
            <!-- Notification -->
            <button class="btn btn-light rounded-circle shadow-sm me-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#notifications" 
                    style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-bell text-primary"></i>
            </button>

            <!-- Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light rounded-circle shadow-sm" 
                        data-bs-toggle="dropdown" 
                        style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-bars text-dark"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm rounded-3" style="font-size:13px;">
                    <li>
                        <a href="https://wa.me/628815873744?text=Permisi%20Admin,%20saya%20mau%20pasang%20iklan" 
                        target="_blank"
                        class="dropdown-item text-dark px-3 py-2">
                            <i class="fas fa-image text-primary me-2"></i> Pasang Iklan
                        </a>
                    </li>
                    <li>
                       <a href="{{ route('user.saran.index') }}" class="dropdown-item text-dark px-3 py-2">
                            <i class="fas fa-envelope-open-text text-success me-2"></i> Kritik & Saran
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger px-3 py-2">
                                <i class="fas fa-power-off me-2"></i> Log out
                            </button>
                        </form>
                    </li>               
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan padding agar konten tidak ketutup navbar -->
<div style="padding-top:65px;"></div>
