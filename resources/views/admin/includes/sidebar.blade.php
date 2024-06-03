<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background:rgb(8, 59, 66)">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/admin/dist/img/avatar5.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> {{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li
                    class="nav-item has-treeview {{ request()->is('admin/adminpanelsetting*') || request()->is('admin/treasuries*') ? 'menu-open' : '' }}  ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/adminpanelsetting*') || request()->is('admin/treasuries*') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الضبط العام
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.adminpanelsetting.index') }}"
                                class="nav-link {{ request()->is('admin/adminpanelsetting*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th" style='font-size:15px;color:rgb(224, 247, 16)'></i>
                                <p>
                                    الضبط العام
                                    {{--  <span class="right badge badge-danger">جديد</span>  --}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.treasuries.index') }}"
                                class="nav-link {{ request()->is('admin/treasuries*') ? 'active' : '' }}">
                                <i class='fas fa-archive' style='font-size:15px;color:rgb(224, 247, 16)'></i>
                                <p>
                                    بيانات الخزانات
                                    {{--  <span class="right badge badge-danger">جديد</span>  --}}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li
                    class="nav-item has-treeview {{ request()->is('admin/account_type*') || request()->is('admin/account*') || request()->is('admin/customers*') || request()->is('admin/suppliers_categories*') || request()->is('admin/suppliers*') ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/account_type*') || request()->is('admin/account*') || request()->is('admin/customers*') || request()->is('admin/suppliers_categories*') || request()->is('admin/suppliers*') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الحسابات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.account_type.index') }}"
                                class="nav-link {{ request()->is('admin/account_type*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    أنواع الحسابات المالية
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.account.index') }}"
                                class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    كل الحسابات المالية
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.customers.index') }}"
                                class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    بيانات حساب العملاء
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers_categories.index') }}"
                                class="nav-link {{ request()->is('admin/suppliers_categories*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    بيانات فئات الموردين
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers.index') }}"
                                class="nav-link {{ (request()->is('admin/suppliers*') and !request()->is('admin/suppliers_categories*') and !request()->is('admin/suppliers_with_order*')) ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    حسابات الموردين
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>



                <li
                    class="nav-item has-treeview {{ request()->is('admin/stores*') || request()->is('admin/Sales_material_types*') || request()->is('admin/inv_item_card*') || request()->is('admin/item_card_cats*') || request()->is('admin/inv_uoms*') ? 'menu-open' : '' }}  ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/stores*') || request()->is('admin/Sales_material_types*') || request()->is('admin/inv_item_card*') || request()->is('admin/item_card_cats*') || request()->is('admin/inv_uoms*') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            ضبط المخازن
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.Sales_material_types.index') }}"
                                class="nav-link {{ request()->is('admin/Sales_material_types*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    بيانات فئات الفواتير
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.stores.index') }}"
                                class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    بيانات المخازن
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.inv_uoms.index') }}"
                                class="nav-link {{ request()->is('admin/inv_uoms*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    بيانات الوحدات (الأصناف)
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item_card_cats.index') }}"
                                class="nav-link {{ request()->is('admin/item_card_cats*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    بيانات فئات الأصناف
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inv_item_card.index') }}"
                                class="nav-link {{ request()->is('admin/inv_item_card*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(205, 226, 17)'></i>
                                <p>
                                    الأصناف
                                </p>
                            </a>
                        </li>


                    </ul>
                </li>

                <li
                    class="nav-item has-treeview {{ request()->is('admin/supliers_with_order*') ? 'menu-open' : '' }}  ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/supliers_with_order*') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            حركات مخزنية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers_with_order.index') }}"
                                class="nav-link {{ request()->is('admin/supliers_with_order*') ? 'active' : '' }}">
                                <i class='fas fa-calendar ' style='font-size:15px;color:rgb(163, 250, 22)'></i>
                                <p>
                                    فواتير المشتريات
                                </p>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link  ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            المبيعات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">



                    </ul>
                </li>

                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link  ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            خدمات داخلية وخارجية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">



                    </ul>
                </li>

                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link  ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            حركة شفت الخزينة
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">



                    </ul>
                </li>



                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link  ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الصلاحيات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">



                    </ul>
                </li>

                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link  ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            التقارير
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">



                    </ul>
                </li>


                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link  ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            المراقبة والدعم الفني
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">



                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
