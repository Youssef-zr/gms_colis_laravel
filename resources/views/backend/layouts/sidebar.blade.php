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

                {{-- statuses links --}}
                {{-- @can('statuts_index') --}}
                <li class="nav-header">statuts</li>
                <li class="nav-item has-treeview {{ active_menu('statuses')[0] }}">
                    <a href="#" class="nav-link {{ active_menu('statuses')[1] }}">
                        <i class="nav-icon fa fa-power-off"></i>
                        <p>
                            statuts
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('ajouter_statut') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('statuses/create') }}"
                                class="nav-link {{ setActive('statuses/create') }} ">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>nouveau</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('liste_statuts') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('statuses') }}" class="nav-link {{ setActive('statuses') }} ">
                                <i class="fa fa-chevron-right nav-icon"></i>
                                <p>list des statuts</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}

                {{-- notes links --}}
                {{-- @can('remarques_index') --}}
                <li class="nav-header">remarques</li>
                <li class="nav-item has-treeview {{ active_menu('notes')[0] }}">
                    <a href="#" class="nav-link {{ active_menu('notes')[1] }}">
                        <i class="nav-icon fa fa-commenting-o"></i>
                        <p>
                            remarques
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('ajouter_remarque') --}}
                        <li class="nav-item">
                            <a href="{{ adminurl('notes/create') }}"
                                class="nav-link {{ setActive('notes/create') }} ">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>nouveau</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('liste_remarque') --}}
                        <li class="nav-item">
                            <a href="{{ adminurl('notes') }}" class="nav-link {{ setActive('notes') }} ">
                                <i class="fa fa-chevron-right nav-icon"></i>
                                <p>list des remarques</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}

                {{-- cities links --}}
                {{-- @can('ville_index') --}}
                <li class="nav-header">villes</li>
                <li class="nav-item has-treeview {{ active_menu('cities')[0] }}">
                    <a href="#" class="nav-link {{ active_menu('cities')[1] }}">
                        <i class="nav-icon fa fa-map"></i>
                        <p>
                            villes
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('ajouter_ville') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('cities/create') }}"
                                class="nav-link {{ setActive('cities/create') }} ">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>nouveau</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('liste_villes') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('cities') }}" class="nav-link {{ setActive('cities') }} ">
                                <i class="fa fa-chevron-right nav-icon"></i>
                                <p>list des villes</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}

                {{-- bundels links --}}
                {{-- @can('colis_index') --}}
                <li class="nav-header">colis</li>
                <li class="nav-item has-treeview {{ active_menu('bundels')[0] }}">
                    <a href="#" class="nav-link {{ active_menu('bundels')[1] }}">
                        <i class="nav-icon fa fa-shopping-basket"></i>
                        <p>
                            colis
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('ajouter_colis') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('bundels/create') }}"
                                class="nav-link {{ setActive('bundels/create') }} ">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>nouveau</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('liste_colis') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('bundels') }}" class="nav-link {{ setActive('bundels') }} ">
                                <i class="fa fa-chevron-right nav-icon"></i>
                                <p>list des colis</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}

                {{-- payments links --}}
                {{-- @can('paiments_index') --}}
                <li class="nav-header">paiments</li>
                <li class="nav-item has-treeview {{ active_menu('payments')[0] }}">
                    <a href="#" class="nav-link {{ active_menu('payments')[1] }}">
                        <i class="nav-icon fa fa-credit-card-alt"></i>
                        <p>
                            paiments
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('ajouter_paiments') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('payments/create') }}"
                                class="nav-link {{ setActive('payments/create') }} ">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>nouveau</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('liste_paiments') --}}
                        <li class="nav-item">
                            <a href="{{ adminUrl('payments') }}" class="nav-link {{ setActive('payments') }} ">
                                <i class="fa fa-chevron-right nav-icon"></i>
                                <p>list des paiments</p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}

                {{-- users links --}}
                @can('utilisateurs_index')
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
                @can('autorisations_index')
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
