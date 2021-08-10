@php
     $classes = App\Models\ClassW::where('school_id', Auth::user()->school->id)->orderBy('numeric_name', 'ASC')->get();
@endphp
<div class="nav-left-sidebar bg-primary-light">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item ">
                        <a class="nav-link {{ ($page == 'Dashboard') ? 'active' : '' }}" href="{{ route('school.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ ($page == 'Nepali Calendar') ? 'active' : '' }}" href="{{ route('nepali.calendar') }}" target="_blank"><i class="fas fa-calendar"></i> Nepali Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'Admit' || $page == 'Student Information' || $page == 'Student Report') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-student" aria-controls="submenu-student"><i class="fas fa-users"></i>Student</a>
                        <div id="submenu-student" class="collapse submenu bg-light" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Admit') ? 'active' : '' }}" href="{{ route('student.admit') }}">
                                        <i class="fas fa-circle"></i> Admit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Admit Bulk') ? 'active' : '' }}" href="{{ route('student.admit.bulk') }}">
                                        <i class="fas fa-circle"></i> Admit Bulk
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Student Information') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-info" aria-controls="submenu-info">
                                        <i class="fas fa-info"></i> Student Information
                                    </a>
                                    <div id="submenu-info" class="collapse submenu bg-light" style="">
                                        <ul class="nav flex-column">
                                            @foreach ($classes as $class)
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{  route('class.student.index', $class->id) }}">
                                                        {{  $class->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Student Promotion') ? 'active' : '' }}" href="{{ route('student.promotion.index') }}">
                                        <i class="fas fa-circle"></i> Student Promotion
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Student Report') ? 'active' : '' }}" href="{{ route('student.report') }}">
                                        <i class="fas fa-circle"></i> Student Report
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ ($page == 'Teacher') ? 'active' : '' }}" href="{{ route('teacher.index') }}"><i class="fas fa-users"></i> Teacher</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ ($page == 'Parents') ? 'active' : '' }}" href="{{ route('parent.index') }}"><i class="fas fa-users"></i> Parent</a>
                    </li>
                    @if($system_settings->id == 1)
                        <li class="nav-item ">
                            <a class="nav-link {{ ($page == 'Accountants') ? 'active' : '' }}" href="{{ route('accountant.index') }}"><i class="fas fa-briefcase"></i> Accountant</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'Class' || $page == 'Section') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-sitemap"></i>Class</a>
                        <div id="submenu-1" class="collapse submenu bg-light" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Class') ? 'active' : '' }}" href="{{ route('class.index') }}">
                                        <i class="fas fa-circle"></i> Manage Class
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Section') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2">
                                        <i class="fas fa-sitemap"></i> Manage Sections
                                    </a>
                                    <div id="submenu-2" class="collapse submenu bg-light" style="">
                                        <ul class="nav flex-column">
                                            @foreach ($classes as $class)
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{  route('class.section.index', $class->id) }}">
                                                        {{  $class->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'Subjects') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4">
                            <i class="fas fa-book"></i> Subjects
                        </a>
                        <div id="submenu-4" class="collapse submenu bg-light" style="">
                            <ul class="nav flex-column">
                                @foreach ($classes as $class)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{  route('class.subject.index', $class->id) }}">
                                            {{  $class->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @if($system_settings->id == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ ($page == 'Class Routine') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-routine" aria-controls="submenu-routine">
                                <i class="fas fa-clock"></i> Class Routine
                            </a>
                            <div id="submenu-routine" class="collapse submenu bg-light" style="">
                                <ul class="nav flex-column">
                                    @foreach ($classes as $class)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{  route('class.routine.index', $class->id) }}">
                                                {{  $class->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if($system_settings->id == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ ($page == 'Daily Attendance' || $page == 'Attendance Report' || $page == 'Attendance Report Month') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-attendance" aria-controls="submenu-attendance">
                                <i class="fas fa-chart-line"></i> Daily Attendance
                            </a>
                            <div id="submenu-attendance" class="collapse submenu bg-light" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Daily Attendance') ? 'active' : '' }}" href="{{  route('attendance.index') }}">
                                            Daily Attendance
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Attendance Report') ? 'active' : '' }}" href="{{  route('attendance.report') }}">
                                            Attendance Report
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Attendance Report Month') ? 'active' : '' }}" href="{{  route('attendance.report.month') }}">
                                            Attendance Report By Month
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                         <li class="nav-item ">
                            <a class="nav-link {{ ($page == 'Attendance') ? 'active' : '' }}" href="{{ route('manual.attendace.index') }}"><i class="fas fa-clock"></i> Manual Attendance</a>
                        </li>
                    @else
                        <li class="nav-item ">
                            <a class="nav-link {{ ($page == 'Attendance') ? 'active' : '' }}" href="{{ route('manual.attendace.index') }}"><i class="fas fa-clock"></i> Manual Attendance</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'Exam List' || $page == 'Exam Grade' || $page == 'Manage Marks' || $page == 'Tabulation Sheet' || $page == 'Marksheet' || $page == 'Manage Marks Optional') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-exam" aria-controls="submenu-exam">
                            <i class="fas fa-tasks"></i> Exam
                        </a>
                        <div id="submenu-exam" class="collapse submenu bg-light" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'Exam List') ? 'active' : '' }}" href="{{  route('exam.index') }}">
                                        Exam List
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" {{ ($page == 'Exam Grade') ? 'active' : '' }} href="{{  route('grade.index') }}">
                                        Exam Grade
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" {{ ($page == 'Manage Marks') ? 'active' : '' }} href="{{  route('marks.manage.index') }}">
                                        Manage Marks
                                    </a>
                                </li>
                                @if($system_settings->id == 2)
                                    <li class="nav-item">
                                        <a class="nav-link" {{ ($page == 'Manage Marks Optional') ? 'active' : '' }} href="{{  route('marks.manage.optional.index') }}">
                                            Manage Marks Optional
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" {{ ($page == 'Tabulation Sheet') ? 'active' : '' }} href="{{  route('marks.tabulation.sheet') }}">
                                        Tabulation Sheet
                                    </a>
                                </li>
                                @if($system_settings->id == 1)
                                    <li class="nav-item">
                                        <a class="nav-link" {{ ($page == 'Tabulation Sheet') ? 'active' : '' }} href="{{  route('marks.sheet.print.tabulation') }}">
                                            Print Tabulation Sheet
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" {{ ($page == 'Marksheet') ? 'active' : '' }} href="{{  route('marks.print') }}">
                                        Marksheet
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @if($system_settings->id == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ ($page == 'Fee Category' || $page == 'Scholarships' || $page == 'Expense Category' || $page == 'Create Student Invoice' || $page == 'View' ||  $page == 'Previous' || $page == 'Due' || $page == 'By Student' || $page == 'By Date' || $page == 'By Class Particular' || $page == 'By Particular' || $page == 'Summary Of Due' || $page == 'Expense Invoice' || $page == 'Summary Of Expense' || $page == 'Expense Report' || $page == 'By Payment Received Date') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-account" aria-controls="submenu-account">
                                <i class="fas fa-money-bill-alt"></i> Accounting
                            </a>
                            <div id="submenu-account" class="collapse submenu bg-light" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Fee Category') ? 'active' : '' }}" href="{{ route('fee.index') }}">
                                            <i class="fas fa-circle"></i> Fee Category
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Scholarships') ? 'active' : '' }}" href="{{ route('scholarship.index') }}">
                                            <i class="fas fa-circle"></i> Scholarship
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Expense Category') ? 'active' : '' }}" href="{{ route('expense.category.index') }}">
                                            <i class="fas fa-circle"></i> Expense Category
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Expense Invoice') ? 'active' : '' }}" href="{{ route('expense.invoice.index') }}">
                                            <i class="fas fa-circle"></i>Expense Invoice
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Summary Of Expense') ? 'active' : '' }}" href="{{ route('expense.report.summary') }}">
                                            <i class="fas fa-circle"></i>Summary Of Expense
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Expense Report') ? 'active' : '' }}" href="{{ route('expense.report') }}">
                                            <i class="fas fa-circle"></i>Expense Report
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Create Student Invoice') ? 'active' : '' }}" href="{{ route('invoice.create') }}">
                                            <i class="fas fa-circle"></i> Create Student Invoice
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'All Invoices') ? 'active' : '' }}" href="{{ route('invoice.index') }}">
                                            <i class="fas fa-circle"></i> All Invoices
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ ($page == 'Previous' || $page == 'Due' || $page == 'By Student' || $page == 'By Date' || $page == 'By Class Particular' || $page == 'Particular' || $page = 'Summary Of Due' || $page == 'By Payment Received Date') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-reports" aria-controls="submenu-reports">
                                            <i class="fas fa-info"></i> Reports
                                        </a>
                                        <div id="submenu-reports" class="collapse submenu bg-light" style="">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'Previous') ? 'active' : '' }}" href="{{ route('report.previous.class') }}">
                                                        Previous Invoice
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'Due') ? 'active' : '' }}" href="{{ route('report.due.class') }}">
                                                        Due
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'By Student') ? 'active' : '' }}" href="{{ route('report.class.student') }}">
                                                        By Student
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'By Date And Class') ? 'active' : '' }}" href="{{ route('report.class.date') }}">
                                                        By Date And Class
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'By Date') ? 'active' : '' }}" href="{{ route('report.date') }}">
                                                        By Date
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'By Payment Received Date') ? 'active' : '' }}" href="{{ route('report.payment.received.date') }}">
                                                        By Payment Received Date
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'By Class Particular') ? 'active' : '' }}" href="{{ route('report.class.particular') }}">
                                                        By Class Particular
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'By Particular') ? 'active' : '' }}" href="{{ route('report.particular') }}">
                                                        By Particular
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'Summary Of Due') ? 'active' : '' }}" href="{{ route('report.summary.due') }}">
                                                        Summary Of Due
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('report.transport') }}">
                                                       By Transport
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('report.scholarship') }}">
                                                        By Scholarship
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($page == 'Summary Of Income') ? 'active' : '' }}" href="{{ route('report.invoice.summary') }}">
                                                       Summary Of Income
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ ($page == 'Transports') ? 'active' : '' }}" href="{{ route('transport.index') }}"><i class="fas fa-map-marker"></i> Transport</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'General Settings') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-cogs"></i>Settings</a>
                        <div id="submenu-3" class="collapse submenu bg-light" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($page == 'General Settings') ? 'active' : '' }}" href="{{ route('school.setting') }}">
                                        <i class="fas fa-building"></i> General Settings
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
