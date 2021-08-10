<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

/*Route::get('/home', 'HomeController@index')->name('home');*/

Route::group(['prefix' => 'master/dashboard','middleware' => 'IsMaster'], function() {

    Route::get('/', 'MasterController@index')->name('master.dashboard');

    //Licenses
    Route::get('/license/all/', 'LicenseController@index')->name('license.index');
    Route::post('/license/store', 'LicenseController@store')->name('license.store');
    Route::post('/license/update', 'LicenseController@update')->name('license.update');
    Route::get('/license/{id}/delete','LicenseController@delete')->name('license.delete');
    Route::get('/license/{id}/restore','LicenseController@restore')->name('license.restore');

    //Schools
    Route::get('/school/all/', 'SchoolController@index')->name('school.index');
    Route::post('/school/store', 'SchoolController@store')->name('school.store');
    Route::post('/school/update', 'SchoolController@update')->name('school.update');
    Route::get('/school/{id}/delete','SchoolController@delete')->name('school.delete');
    Route::get('/school/{id}/restore','SchoolController@restore')->name('school.restore');

    //School License
    Route::post('/school/license/update', 'SchoolController@licenseUpdate')->name('school.license.update');
});


Route::group(['prefix' => 'school/dashboard','middleware' => 'IsSchoolAdmin'], function() {

    Route::get('/', 'SchoolAdminController@index')->name('school.dashboard');
    Route::get('/nepali/calendar', 'SchoolAdminController@nepaliCaledar')->name('nepali.calendar');

    //system-settings
    Route::get('/school/settings', 'SchoolSettingController@index')->name('school.setting');
    Route::post('/school/settings/update', 'SchoolSettingController@update')->name('school.setting.update');

    //Teacher
    Route::get('/teacher/all/', 'TeacherController@index')->name('teacher.index');
    Route::post('/teacher/store', 'TeacherController@store')->name('teacher.store');
    Route::post('/teacher/update', 'TeacherController@update')->name('teacher.update');
    Route::get('/teacher/{id}/delete','TeacherController@delete')->name('teacher.delete');
    Route::get('/teacher/{id}/restore','TeacherController@restore')->name('teacher.restore');

    //Bulk Teacher Import
    Route::get('teacher/bulk', 'TeacherController@bulkImport')->name('teacher.import.bulk');
    Route::post('teacher/bulk/store', 'TeacherController@bulkImportStore')->name('teacher.import.bulk.store');

    //Class
    Route::get('/class/all/', 'ClassController@index')->name('class.index');
    Route::post('/class/store', 'ClassController@store')->name('class.store');
    Route::post('/class/update', 'ClassController@update')->name('class.update');
    Route::get('/class/{id}/delete','ClassController@delete')->name('class.delete');
    Route::get('/class/{id}/restore','ClassController@restore')->name('class.restore');

    //Bulk Class Import
    Route::get('class/bulk', 'ClassController@bulkImport')->name('class.import.bulk');
    Route::post('class/bulk/store', 'ClassController@bulkImportStore')->name('class.import.bulk.store');

    //Section
    Route::get('/class/section/{key}/', 'ClassSectionController@sectionByClassId')->name('class.section.index');
    Route::post('/section/store', 'ClassSectionController@store')->name('section.store');
    Route::post('/section/update', 'ClassSectionController@update')->name('section.update');
    Route::get('/section/{id}/delete','ClassSectionController@delete')->name('section.delete');
    Route::get('/section/{id}/restore','ClassSectionController@restore')->name('section.restore');

    //Subject
    Route::get('/class/subject/{key}/', 'SubjectController@subjectByClassId')->name('class.subject.index');
    Route::post('/subject/store', 'SubjectController@store')->name('subject.store');
    Route::post('/subject/update', 'SubjectController@update')->name('subject.update');
    Route::get('/subject/{id}/delete','SubjectController@delete')->name('subject.delete');
    Route::get('/subject/{id}/restore','SubjectController@restore')->name('subject.restore');

    //Parent
    Route::get('/parent/all/', 'ParentController@index')->name('parent.index');
    Route::post('/parent/store', 'ParentController@store')->name('parent.store');
    Route::post('/parent/update', 'ParentController@update')->name('parent.update');
    Route::get('/parent/{id}/delete','ParentController@delete')->name('parent.delete');
    Route::get('/parent/{id}/restore','ParentController@restore')->name('parent.restore');

    //Bulk Parent Import
    Route::get('parent/bulk', 'ParentController@bulkImport')->name('parent.import.bulk');
    Route::post('parent/bulk/store', 'ParentController@bulkImportStore')->name('parent.import.bulk.store');

    //Transport
    Route::get('/transport/all/', 'TransportController@index')->name('transport.index');
    Route::post('/transport/store', 'TransportController@store')->name('transport.store');
    Route::post('/transport/update', 'TransportController@update')->name('transport.update');
    Route::get('/transport/{id}/delete','TransportController@delete')->name('transport.delete');
    Route::get('/transport/{id}/restore','TransportController@restore')->name('transport.restore');
    Route::get('/transport/{id}/students','TransportController@students')->name('transport.view.student');
    Route::get('/transport/{id}/student/remove','TransportController@studentRemove')->name('transport.remove.student');

    //Student
    Route::get('admint/student/', 'StudentController@admit')->name('student.admit');
    Route::post('admint/student/store', 'StudentController@admitStore')->name('student.admit.store');
    Route::get('/class/student/{key}/', 'StudentController@studentByClassId')->name('class.student.index');
    Route::get('/class/student/{class_id}/{section_id}', 'StudentController@studentByClassAndSectionId')->name('class.student.section.index');
    Route::post('/student/update','StudentController@update')->name('student.update');
    Route::get('/student/{id}/delete','StudentController@delete')->name('student.delete');
    Route::get('/student/{id}/restore','StudentController@restore')->name('student.restore');
    Route::post('/student/scholarship/update', 'StudentController@updateScholarship')->name('student.scholarship.update');
    Route::get('/student/{id}/mark/left','StudentController@markLeft')->name('student.mark.left');
    Route::get('/student/{id}/mark/unleft','StudentController@markUnLeft')->name('student.mark.unleft');
    Route::get('/left/students/{id}', 'StudentController@leftStudentByClass')->name('class.student.left');
    Route::get('/student/{id}/demote','StudentController@demote')->name('student.demote');
    Route::get('/student/{id}/jump','StudentController@jump')->name('student.jump');
    Route::get('/student/search','StudentController@searchStudent')->name('student.search');
    Route::get('/student/view/{id}','StudentController@viewStudent')->name('student.view');

    //Student Promotion
    Route::get('student/promotion', 'StudentPromotionController@index')->name('student.promotion.index');
    Route::post('student/promotion/store', 'StudentPromotionController@store')->name('student.promotion.store');

    //Student Report
    Route::get('student/report', 'StudentController@report')->name('student.report');
    Route::get('student/report/get', 'StudentController@reportByClassId')->name('student.report.class');

    //Admit Bulk
    Route::get('admit/student/bulk', 'StudentController@admitBulk')->name('student.admit.bulk');
    Route::get('admit/student/download/csv', 'StudentController@downladCsv')->name('student.download.csv');
    Route::post('admit/student/bulk/store', 'StudentController@admitBulkStore')->name('student.admit.bulk.store');

    //Fee Category
    Route::get('/fee/all/', 'FeeController@index')->name('fee.index');
    Route::post('/fee/store', 'FeeController@store')->name('fee.store');
    Route::post('/fee/update', 'FeeController@update')->name('fee.update');
    Route::get('/fee/{id}/delete','FeeController@delete')->name('fee.delete');
    Route::get('/fee/{id}/restore','FeeController@restore')->name('fee.restore');

    //Scholarship Category
    Route::get('/scholarship/all/', 'ScholarshipController@index')->name('scholarship.index');
    Route::post('/scholarship/store', 'ScholarshipController@store')->name('scholarship.store');
    Route::post('/scholarship/update', 'ScholarshipController@update')->name('scholarship.update');
    Route::get('/scholarship/{id}/delete','ScholarshipController@delete')->name('scholarship.delete');
    Route::get('/scholarship/{id}/restore','ScholarshipController@restore')->name('scholarship.restore');
    Route::get('/scholarship/{id}/students','ScholarshipController@students')->name('scholarship.view.student');
    Route::get('/scholarship/{id}/student/remove','ScholarshipController@studentRemove')->name('scholarship.remove.student');

    //Exam
    Route::get('/exam/all/', 'ExamController@index')->name('exam.index');
    Route::post('/exam/store', 'ExamController@store')->name('exam.store');
    Route::post('/exam/update', 'ExamController@update')->name('exam.update');
    Route::get('/exam/{id}/delete','ExamController@delete')->name('exam.delete');
    Route::get('/exam/{id}/restore','ExamController@restore')->name('exam.restore');

    //Grade
    Route::get('/grade/all/', 'ExamGradeController@index')->name('grade.index');
    Route::post('/grade/store', 'ExamGradeController@store')->name('grade.store');
    Route::post('/grade/update', 'ExamGradeController@update')->name('grade.update');
    Route::get('/grade/{id}/delete','ExamGradeController@delete')->name('grade.delete');
    Route::get('/grade/{id}/restore','ExamGradeController@restore')->name('grade.restore');

    //Accountant
    Route::get('/accountant/all/', 'AccountantController@index')->name('accountant.index');
    Route::post('/accountant/store', 'AccountantController@store')->name('accountant.store');
    Route::post('/accountant/update', 'AccountantController@update')->name('accountant.update');
    Route::get('/accountant/{id}/delete','AccountantController@delete')->name('accountant.delete');
    Route::get('/accountant/{id}/restore','AccountantController@restore')->name('accountant.restore');

    //Expense Category
    Route::get('/expense/category/all/', 'ExpenseCategoryController@index')->name('expense.category.index');
    Route::post('/expense/category/store', 'ExpenseCategoryController@store')->name('expense.category.store');
    Route::post('/expense/category/update', 'ExpenseCategoryController@update')->name('expense.category.update');
    Route::get('/expense/category/{id}/delete','ExpenseCategoryController@delete')->name('expense.category.delete');
    Route::get('/expense/category/{id}/restore','ExpenseCategoryController@restore')->name('expense.category.restore');

    //getStudents
    Route::get('/student/{id}/', 'SchoolAdminController@getStudents');

    //getClassFeeCategory
    Route::get('/class/fee/{id}/', 'SchoolAdminController@getClassFee');
    Route::get('/class/fee/half/{id}', 'SchoolAdminController@getClassFeeHalf');
    Route::get('/class/fees/{id}/', 'SchoolAdminController@getClassFeeInDropDown');
    Route::get('/class/sections/{id}/', 'SchoolAdminController@getClassSectionInDropDown');
    Route::get('/class/section/routine/{id}/', 'SchoolAdminController@getSectionRoutineInDropDown');
    Route::get('/class/subjects/{id}/', 'SchoolAdminController@getClassSubjectInDropDown');
    Route::get('/class/subjects/optional/{id}/', 'SchoolAdminController@getClassOptionalSubjectInDropDown');

    //getStudentTransport
    Route::get('/student/transport/{id}/', 'SchoolAdminController@getStudentTransport');

    //getStudentScholarship
    Route::get('/student/scholarship/{id}/', 'SchoolAdminController@getStudentScholarship');

    //getPreviousInvoice
    Route::get('/student/previous/invoice/{id}/', 'SchoolAdminController@getStudentPreviousInvoice');

    Route::get('/get_students_to_promote/{from_class_id}/{to_class_id}/{running_year}/{promotion_year}', 'SchoolAdminController@get_students_to_promote');

    //Invoice
    Route::get('/invoice/all/', 'InvoiceController@index')->name('invoice.index');
    Route::get('/invoice/create/', 'InvoiceController@create')->name('invoice.create');
    Route::post('/invoice/store/', 'InvoiceController@store')->name('invoice.store');
    Route::get('/invoice/view/{id}', 'InvoiceController@view')->name('invoice.view');
    Route::get('/invoice/delete/{id}', 'InvoiceController@delete')->name('invoice.delete');
    Route::post('/invoice/take/payment', 'InvoiceController@takePayment')->name('invoice.take.payment');

    //Invoice Report
    Route::get('/invoice/previous/', 'InvoiceReportController@previousByClassId')->name('report.previous.class');
    Route::get('/invoice/due/', 'InvoiceReportController@dueByClassId')->name('report.due.class');
    Route::get('/invoice/class/', 'InvoiceReportController@dueByClassAndStudentId')->name('report.class.student');
    Route::get('/invoice/class/date/', 'InvoiceReportController@allByClassAndDate')->name('report.class.date');
    Route::get('/invoice/date/', 'InvoiceReportController@allByDate')->name('report.date');
    Route::get('/invoice/payment/received/date', 'InvoiceReportController@paymentReceivedDate')->name('report.payment.received.date');
    Route::get('/invoice/class/particluar/', 'InvoiceReportController@reportByClassParticularId')->name('report.class.particular');
    Route::get('/invoice/particluar/all', 'InvoiceReportController@reportByPartiularId')->name('report.particular');
    Route::get('/invoice/due/summary', 'InvoiceReportController@reportOfDueByDate')->name('report.summary.due');
    Route::get('/invoice/transport/', 'InvoiceReportController@reportByTransport')->name('report.transport');
    Route::get('/invoice/scholarship/', 'InvoiceReportController@reportByScholarship')->name('report.scholarship');
    Route::get('/invoice/summary/', 'InvoiceReportController@invoiceSummary')->name('report.invoice.summary');

    //Expense Invoice
    Route::get('/expense/invoice/all/', 'ExpenseInvoiceController@index')->name('expense.invoice.index');
    Route::post('/expense/invoice/store', 'ExpenseInvoiceController@store')->name('expense.invoice.store');
    Route::post('/expense/invoice/update', 'ExpenseInvoiceController@update')->name('expense.invoice.update');
    Route::get('/expense/invoice/{id}/delete','ExpenseInvoiceController@delete')->name('expense.invoice.delete');
    Route::get('/expense/invoice/{id}/restore','ExpenseInvoiceController@restore')->name('expense.invoice.restore');
    Route::get('/expense/report/summary', 'ExpenseInvoiceController@reportSumary')->name('expense.report.summary');
    Route::get('/expense/report/', 'ExpenseInvoiceController@report')->name('expense.report');

    //Class Routine
    Route::get('/class/routine/{key}/', 'ClassRoutineController@routineByClassId')->name('class.routine.index');
    Route::post('/routine/store', 'ClassRoutineController@store')->name('routine.store');
    Route::post('/routine/update', 'ClassRoutineController@update')->name('routine.update');
    Route::get('/routine/{id}/delete','ClassRoutineController@delete')->name('routine.delete');
    Route::get('/routine/{id}/print','ClassRoutineController@print')->name('routine.print');

    //Attendance
    Route::get('/attendance/', 'AttendanceController@index')->name('attendance.index');
    Route::get('/attendance/form', 'AttendanceController@form')->name('attendance.form');
    Route::get('/attendance/create/', 'AttendanceController@create')->name('attendance.create');
    Route::post('/attendance/store/', 'AttendanceController@store')->name('attendance.store');
    Route::get('/attendance/view/{class_id}/{section_id}/{date}', 'AttendanceController@view')->name('attendance.view');
    Route::post('/attendance/update', 'AttendanceController@update')->name('attendance.update');
    Route::get('/attendance/report', 'AttendanceController@attendnceReportByClassAndDate')->name('attendance.report');
    Route::get('/attendance/report-view/{class_id}/{section_id}/{date}', 'AttendanceController@reportView')->name('attendance.report.view');
    Route::get('/attendance/report/view/month', 'AttendanceController@attendnceReportByClassAndMonth')->name('attendance.report.month');

    //Marks Manages
    Route::get('/manage/marks', 'ExamMarkController@manage')->name('marks.manage.index');
    Route::get('/manage/marks/create', 'ExamMarkController@create')->name('marks.manage.create');
    Route::post('/manage/marks/update', 'ExamMarkController@update')->name('marks.manage.update');

    //Marks Tabulation Sheer
    Route::get('/tabulation/sheet', 'ExamMarkController@tabulationSheet')->name('marks.tabulation.sheet');
    Route::post('/update/mark', 'ExamMarkController@updateMark')->name('update.mark');
    Route::get('/mark/sheet', 'ExamMarkController@markSheet')->name('marks.print');
    Route::get('/mark/sheet/view/{exam_id}/{class_id}/{student_id}', 'ExamMarkController@markSheetView')->name('marks.view');
    Route::post('/mark/sheet/print/all', 'ExamMarkController@markSheetPrintAll')->name('marks.print.all');

    //Print Tabulation sheet
    Route::get('/tabulation/sheet/print', 'ExamMarkController@tabulationSheetPrint')->name('marks.sheet.print.tabulation');
    Route::get('/tabulation/sheet/print/all/{exam_id}/{class_id}/{section_id}', 'ExamMarkController@tabulationSheetCSV');

    //Maual Attendance
    Route::get('/manual/attendance/', 'ManualAttentaceController@index')->name('manual.attendace.index');
    Route::post('/manual/attendance/store', 'ManualAttentaceController@store')->name('manual.attendace.store');
    Route::post('/manual/attendance/update', 'ManualAttentaceController@update')->name('manual.attendace.update');

    //Marks Manage Optional
    Route::get('/manage/marks/optinal', 'ExamMarkController@manageOptional')->name('marks.manage.optional.index');
    Route::get('/manage/marks/optinal/create', 'ExamMarkController@createOptional')->name('marks.manage.optional.create');
    Route::post('/manage/marks/optinal/update', 'ExamMarkController@updateOptional')->name('marks.manage.optional.update');

});

