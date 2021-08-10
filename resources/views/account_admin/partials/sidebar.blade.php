@php
     $classes = App\Models\ClassW::where('school_id', Session::get('school_id'))->orderBy('numeric_name', 'ASC')->get();
@endphp

<div class="nav-left-sidebar bg-primary-light">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ ($page == 'Dashboard') ? 'active' : '' }}" href="{{ route('accountant.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ ($page == 'Nepali Calendar') ? 'active' : '' }}" href="{{ route('accountant.nepali.calendar') }}" target="_blank"><i class="fas fa-calendar"></i> Nepali Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'Expense Invoice' || $page == 'Fee Category' || $page == 'Scholarships' || $page == 'Expense Category' || $page == 'Create Student Invoice' || $page == 'View' || $page == 'Print Bulk') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-account" aria-controls="submenu-account">
                            <i class="fas fa-money-bill-alt"></i> Accounting
                        </a>
                        <div id="submenu-account" class="collapse submenu bg-light" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Fee Category') ? 'active' : '' }}" href="{{ route('accountant.fee.index') }}">
                                        <i class="fas fa-circle"></i> Fee Category
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Scholarships') ? 'active' : '' }}" href="{{ route('accountant.scholarship.index') }}">
                                        <i class="fas fa-circle"></i> Scholarship
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Expense Category') ? 'active' : '' }}" href="{{ route('accountant.expense.category.index') }}">
                                        <i class="fas fa-circle"></i> Expense Category
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Expense Invoice') ? 'active' : '' }}" href="{{ route('accountant.expense.invoice.index') }}">
                                        <i class="fas fa-circle"></i>Expense Invoice
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Create Student Invoice') ? 'active' : '' }}" href="{{ route('accountant.invoice.create') }}">
                                        <i class="fas fa-circle"></i> Create Student Invoice
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'All Invoices') ? 'active' : '' }}" href="{{ route('accountant.invoice.index') }}">
                                        <i class="fas fa-circle"></i> All Invoices
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Print Bulk') ? 'active' : '' }}" href="{{ route('accountant.invoice.print.bulk') }}">
                                        <i class="fas fa-circle"></i> Print Bulk
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ ($page == 'Transports') ? 'active' : '' }}" href="{{ route('transport.accountant.index') }}"><i class="fas fa-map-marker"></i> Transport</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
