<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('') }}" target="_blank" class="brand-link">
        <img src="{{ url('assets/adminLte/dist/img/AdminLTELogo.png') }}" alt="GMSColis Logo"
            class="brand-image img-circle" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ str_replace('_', ' ', config('app.name')) }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url(auth()->user()->path) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('user.edit_profile') }}" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 text-capitalize">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Dashboard stats links --}}
                @can('tableau_bord_index')
                    <li class="nav-header">Dashboard</li>
                    <li class="nav-item ">
                        <a href="{{ adminUrl('stats') }}" class="nav-link {{ active_menu('stats')[1] }} ">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>tableau de bord</p>
                        </a>
                    </li>
                @endcan

                {{-- colis links --}}
                {{-- @can('liste_colis') --}}
                <li class="nav-item">
                    <a href="{{ adminUrl('colis') }}" class="nav-link {{ setActive('colis') }} ">
                        <i class="fa fa-shopping-basket nav-icon"></i>
                        <p>list des colis</p>
                    </a>
                </li>
                {{-- @endcan --}}

                {{-- @can('liste_paiments') --}}
                <li class="nav-item">
                    <a href="{{ adminUrl('paiements') }}" class="nav-link {{ setActive('paiements') }} ">
                        <i class="fa fa-credit-card-alt nav-icon"></i>
                        <p>list des paiments</p>
                    </a>
                </li>
                {{-- @endcan --}}
                {{-- @can('statuts_index') --}}
                <li
                    class="nav-item has-treeview {{ active_menu('statuts')[0] || active_menu('remarques')[0] || active_menu('villes')[0] || active_menu('expediteurs')[0] ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ active_menu('statuts')[1] || active_menu('remarques')[1] || active_menu('villes')[1] || active_menu('expediteurs')[1] ? 'active' : '' }}">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>
                            parametres
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('liste_statuts') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('statuts') }}" class="nav-link {{ setActive('statuts') }} ">
                                <i class="fa fa-power-off nav-icon"></i>
                                <p>list des statuts</p>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('liste_remarque') --}}
                        <li class="nav-item">
                            <a href="{{ adminurl('remarques') }}" class="nav-link {{ setActive('remarques') }} ">
                                <i class="fa fa-file nav-icon"></i>
                                <p>list des remarques</p>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('liste_villes') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('villes') }}" class="nav-link {{ setActive('villes') }} ">
                                <i class="fa fa-map nav-icon"></i>
                                <p>list des villes</p>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('liste_remarques') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('expediteurs') }}" class="nav-link {{ setActive('expediteurs') }} ">
                                <i class="fa fa-users nav-icon"></i>
                                <p>list des expediteurs</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}} 
                
                {{-- users links --}}
                @can('utilisateurs_inddex')
                    <li class="nav-header">Utilisateurs</li>
                    <li class="nav-item has-treeview {{ active_menu('users')[0] }}">
                        <a href="#" class="nav-link {{ active_menu('users')[1] }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Utilisateurs
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('nouveau_utilisateur')
                                <li class="nav-item">
                                    <a href="{{ adminUrl('users/create') }}"
                                        class="nav-link {{ setActive('users/create') }} ">
                                        <i class="fa fa-plus-circle nav-icon"></i>
                                        <p>ajouter nouveau</p>
                                    </a>
                                </li>
                            @endcan

                            @can('liste_utilisateurs')
                                <li class="nav-item">
                                    <a href="{{ adminUrl('users') }}" class="nav-link {{ setActive('users') }} ">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>liste</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                {{-- roles and permissions links --}}
                @can('autorisations_indexd')
                    <li class="nav-header">Autorisations des utilisateurs</li>
                    <li
                        class="nav-item has-treeview {{ active_menu('roles')[0] || active_menu('permission')[0] ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ active_menu('roles')[1] }}">
                            <i class="nav-icon fa fa-unlock"></i>
                            <p>
                                rôles
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('nouveau_rôle')
                                <li class="nav-item">
                                    <a href="{{ adminUrl('roles/create') }}"
                                        class="nav-link {{ setActive('roles/create') }} ">
                                        <i class="fa fa-plus-circle nav-icon"></i>
                                        <p>ajouter nouveau</p>
                                    </a>
                                </li>
                            @endcan

                            @can('liste_rôles')
                                <li class="nav-item">
                                    <a href="{{ adminUrl('roles') }}" class="nav-link {{ setActive('roles') }} ">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>liste</p>
                                    </a>
                                </li>
                            @endcan

                            @can('nouvelle_autorisation')
                                <li class="nav-item">
                                    <a href="{{ adminUrl('permission/create') }}"
                                        class="nav-link {{ setActive('permission/create') }} ">
                                        <i class="fa fa-lock nav-icon"></i>
                                        <p>nouvelle autorisation</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