Route::group(['prefix' => 'accountant/dashboard','middleware' => 'IsAccountant'], function() {
    Route::get('/', 'AccountantDashboardController@index')->name('accountant.dashboard');
    Route::get('/nepali/calendar', 'AccountantDashboardController@nepaliCaledar')->name('accountant.nepali.calendar');

    Route::get('/student/{id}/', 'AccountantDashboardController@getStudents');
    Route::get('/class/fee/{id}/', 'AccountantDashboardController@getClassFee');
    Route::get('/class/fee/half/{id}', 'AccountantDashboardController@getClassFeeHalf');
    Route::get('/student/transport/{id}/', 'AccountantDashboardController@getStudentTransport');
    Route::get('/student/scholarship/{id}/', 'AccountantDashboardController@getStudentScholarship');
    Route::get('/student/previous/invoice/{id}/', 'AccountantDashboardController@getStudentPreviousInvoice');
    Route::get('/class/sections/{id}/', 'AccountantDashboardController@getClassSectionInDropDown');

     //Transport
     Route::get('/transport/all/', 'AccountantDashboardController@transport')->name('transport.accountant.index');
     Route::post('/transport/store', 'AccountantDashboardController@transportStore')->name('transport.accountant.store');
     Route::post('/transport/update', 'AccountantDashboardController@transportUpdate')->name('transport.accountant.update');
     Route::get('/transport/{id}/delete','AccountantDashboardController@transportDelete')->name('transport.accountant.delete');
     Route::get('/transport/{id}/restore','AccountantDashboardController@transportRestore')->name('transport.accountant.restore');
     Route::get('/transport/{id}/students','AccountantDashboardController@transportStudents')->name('transport.accountant.view.student');
     Route::get('/transport/{id}/student/remove','AccountantDashboardController@transportStudentRemove')->name('transport.accountant.remove.student');


    //Expense Category
    Route::get('/expense/category/all/', 'AccountantDashboardController@expense')->name('accountant.expense.category.index');
    Route::post('/expense/category/store', 'AccountantDashboardController@expenseStore')->name('accountant.expense.category.store');
    Route::post('/expense/category/update', 'AccountantDashboardController@expenseUpdate')->name('accountant.expense.category.update');
    Route::get('/expense/category/{id}/delete','AccountantDashboardController@expenseDelete')->name('accountant.expense.category.delete');
    Route::get('/expense/category/{id}/restore','AccountantDashboardController@expenseRestore')->name('accountant.expense.category.restore');

    //Expense Invoice
    Route::get('/expense/invoice/all/', 'AccountantDashboardController@expenseInvoice')->name('accountant.expense.invoice.index');
    Route::post('/expense/invoice/store', 'AccountantDashboardController@expenseInvoiceStore')->name('accountant.expense.invoice.store');
    Route::post('/expense/invoice/update', 'AccountantDashboardController@expenseInvoiceUpdate')->name('accountant.expense.invoice.update');
    Route::get('/expense/invoice/{id}/delete','AccountantDashboardController@expenseInvoiceDelete')->name('accountant.expense.invoice.delete');
    Route::get('/expense/invoice/{id}/restore','AccountantDashboardController@expenseInvoiceRestore')->name('accountant.expense.invoice.restore');


    //Fee Category
    Route::get('/fee/all/', 'AccountantDashboardController@fee')->name('accountant.fee.index');
    Route::post('/fee/store', 'AccountantDashboardController@feeStore')->name('accountant.fee.store');
    Route::post('/fee/update', 'AccountantDashboardController@feeUpdate')->name('accountant.fee.update');
    Route::get('/fee/{id}/delete','AccountantDashboardController@feeDelete')->name('accountant.fee.delete');
    Route::get('/fee/{id}/restore','AccountantDashboardController@feeRestore')->name('accountant.fee.restore');

    //Scholarship Category
    Route::get('/scholarship/all/', 'AccountantDashboardController@scholarship')->name('accountant.scholarship.index');
    Route::post('/scholarship/store', 'AccountantDashboardController@scholarshipStore')->name('accountant.scholarship.store');
    Route::post('/scholarship/update', 'AccountantDashboardController@scholarshipUpdate')->name('accountant.scholarship.update');
    Route::get('/scholarship/{id}/delete','AccountantDashboardController@scholarshipDelete')->name('accountant.scholarship.delete');
    Route::get('/scholarship/{id}/restore','AccountantDashboardController@scholarshipRestore')->name('accountant.scholarship.restore');
    Route::get('/scholarship/{id}/students','AccountantDashboardController@scholarshipStudents')->name('accountant.scholarship.view.student');
    Route::get('/scholarship/{id}/student/remove','AccountantDashboardController@scholarshipStudentRemove')->name('accountant.scholarship.remove.student');

    //Invoice
    Route::get('/invoice/all/', 'AccountantDashboardController@invoice')->name('accountant.invoice.index');
    Route::get('/invoice/create/', 'AccountantDashboardController@invoiceCreate')->name('accountant.invoice.create');
    Route::post('/invoice/store/', 'AccountantDashboardController@invoiceStore')->name('accountant.invoice.store');
    Route::get('/invoice/view/{id}', 'AccountantDashboardController@invoiceView')->name('accountant.invoice.view');
    Route::get('/invoice/delete/{id}', 'AccountantDashboardController@invoiceDelete')->name('accountant.invoice.delete');
    Route::post('/invoice/take/payment', 'AccountantDashboardController@invoiceTakePayment')->name('accountant.invoice.take.payment');
    Route::get('/invoice/search/', 'AccountantDashboardController@invoiceSearch')->name('accountant.invoice.search');

    //Print Bulk Invoice
    Route::get('/invoice/bulk/', 'AccountantDashboardController@invoicePrintBulk')->name('accountant.invoice.print.bulk');
    Route::post('/invoice/bulk/print/{class_id}', 'AccountantDashboardController@invoicePrintBulkAll')->name('accountant.invoice.print.bulk.all');
});
