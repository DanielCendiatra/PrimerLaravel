@extends('Layout.master')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('build/css/extra-icons.css') }}">
@endsection 

@section('title', 'Matoxi')

@section('content')
        <div class="row">
          <div class="col-12 col-xl-4 d-flex">
             <div class="card rounded-4 w-100">
               <div class="card-body">
                 <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="">
                      <h2 class="mb-0">$9,568</h2>
                    </div>
                    <div class="">
                      <p class="dash-lable d-flex align-items-center gap-1 rounded mb-0 bg-danger text-danger bg-opacity-10"><span class="material-icons-outlined fs-6">arrow_downward</span>8.6%</p>
                    </div>
                  </div>
                  <p class="mb-0">Average Weekly Sales</p>
                   <div id="chart1"></div>
               </div>
             </div>
          </div>
          <div class="col-12 col-xl-8 d-flex">
            <div class="card rounded-4 w-100">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-around flex-wrap gap-4 p-4">
                  <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <a href="javascript:;" class="mb-2 wh-48 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                      <i class="lni lni-graduation fs-4"></i>
                    </a>
                    <h3 class="mb-0">{{$alumnos}}</h3>
                    <p class="mb-0">Alumnos</p>
                  </div>
                  <div class="vr"></div>
                  <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <a href="javascript:;" class="mb-2 wh-48 bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center">
                      <i class="fadeIn animated bx bx-glasses fs-4"></i>
                    </a>
                    <h3 class="mb-0">{{$docentes}}</h3>
                    <p class="mb-0">Docentes</p>
                  </div>
                  <div class="vr"></div>
                  <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <a href="javascript:;" class="mb-2 wh-48 bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center">
                      <i class="fadeIn animated bx bx-server fs-4"></i>
                    </a>
                    <h3 class="mb-0">{{$clases}}</h3>
                    <p class="mb-0">Clases</p>
                  </div>
                  <div class="vr"></div>
                  
                  <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <a href="javascript:;" class="mb-2 wh-48 bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center">
                      <i class="fadeIn animated bx bx-group fs-4"></i>
                    </a>
                    <h3 class="mb-0">{{$cursos}}</h3>
                    <p class="mb-0">Cursos</p>
                  </div>
                  <div class="vr"></div>
                  <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <a href="javascript:;" class="mb-2 wh-48 bg-warning bg-opacity-10 text-warning  rounded-circle d-flex align-items-center justify-content-center">
                      <i class="lni lni-stackoverflow fs-4"></i>
                    </a>
                    <h3 class="mb-0">{{$tareas}}</h3>
                    <p class="mb-0">Tareas</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!--end row-->
        
        <div class="row w-100">
          <div class="col-12 col-xl-7 col-xxl-8 d-flex w-100">
            <div class="card w-100 rounded-4">
               <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">Tareas creadas por mes y clase</h5>
                  </div>
                 </div>
                  <div id="chart4"></div>
                  <div class="d-flex flex-column flex-lg-row align-items-start justify-content-around border p-3 rounded-4 mt-3 gap-3">
                    <div class="d-flex align-items-center gap-4">
                      <div class="">
                        <p class="mb-0 data-attributes">
                          <span
                            data-peity='{ "fill": ["#0d6efd", "rgb(0 0 0 / 10%)"], "innerRadius": 32, "radius": 40 }'>{{$tareasP}}/{{$tareas}}</span>
                        </p>
                      </div>
                      <diiv class="">
                        <p class="mb-1 fs-6 fw-bold">Tareas en Progreso</p>
                        <h2 class="mb-0">{{$tareasP}}</h2>
                        <p class="mb-0"><span class="text-success me-2 fw-medium">{{$porcientoP}}%</span></p>
                      </diiv>
                    </div>
                    <div class="vr"></div>
                    <div class="d-flex align-items-center gap-4">
                      <div class="">
                        <p class="mb-0 data-attributes">
                          <span
                            data-peity='{ "fill": ["#6f42c1", "rgb(0 0 0 / 10%)"], "innerRadius": 32, "radius": 40 }'>{{$tareasF}}/{{$tareas}}</span>
                        </p>
                      </div>
                      <div class="">
                        <p class="mb-1 fs-6 fw-bold">Tareas Finalizadas</p>
                        <h2 class="mb-0">{{$tareasF}}</h2>
                        <p class="mb-0"><span class="text-success me-2 fw-medium">{{$porcientoF}}%</span></p>
                      </div>
                    </div>
                  </div>
               </div>
            </div>  
          </div> 
        </div><!--end row-->

        <div class="row">
           <div class="col-12 col-xl-4 d-flex">
            <div class="card w-100 rounded-4">
               <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">Porcentaje de alumnos al dia</h5>
                  </div>
                 </div>
                  <div class="d-flex flex-column gap-4">
                    @foreach($porcentajeCalificadas as $porcentajeCalificada)
                      <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-3 flex-grow-1 flex-shrink-0">
                          <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle" style="background-color: {{$porcentajeCalificada['color']}}">
                            <span class="fadeIn animated bx {{$porcentajeCalificada['icon']}} fs-3"></span>
                          </div>
                          <div class="">
                            <h6 class="mb-0 fw-bold">{{$porcentajeCalificada['name']}}</h6>
                            <p class="mb-0">{{$porcentajeCalificada['canti']}} para {{$porcentajeCalificada['dia']}}</p>
                          </div>
                        </div>
                        <div class="progress w-25" style="height: 5px;">
                          <div class="progress-bar" style="width: {{$porcentajeCalificada['porcentajealdia']}}% ; background-color: {{$porcentajeCalificada['color']}}"></div>
                        </div>
                        <div class="">
                        <p class="mb-0 fs-6">{{$porcentajeCalificada['porcentajealdia']}}%</p>
                        </div>
                      </div>
                    @endforeach
                  </div>
               </div>
             </div>
           </div>

           <div class="col-12 col-xl-4 d-flex">
            <div class="card w-100 rounded-4">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">Porcentajes por Tarea</h5>
                  </div>
                 </div>
                <div class="d-flex flex-column justify-content-between gap-4">
                  @foreach($porcientoT as $porcienT)
                    <div class="d-flex align-items-center gap-4">
                      <div class="d-flex align-items-center gap-3 flex-grow-1">
                        <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle" style="background-color: {{$porcienT['color']}}">
                          <span class="fadeIn animated bx {{$porcienT['icon']}} fs-3"></span>
                        </div>
                        <p class="mb-0">{{$porcienT['name']}}</p>
                      </div>
                      <div class="">
                        <p class="mb-0 fs-6">{{$porcienT['data']}}%</p>
                      </div>
                      <div class="">
                        <p class="mb-0 data-attributes">
                          <span
                            data-peity='{ "fill": ["{{$porcienT['color']}}", "rgb(0 0 0 / 10%)"], "innerRadius": 14, "radius": 18 }'>{{$porcienT['cantidad']}}/{{$tareas}}</span>
                        </p>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>  
          </div>

           <div class="col-12 col-xl-4 d-flex">
            <div class="card rounded-4 w-100">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">Recent Transactions</h5>
                  </div>
                  <div class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                      data-bs-toggle="dropdown">
                      <span class="material-icons-outlined fs-5">more_vert</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                    </ul>
                  </div>
                 </div>
                <div class="payments-list">
                  <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="wh-48 d-flex align-items-center justify-content-center bg-danger rounded-circle">
                        <span class="material-icons-outlined text-white">shopping_cart</span>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">Online Purchase</h6>
                        <p class="mb-0">03/10/2022</p>
                      </div>
                      <div class="d-flex align-items-center">
                        <h6 class="mb-0 fw-bold">$97,896</h6>
                      </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                      <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-primary">
                        <span class="material-icons-outlined text-white">monetization_on</span>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0">Bank Transfer</h6>
                        <p class="mb-0">03/10/2022</p>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <h6 class="mb-0 fw-bold">$86,469</h6>
                      </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                      <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-success">
                        <span class="material-icons-outlined text-white">credit_card</span>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0">Credit Card</h6>
                        <p class="mb-0">03/10/2022</p>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <h6 class="mb-0 fw-bold">$45,259</h6>
                      </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                      <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-purple">
                        <span class="material-icons-outlined text-white">account_balance</span>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0">Laptop Payment</h6>
                        <p class="mb-0">03/10/2022</p>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <h6 class="mb-0 fw-bold">$35,249</h6>
                      </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                      <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-orange">
                        <span class="material-icons-outlined text-white">savings</span>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0">Template Payment</h6>
                        <p class="mb-0">03/10/2022</p>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <h6 class="mb-0 fw-bold">$68,478</h6>
                      </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                      <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-info">
                        <span class="material-icons-outlined text-white">paid</span>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0">iPhone Purchase</h6>
                        <p class="mb-0">03/10/2022</p>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <h6 class="mb-0 fw-bold">$55,128</h6>
                      </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                      <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-pink">
                        <span class="material-icons-outlined text-white">card_giftcard</span>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-0">Account Credit</h6>
                        <p class="mb-0">03/10/2022</p>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <h6 class="mb-0 fw-bold">$24,568</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         </div>
@endsection 
@section('scripts')

  <script src="{{ URL::asset('build/plugins/apexchart/apexcharts.min.js') }}"></script>
  <script src="{{ URL::asset('build/js/index.js') }}"></script>
  <script src="{{ URL::asset('build/plugins/peity/jquery.peity.min.js') }}"></script>
  <script>
    $(".data-attributes span").peity("donut")
  </script>
@endsection 