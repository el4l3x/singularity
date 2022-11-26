<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Manual items links --}}
                <li class="nav-header">
                    EMPRESAS
                </li>

                @foreach (Auth::user()->franquicias as $franquicias)
                    <li class="nav-item has-treeview">

                        {{-- Menu toggler --}}
                        <a class="nav-link" href="">
                    
                            <i class="far fa-fw fa-circle"></i>
                    
                            <p>
                                {{ $franquicias->nombre }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                    
                        </a>
                    
                        {{-- Menu items --}}
                        <ul class="nav nav-treeview">
                            
                            @can('visitas.index')
                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('franquicias.visitas.index', $franquicias) }}">
                                
                                        <i class="far fa-fw fa-circle"></i>
                                
                                        <p>
                                            Hoja de Visitas
                                        </p>
                                
                                    </a>
                                
                                </li>                        
                            @endcan
                            
                            @can('entregas.index')
                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('franquicias.entregas.index', $franquicias) }}">
                                
                                        <i class="far fa-fw fa-circle"></i>
                                
                                        <p>
                                            Notas de Entrega
                                        </p>
                                
                                    </a>
                                
                                </li>                        
                            @endcan
                            
                            @can('presupuestos.index')
                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('franquicias.presupuestos.index', $franquicias) }}">
                                
                                        <i class="far fa-fw fa-circle"></i>
                                
                                        <p>
                                            Presupuestos
                                        </p>
                                
                                    </a>
                                
                                </li>                        
                            @endcan
                            
                            @can('facturas.index')
                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('franquicias.facturas.index', $franquicias) }}">
                                
                                        <i class="far fa-fw fa-circle"></i>
                                
                                        <p>
                                            Facturas
                                        </p>
                                
                                    </a>
                                
                                </li>                        
                            @endcan

                        </ul>
                    
                    </li>
                @endforeach

                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>
