 <div class="header-bar d-flex justify-content-between align-items-center flex-wrap">
     <div class="header-left">
         <img src="{{ asset('assetts/images/logo-dark.png') }}" alt="" />
     </div>
     <!-- Dropdown User -->
     <div class="dropdown mt-2 mt-md-0">
         <button class="btn d-flex align-items-center border-0 bg-transparent dropdown-toggle" type="button"
             id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
             <div class="user-avatar me-2"></div>
             <div class="text-end selamat text-md-start">
                 <div class="fw-semibold">Selamat Datang,</div>
                 <small>{{ Auth::user()->name }}</small>
             </div>
         </button>

         <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
             <li>
                 <form method="POST" action="{{ route('logout') }}">
                     @csrf
                     <button type="submit" class="dropdown-item text-danger">
                         <i class="bi bi-box-arrow-right me-2"></i>Logout
                     </button>
                 </form>
             </li>
         </ul>
     </div>
 </div>
