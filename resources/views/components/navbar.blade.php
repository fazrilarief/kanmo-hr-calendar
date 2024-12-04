 <!-- Topbar -->
 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

     <!-- Sidebar Toggle (Topbar) -->
     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
     </button>
     <div style="color: #e9500e;" id="realTimeClock"></div>
     <script>
         function updateClock() {
             var now = new Date();

             var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
             var dayName = days[now.getDay()];

             var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                 'November', 'Desember'
             ];
             var monthName = months[now.getMonth()];

             var dayOfMonth = now.getDate();
             var year = now.getFullYear();

             var hours = now.getHours();
             var minutes = now.getMinutes();
             var seconds = now.getSeconds();

             var realTimeClockElement = document.getElementById('realTimeClock');
             realTimeClockElement.innerHTML = dayName + ', ' + dayOfMonth + ' ' + monthName + ' ' + year +
                 ', ' + formatTime(hours) + ':' + formatTime(minutes) + ':' + formatTime(seconds) + ' WIB';

             setTimeout(updateClock, 1000);
         }

         function formatTime(time) {
             return time < 10 ? '0' + time : time;
         }

         updateClock();
     </script>

     <!-- Topbar Navbar -->
     <ul class="navbar-nav ml-auto">
         <div class="topbar-divider d-none d-sm-block"></div>

         <!-- Nav Item - User Information -->
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                 <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                     {{ Auth::guard('admin')->user()->name }}</span>
             </a>
             <!-- Dropdown - User Information -->
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 @if (Auth::guard('admin')->check())
                     <a class="dropdown-item" href="{{ route('admin.index') }}">
                         <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                         Profile
                     </a>
                 @endif
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                     Logout
                 </a>
             </div>
         </li>

     </ul>

 </nav>
 <!-- End of Topbar -->
