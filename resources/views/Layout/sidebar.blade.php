<aside class="sidebar-wrapper">
    <div class="sidebar-header">
      <div class="logo-icon">
        <img src="{{ URL::asset('build/images/logo-escuela.png') }}" class="logo-img" alt="">
      </div>
      <div class="logo-name flex-grow-1">
        <h5 class="mb-0">School Proyect</h5>
      </div>
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">
      
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
          <li>
            <a href="{{route('tasks.index')}}">
              <div class="parent-icon"><i class="material-icons-outlined">home</i>
              </div>
              <div class="menu-title">Dashboard</div>
            </a>
          </li>
          <li class="menu-label">Administrador</li>
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon mx-1"><i class="lni lni-network fs-4"></i>
              </div>
              <div class="menu-title">Cursos</div>
            </a>
            <ul>
              <li><a href="{{route('courses.index')}}"><i class="material-icons-outlined">arrow_right</i>Ver Cursos</a>
              </li>       
              <li><a href=""><i class="material-icons-outlined">arrow_right</i>Estadisticas</a>
              </li>
            </ul>
          </li>
          
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon mx-1"><i class="lni lni-ruler-pencil fs-4"></i>
              </div>
              <div class="menu-title">Clases</div>
            </a>
            <ul>
              <li><a href="{{route('classes.index')}}"><i class="material-icons-outlined">arrow_right</i>Ver Clases</a>
              </li>
              <li><a href=""><i class="material-icons-outlined">arrow_right</i>Estadisticas</a>
              </li>
            </ul>     
          </li>
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon mx-1"><i class="lni lni-user fs-4"></i>
              </div>
              <div class="menu-title">Usuarios</div>
            </a>
            <ul>
              <li><a href="{{route('users.index' , ['filter' => 'Usuarios_Activos'])}}"><i class="material-icons-outlined">arrow_right</i>Usuarios Activos</a>
              </li>
              <li><a href="{{route('users.index' , ['filter' => 'Administradores'])}}"><i class="material-icons-outlined">arrow_right</i>Administradores</a>
              </li>
              <li><a href="{{route('users.index' , ['filter' => 'Docentes'])}}"><i class="material-icons-outlined">arrow_right</i>Docentes</a>
              </li>
              <li><a href="{{route('users.index' , ['filter' => 'Alumnos'])}}"><i class="material-icons-outlined">arrow_right</i>Alumnos</a>
              </li>
              <li><a href="{{route('users.index' , ['filter' => 'Usuarios_Eliminados'])}}"><i class="material-icons-outlined">arrow_right</i>Usuarios Eliminados</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="{{route('tasksview')}}">
              <div class="parent-icon mx-1"><i class="lni lni-calculator fs-4"></i>
              </div>
              <div class="menu-title">Tareas</div>
            </a>
          </li>
          <li>
            <a  href="">
              <div class="parent-icon mx-1"><i class="lni lni-calendar fs-4"></i>
              </div>
              <div class="menu-title">Calendario</div>
            </a>
          </li>
          <li class="menu-label">Docentes</li>
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon mx-1"><i class="lni lni-world-alt fs-4"></i>
              </div>
              <div class="menu-title">Actividades</div>
            </a>
            <ul>
              <li><a href="{{route('tasksclassview')}}"><i class="material-icons-outlined">arrow_right</i>Ver Actividades</a>
              </li>
              <li><a href="{{route("tasks.create")}}"><i class="material-icons-outlined">arrow_right</i>Crear Actividad</a>
              </li>
              <li><a href=""><i class="material-icons-outlined">arrow_right</i>Estadisticas</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="">
              <div class="parent-icon mx-1"><i class="lni lni-layout fs-5"></i>
              </div>
              <div class="menu-title">Tables</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">apps</i>
              </div>
              <div class="menu-title">Apps</div>
            </a>
          </li>
          <li class="menu-label">Alumnos</li>
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon mx-1"><i class="lni lni-dropbox fs-4"></i>
              </div>
              <div class="menu-title">Tareas</div>
            </a>
            <ul>
              <li><a href="{{route("Calificar.index")}}"><i class="material-icons-outlined">arrow_right</i>Ver Mis Tareas</a>
              </li>
              <li><a href=""><i class="material-icons-outlined">arrow_right</i>Ver Estadisticas</a>
              </li>
              <li><a href=""><i class="material-icons-outlined">arrow_right</i>Ver Compañeros</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">person</i>
              </div>
              <div class="menu-title">Perfil de Usuario</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">join_right</i>
              </div>
              <div class="menu-title">Timeline</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">report_problem</i>
              </div>
              <div class="menu-title">Pages</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">help_outline</i>
              </div>
              <div class="menu-title">FAQ</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">sports_football</i>
              </div>
              <div class="menu-title">Pricing</div>
            </a>
          </li>
          <li class="menu-label">Charts & Maps</li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">fitbit</i>
              </div>
              <div class="menu-title">Charts</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon mx-1"><i class="lni lni-map fs-5"></i>
              </div>
              <div class="menu-title">Maps</div>
            </a>
          </li>
          <li class="menu-label">Others</li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">face_5</i>
              </div>
              <div class="menu-title">Menu Levels</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">description</i>
              </div>
              <div class="menu-title">Documentation</div>
            </a>
          </li>
          <li>
            <a href="">
              <div class="parent-icon"><i class="material-icons-outlined">support</i>
              </div>
              <div class="menu-title">Support</div>
            </a>
          </li>
         </ul>
        <!--end navigation-->
    </div>
    <div class="sidebar-bottom gap-4">
        <div class="dark-mode">
          <a href="javascript:;" class="footer-icon dark-mode-icon">
            <i class="material-icons-outlined">dark_mode</i>  
          </a>
        </div>
        <div class="dropdown dropup-center dropup dropdown-laungauge">
          <a class="dropdown-toggle dropdown-toggle-nocaret footer-icon" href="avascript:;" data-bs-toggle="dropdown"><img src="{{ URL::asset('build/images/county/09.png') }}" width="22" alt="">
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/01.png') }}" width="20" alt=""><span class="ms-2">English</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/02.png') }}" width="20" alt=""><span class="ms-2">Catalan</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/03.png') }}" width="20" alt=""><span class="ms-2">French</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/04.png') }}" width="20" alt=""><span class="ms-2">Belize</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/05.png') }}" width="20" alt=""><span class="ms-2">Colombia</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/06.png') }}" width="20" alt=""><span class="ms-2">Spanish</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/07.png') }}" width="20" alt=""><span class="ms-2">Georgian</span></a>
            </li>
            <li><a class="dropdown-item d-flex align-items-center py-2" href="javascript:;"><img src="{{ URL::asset('build/images/county/08.png') }}" width="20" alt=""><span class="ms-2">Hindi</span></a>
            </li>
          </ul>
        </div>
        <div class="dropdown dropup-center dropup dropdown-help">
          <a class="footer-icon  dropdown-toggle dropdown-toggle-nocaret option" href="javascript:;"
            data-bs-toggle="dropdown" aria-expanded="false">
            <span class="material-icons-outlined">
              info
            </span>
          </a>
          <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
            <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                  class="material-icons-outlined fs-6">inventory_2</i>Archive All</a></div>
            <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                  class="material-icons-outlined fs-6">done_all</i>Mark all as read</a></div>
            <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                  class="material-icons-outlined fs-6">mic_off</i>Disable Notifications</a></div>
            <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                  class="material-icons-outlined fs-6">grade</i>What's new ?</a></div>
            <div>
              <hr class="dropdown-divider">
            </div>
            <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
                  class="material-icons-outlined fs-6">leaderboard</i>Reports</a></div>
          </div>
        </div>

    </div>
</aside>