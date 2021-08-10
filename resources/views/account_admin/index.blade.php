@extends('layouts.account_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="ecommerce-widget">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <!-- CALENDAR-->
                        <div class="col-md-12 col-xs-12" style="background: #FFFFFF; border: 1px solid #FFFFFF; border-radius: 10px">
                            <div class="calendar-env">
                                <div class="calendar-body">
                                    <div id="notice_calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-brand-light">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Total Teachers</h5>
                                        <h2 class="mb-0"> {{ $number_of_teachers }}</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                        <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-info-light">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Total Students</h5>
                                        <h2 class="mb-0"> {{ count($students) }}</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                        <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-info-primary">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Total Present Today</h5>
                                        <h2 class="mb-0"> {{ $today_attendace_present }}</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                        <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Total Parents</h5>
                                        <h2 class="mb-0"> {{ count($system_settings->parent) }}</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                        <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-danger-light">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Total Unpaid Inoices</h5>
                                        <h2 class="mb-0"> {{ $unpaid_invoices }}</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                        <i class="fa fa-money-bill-alt fa-fw fa-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-success-light">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Total Income</h5>
                                        <h2 class="mb-0"> {{ ($total_income) }}</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                        <i class="fas fa-dollar-sign fa-fw fa-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body bg-danger-light">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Total Expense</h5>
                                        <h2 class="mb-0"> {{ array_sum($total_expense) }}</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                        <i class="fas fa-dollar-sign fa-fw fa-sm text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customScript')
    <style>
        .calendar-env {
            position: relative;
        }
        .calendar-env:before,
        .calendar-env:after {
            content: " ";
            /* 1 */
            display: table;
            /* 2 */
        }
        .calendar-env:after {
            clear: both;
        }
        hr + .calendar-env {
            margin-top: -18px;
            border-top: 1px solid #ebebeb;
            margin-left: -20px;
            margin-right: -20px;
        }
        .calendar-env + hr {
            margin-top: 0px;
            position: relative;
            margin-left: -20px;
            margin-right: -20px;
        }
        .calendar-env .calendar-sidebar,
        .calendar-env .calendar-body {
            float: left;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .calendar-env .calendar-sidebar:before,
        .calendar-env .calendar-body:before,
        .calendar-env .calendar-sidebar:after,
        .calendar-env .calendar-body:after {
            content: " ";
            /* 1 */
            display: table;
            /* 2 */
        }
        .calendar-env .calendar-sidebar:after,
        .calendar-env .calendar-body:after {
            clear: both;
        }
        .calendar-env .calendar-sidebar-row {
            padding: 20px;
        }
        .calendar-env > .calendar-sidebar-row.visible-xs {
            padding-bottom: 0;
        }
        .calendar-env .calendar-sidebar {
            width: 22%;
            background: #f9f9f9;
            border-right: 1px solid #ebebeb;
            position: relative;
        }
        .calendar-env .calendar-sidebar > h4 {
            padding: 20px;
        }
        .calendar-env .calendar-sidebar #add_event_form .input-group {
            background: #fff;
        }
        .calendar-env .calendar-sidebar .calendar-distancer {
            height: 40px;
        }
        .calendar-env .calendar-sidebar .events-list {
            border-top: 1px solid #ebebeb;
            padding-top: 20px;
            list-style: none;
            margin: 0;
            padding: 20px;
        }
        .calendar-env .calendar-sidebar .events-list li a {
            display: block;
            padding: 6px 8px;
            margin-bottom: 4px;
            -moz-transition: background 250ms ease-in-out, color 250ms ease-in-out;
            -o-transition: background 250ms ease-in-out, color 250ms ease-in-out;
            -webkit-transition: background 250ms ease-in-out, color 250ms ease-in-out;
            transition: background 250ms ease-in-out, color 250ms ease-in-out;
            -webkit-border-radius: 3px;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 3px;
            -moz-background-clip: padding;
            border-radius: 3px;
            background-clip: padding-box;
            background: #ee4749;
            color: #ffffff;
        }
        .calendar-env .calendar-sidebar .events-list li a:hover {
            background: #ec3032;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-blue {
            background: #21a9e1;
            color: #ffffff;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-blue:hover {
            background: #1c99cd;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-green {
            background: #00a651;
            color: #ffffff;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-green:hover {
            background: #008d45;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-primary {
            background: #303641;
            color: #ffffff;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-primary:hover {
            background: #252a32;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-orange {
            background: #ffae2f;
            color: #ffffff;
        }
        .calendar-env .calendar-sidebar .events-list li a.color-orange:hover {
            background: #ffa416;
        }
        .calendar-env .calendar-body {
            width: 100%;
            float: right;
        }
        .calendar-env .calendar-body .fc-header {
            border-bottom: 1px solid #ebebeb;
        }
        .calendar-env .calendar-body .fc-header h2,
        .calendar-env .calendar-body .fc-header h3 {
            margin: 0;
            padding: 0;
        }
        .calendar-env .calendar-body .fc-header .fc-header-left {
            padding: 20px;
        }
        .calendar-env .calendar-body .fc-header .fc-header-center {
            display: none;
        }
        .calendar-env .calendar-body .fc-header .fc-header-right {
            padding: 20px;
            text-align: right;
        }
        .calendar-env .calendar-body .fc-header .fc-button {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 12px;
            line-height: 1.42857143;
            border-radius: 3px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
            color: #303641;
            background-color: #ffffff;
            border-color: #ffffff;
            border-color: #ebebeb;
            -webkit-border-radius: 0;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 0;
            -moz-background-clip: padding;
            border-radius: 0;
            background-clip: padding-box;
            border-right-width: 0;
        }
        .calendar-env .calendar-body .fc-header .fc-button:focus {
            outline: thin dotted #333;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }
        .calendar-env .calendar-body .fc-header .fc-button:hover,
        .calendar-env .calendar-body .fc-header .fc-button:focus {
            color: #303641;
            text-decoration: none;
            outline: none;
        }
        .calendar-env .calendar-body .fc-header .fc-button:active,
        .calendar-env .calendar-body .fc-header .fc-button.active {
            outline: none;
            background-image: none;
            -moz-box-shadow: inset 0 0px 7px rgba(0, 0, 0, 0.225);
            -webkit-box-shadow: inset 0 0px 7px rgba(0, 0, 0, 0.225);
            box-shadow: inset 0 0px 7px rgba(0, 0, 0, 0.225);
            -moz-box-shadow: inset 0 0px 4px rgba(0, 0, 0, 0.2);
            -webkit-box-shadow: inset 0 0px 4px rgba(0, 0, 0, 0.2);
            box-shadow: inset 0 0px 4px rgba(0, 0, 0, 0.2);
        }
        .calendar-env .calendar-body .fc-header .fc-button.disabled,
        .calendar-env .calendar-body .fc-header .fc-button[disabled],
        fieldset[disabled] .calendar-env .calendar-body .fc-header .fc-button {
            cursor: not-allowed;
            pointer-events: none;
            -webkit-opacity: 0.65;
            -moz-opacity: 0.65;
            opacity: 0.65;
            filter: alpha(opacity=65);
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon {
            position: relative;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon i {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
        }
        .calendar-env .calendar-body .fc-header .fc-button:hover,
        .calendar-env .calendar-body .fc-header .fc-button:focus,
        .calendar-env .calendar-body .fc-header .fc-button:active,
        .calendar-env .calendar-body .fc-header .fc-button.active,
        .open .dropdown-toggle.calendar-env .calendar-body .fc-header .fc-button {
            color: #303641;
            background-color: #ebebeb;
            border-color: #e0e0e0;
        }
        .calendar-env .calendar-body .fc-header .fc-button:active,
        .calendar-env .calendar-body .fc-header .fc-button.active,
        .open .dropdown-toggle.calendar-env .calendar-body .fc-header .fc-button {
            background-image: none;
        }
        .calendar-env .calendar-body .fc-header .fc-button.disabled,
        .calendar-env .calendar-body .fc-header .fc-button[disabled],
        fieldset[disabled] .calendar-env .calendar-body .fc-header .fc-button,
        .calendar-env .calendar-body .fc-header .fc-button.disabled:hover,
        .calendar-env .calendar-body .fc-header .fc-button[disabled]:hover,
        fieldset[disabled] .calendar-env .calendar-body .fc-header .fc-button:hover,
        .calendar-env .calendar-body .fc-header .fc-button.disabled:focus,
        .calendar-env .calendar-body .fc-header .fc-button[disabled]:focus,
        fieldset[disabled] .calendar-env .calendar-body .fc-header .fc-button:focus,
        .calendar-env .calendar-body .fc-header .fc-button.disabled:active,
        .calendar-env .calendar-body .fc-header .fc-button[disabled]:active,
        fieldset[disabled] .calendar-env .calendar-body .fc-header .fc-button:active,
        .calendar-env .calendar-body .fc-header .fc-button.disabled.active,
        .calendar-env .calendar-body .fc-header .fc-button[disabled].active,
        fieldset[disabled] .calendar-env .calendar-body .fc-header .fc-button.active {
            background-color: #ffffff;
            border-color: #ffffff;
        }
        .calendar-env .calendar-body .fc-header .fc-button .badge {
            color: #ffffff;
            background-color: #303641;
        }
        .calendar-env .calendar-body .fc-header .fc-button > .caret {
            border-top-color: #303641;
            border-bottom-color: #303641 !important;
        }
        .calendar-env .calendar-body .fc-header .fc-button.dropdown-toggle {
            border-left-color: #ededed;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon {
            position: relative;
            padding-right: 39px;
            border: none;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon i {
            background-color: #ebebeb;
            padding: 6px 6px;
            font-size: 12px;
            line-height: 1.42857143;
            border-radius: 3px;
            -webkit-border-radius: 0 3px 3px 0;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 0 3px 3px 0;
            -moz-background-clip: padding;
            border-radius: 0 3px 3px 0;
            background-clip: padding-box;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.icon-left {
            padding-right: 12px;
            padding-left: 39px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.icon-left i {
            float: left;
            right: auto;
            left: 0;
            -webkit-border-radius: 3px 0 0 3px !important;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 3px 0 0 3px !important;
            -moz-background-clip: padding;
            border-radius: 3px 0 0 3px !important;
            background-clip: padding-box;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-lg {
            padding-right: 55px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-lg.icon-left {
            padding-right: 16px;
            padding-left: 55px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-lg i {
            padding: 10px 10px;
            font-size: 15px;
            line-height: 1.33;
            border-radius: 3px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-sm {
            padding-right: 36px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-sm.icon-left {
            padding-right: 10px;
            padding-left: 36px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-sm i {
            padding: 5px 6px;
            font-size: 11px;
            line-height: 1.5;
            border-radius: 2px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-xs {
            padding-right: 32px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-xs.icon-left {
            padding-right: 10px;
            padding-left: 32px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.btn-icon.btn-xs i {
            padding: 2px 6px;
            font-size: 10px;
            line-height: 1.5;
            border-radius: 2px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.fc-corner-left {
            -webkit-border-radius: 3px 0 0 3px;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 3px 0 0 3px;
            -moz-background-clip: padding;
            border-radius: 3px 0 0 3px;
            background-clip: padding-box;
        }
        .calendar-env .calendar-body .fc-header .fc-button.fc-corner-right {
            -webkit-border-radius: 0 3px 3px 0;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 0 3px 3px 0;
            -moz-background-clip: padding;
            border-radius: 0 3px 3px 0;
            background-clip: padding-box;
            border-right-width: 1px;
        }
        .calendar-env .calendar-body .fc-header .fc-button.fc-corner-left.fc-corner-right {
            -webkit-border-radius: 3px;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 3px;
            -moz-background-clip: padding;
            border-radius: 3px;
            background-clip: padding-box;
        }
        .calendar-env .calendar-body .fc-header .fc-button.fc-state-active {
            background: #f5f5f6;
        }
        .calendar-env .calendar-body .fc-header .fc-header-space {
            width: 10px;
            display: inline-block;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-cell-overlay {
            background: rgba(255, 255, 204, 0.5);
            -moz-transition: all 300ms ease-in-out;
            -o-transition: all 300ms ease-in-out;
            -webkit-transition: all 300ms ease-in-out;
            transition: all 300ms ease-in-out;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event {
            background: #000;
            padding: 2px 4px;
            margin-top: 2px;
            -webkit-border-radius: 3px;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 3px;
            -moz-background-clip: padding;
            border-radius: 3px;
            background-clip: padding-box;
            background: #ee4749;
            color: #ffffff;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event:hover {
            background: #ec3032;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-blue {
            background: #21a9e1;
            color: #ffffff;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-blue:hover {
            background: #1c99cd;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-green {
            background: #00a651;
            color: #ffffff;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-green:hover {
            background: #008d45;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-primary {
            background: #303641;
            color: #ffffff;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-primary:hover {
            background: #252a32;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-orange {
            background: #ffae2f;
            color: #ffffff;
        }
        .calendar-env .calendar-body .fc-content .fc-view .fc-event.color-orange:hover {
            background: #ffa416;
        }
        .calendar-env .calendar-body .fc-content .fc-view table thead tr th {
            text-align: center;
            padding: 5px 0;
            border-bottom: 1px solid #ebebeb;
            background: #f5f5f6;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day {
            vertical-align: text-top;
            text-align: right;
            border-bottom: 1px solid #ebebeb;
            padding-right: 10px;
            -moz-transition: all 300ms ease-in-out;
            -o-transition: all 300ms ease-in-out;
            -webkit-transition: all 300ms ease-in-out;
            transition: all 300ms ease-in-out;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day .fc-day-number {
            margin-top: 5px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day:hover {
            background-color: rgba(250, 250, 250, 0.68);
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number {
            color: #ffffff;
            background-color: #21a9e1;
            border-color: #21a9e1;
            display: inline-block;
            padding: 5px 8px;
            -webkit-border-radius: 3px;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 3px;
            -moz-background-clip: padding;
            border-radius: 3px;
            background-clip: padding-box;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number:hover,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number:focus,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number:active,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.active,
        .open .dropdown-toggle.calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number {
            color: #ffffff;
            background-color: #1a8fbf;
            border-color: #1782ad;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number:active,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.active,
        .open .dropdown-toggle.calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number {
            background-image: none;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.disabled,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number[disabled],
        fieldset[disabled] .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.disabled:hover,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number[disabled]:hover,
        fieldset[disabled] .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number:hover,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.disabled:focus,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number[disabled]:focus,
        fieldset[disabled] .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number:focus,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.disabled:active,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number[disabled]:active,
        fieldset[disabled] .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number:active,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.disabled.active,
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number[disabled].active,
        fieldset[disabled] .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.active {
            background-color: #21a9e1;
            border-color: #21a9e1;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number .badge {
            color: #21a9e1;
            background-color: #ffffff;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number > .caret {
            border-top-color: #ffffff;
            border-bottom-color: #ffffff !important;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.dropdown-toggle {
            border-left-color: #1a92c4;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon {
            position: relative;
            padding-right: 39px;
            border: none;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon i {
            background-color: #1a8fbf;
            padding: 6px 6px;
            font-size: 12px;
            line-height: 1.42857143;
            border-radius: 3px;
            -webkit-border-radius: 0 3px 3px 0;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 0 3px 3px 0;
            -moz-background-clip: padding;
            border-radius: 0 3px 3px 0;
            background-clip: padding-box;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.icon-left {
            padding-right: 12px;
            padding-left: 39px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.icon-left i {
            float: left;
            right: auto;
            left: 0;
            -webkit-border-radius: 3px 0 0 3px !important;
            -webkit-background-clip: padding-box;
            -moz-border-radius: 3px 0 0 3px !important;
            -moz-background-clip: padding;
            border-radius: 3px 0 0 3px !important;
            background-clip: padding-box;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-lg {
            padding-right: 55px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-lg.icon-left {
            padding-right: 16px;
            padding-left: 55px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-lg i {
            padding: 10px 10px;
            font-size: 15px;
            line-height: 1.33;
            border-radius: 3px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-sm {
            padding-right: 36px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-sm.icon-left {
            padding-right: 10px;
            padding-left: 36px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-sm i {
            padding: 5px 6px;
            font-size: 11px;
            line-height: 1.5;
            border-radius: 2px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-xs {
            padding-right: 32px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-xs.icon-left {
            padding-right: 10px;
            padding-left: 32px;
        }
        .calendar-env .calendar-body .fc-content .fc-view table tbody tr td.fc-day.fc-today .fc-day-number.btn-icon.btn-xs i {
            padding: 2px 6px;
            font-size: 10px;
            line-height: 1.5;
            border-radius: 2px;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-days,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-days {
            border-bottom: 1px solid #e6e6e6;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-days + div,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-days + div {
            margin-top: 1px;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-days th,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-days th,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-days td,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-days td {
            width: 1% !important;
            color: #666666;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-allday,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-allday {
            background: #fafafa;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-allday td,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-allday td,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-allday th,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-allday th {
            padding-top: 6px;
            padding-bottom: 6px;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-allday tbody tr .fc-agenda-axis,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-allday tbody tr .fc-agenda-axis {
            width: 60px !important;
            vertical-align: middle;
            text-align: right;
            color: #666666;
            border-right: 1px solid #e8e8e8;
            padding-right: 6px;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-divider,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-divider {
            height: 2px;
            background: #ebebeb;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-slots tr td,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-slots tr td,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-slots tr th,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-slots tr th {
            border-bottom: 1px dotted #ebebeb;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-slots tr td.fc-agenda-axis,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-slots tr td.fc-agenda-axis,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-slots tr th.fc-agenda-axis,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-slots tr th.fc-agenda-axis {
            width: 60px !important;
            text-align: right;
            color: #666666;
            border-right: 1px solid #e8e8e8;
            padding-right: 6px;
        }
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-slots tr.fc-minor td,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-slots tr.fc-minor td,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaWeek .fc-agenda-slots tr.fc-minor th,
        .calendar-env .calendar-body .fc-content .fc-view.fc-view-agendaDay .fc-agenda-slots tr.fc-minor th {
            border-bottom-color: #e6e6e6;
        }
        .calendar-env .calendar-body > div:last-child {
            border-bottom: 0;
        }
        .calendar-env.right-sidebar .calendar-sidebar {
            border-left: 1px solid #ebebeb;
            border-right: 0;
        }
        .calendar-env.right-sidebar .calendar-body {
            float: left;
        }
        @media (max-width: 959px) {
            .calendar-env .calendar-body .calendar-header div.calendar-title {
                width: 100%;
                white-space: normal;
            }
            .calendar-env .calendar-body .calendar-header .calendar-links {
                float: none;
                width: 100%;
                text-align: left;
                clear: left;
                padding-top: 10px;
            }
            .calendar-env .calendar-body .calendar-info {
                display: block;
            }
            .calendar-env .calendar-body .calendar-info .calendar-sender,
            .calendar-env .calendar-body .calendar-info .calendar-date {
                display: block;
                width: 100%;
            }
            .calendar-env .calendar-body .calendar-info .calendar-sender.calendar-sender,
            .calendar-env .calendar-body .calendar-info .calendar-date.calendar-sender {
                padding-top: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid #ebebeb;
            }
            .calendar-env .calendar-body .calendar-info .calendar-sender.calendar-date,
            .calendar-env .calendar-body .calendar-info .calendar-date.calendar-date {
                text-align: left;
                padding-top: 10px;
                padding-bottom: 10px;
            }
            .calendar-env .calendar-body .calendar-compose .compose-message-editor textarea {
                height: 300px;
            }
        }
        @media (max-width: 768px) {
            .calendar-env .calendar-sidebar {
                width: 30.8%;
            }
            .calendar-env .calendar-body {
                width: 69.2%;
            }
            .calendar-env .calendar-body .calendar-compose .compose-message-editor textarea {
                height: 240px;
            }
        }
        @media (max-width: 767px) {
            .calendar-env .calendar-sidebar,
            .calendar-env .calendar-body {
                width: 100%;
                float: none;
            }
            .calendar-env .calendar-body .calendar-header .calendar-title,
            .calendar-env .calendar-body .calendar-header .calendar-search,
            .calendar-env .calendar-body .calendar-header .calendar-links {
                float: none;
                width: 100%;
            }
            .calendar-env .calendar-body .calendar-header .calendar-title.calendar-search,
            .calendar-env .calendar-body .calendar-header .calendar-search.calendar-search,
            .calendar-env .calendar-body .calendar-header .calendar-links.calendar-search,
            .calendar-env .calendar-body .calendar-header .calendar-title.calendar-links,
            .calendar-env .calendar-body .calendar-header .calendar-search.calendar-links,
            .calendar-env .calendar-body .calendar-header .calendar-links.calendar-links {
                margin-top: 20px;
            }
            .calendar-env .calendar-body .calendar-header .calendar-links {
                padding-top: 0;
            }
            .fc-header {
                display: block;
            }
            .fc-header .fc-header-left,
            .fc-header .fc-header-center,
            .fc-header .fc-header-right,
            .fc-header tr,
            .fc-header tbody {
                display: block;
                text-align: center !important;
            }
            .fc-header .fc-header-right {
                text-align: center !important;
                padding-bottom: 10px;
            }
        }
    </style>
    <script src="{{ asset('assets/back/libs/js/fullcalendar.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            var calendar = $('#notice_calendar');

            $('#notice_calendar').fullCalendar({
                header: {
                    left: 'title',
                    right: 'today prev,next'
                },

                //defaultView: 'basicWeek',

                editable: false,
                firstDay: 1,
                height: 530,
                droppable: false,

                events: [
                    <?php
                    $teacher_birthdays    =   $system_settings->teacher()->get();
                    foreach($teacher_birthdays as $row):
                    ?>
                    {
                        title: "{{ $row->user->name }}",
                        start: new Date(<?php echo date('Y',strtotime($row->date_of_birth));?>, <?php echo date('m',strtotime($row->date_of_birth))-1;?>, <?php echo date('d',strtotime($row->date_of_birth));?>),
                        end:    new Date(<?php echo date('Y',strtotime($row->date_of_birth));?>, <?php echo date('m',strtotime($row->date_of_birth))-1;?>, <?php echo date('d',strtotime($row->date_of_birth));?>)
                    },
                    <?php
                    endforeach
                    ?>
                ]
            });
        });
    </script>

@endsection
