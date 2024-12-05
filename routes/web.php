    <?php

    use App\Http\Controllers\Admin\AdminDashboardController;
    use App\Http\Controllers\Admin\AdminEmployeeController;
    use App\Http\Controllers\Admin\AdminEmployeeFeedbackController;
    use App\Http\Controllers\Admin\AdminEmployeeResponseController;
    use App\Http\Controllers\Admin\AdminHrCalendarController;
    use App\Http\Controllers\Admin\AdminProfileController;
    use App\Http\Controllers\Admin\AdminQuestionController;
    use App\Http\Controllers\Admin\AdminSummaryDataController;
    use App\Http\Controllers\Auth\AuthController;
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\BotController;

    // Login Admin
    Route::get('/login', [AuthController::class, 'login_form'])->name('login.form');
    Route::post('/hr-calendar/login', [AuthController::class, 'login_admin'])->name('login.admin');
    Route::post('/hr-calendar/logout', [AuthController::class, 'logout_admin'])->name('logout.admin');

    // Bot chat
    Route::get('/', [BotController::class, 'showForm'])->name('showForm');
    Route::post('/saveUserAndQuestion', [BotController::class, 'saveUserAndQuestion'])->name('saveUserAndQuestion');
    Route::post('/saveUserAndQuestionAnother', [BotController::class, 'saveUserAndQuestionAnother'])->name('saveUserAndQuestionAnother');
    Route::get('/getChatHistory', [BotController::class, 'getChatHistory'])->name('getChatHistory');
    Route::post('/saveUserAndFeedback', [BotController::class, 'saveUserAndFeedback'])->name('saveUserAndFeedback');
    Route::get('/bot/logout', [BotController::class, 'logout'])->name('logout');

    Route::middleware(['auth:admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Profile
        Route::resource('/profile/admin', AdminProfileController::class);
        Route::put('/profile/reset-password-admin', [AdminProfileController::class, 'reset_password'])->name('admin.reset.password');

        // Question
        Route::get('/question/admin', [AdminQuestionController::class, 'index'])->name('admin.question.index');
        Route::get('/question/admin/add', [AdminQuestionController::class, 'add'])->name('admin.question.add');
        Route::post('/question/admin/store', [AdminQuestionController::class, 'store'])->name('admin.question.store');
        Route::get('/question/admin/show/{encryptedId}', [AdminQuestionController::class, 'show'])->name('admin.question.show');
        Route::put('/question/admin/update/{encryptedId}', [AdminQuestionController::class, 'update'])->name('admin.question.update');
        Route::delete('/question/admin/destroy/{encryptedId}', [AdminQuestionController::class, 'destroy'])->name('admin.question.destroy');

        // Employee
        Route::get('/employee/admin', [AdminEmployeeController::class, 'index'])->name('admin.employee.index');
        Route::get('/employee/admin/show/{encryptedId}', [AdminEmployeeController::class, 'show'])->name('admin.employee.show');
        Route::put('/employee/admin/update/{encryptedId}', [AdminEmployeeController::class, 'update'])->name('admin.employee.update');
        Route::delete('/employee/admin/destroy/{encryptedId}', [AdminEmployeeController::class, 'destroy'])->name('admin.employee.destroy');

        // Employee Response
        Route::get('/employee-response/admin', [AdminEmployeeResponseController::class, 'index'])->name('admin.employee.response.index');

        // Employee Feedback
        Route::get('/employee-feedback/admin', [AdminEmployeeFeedbackController::class, 'index'])->name('admin.employee.feedback.index');

        // Summary
        // Response
        Route::get('/employee-summary/response', [AdminSummaryDataController::class, 'response_index'])->name('admin.summary.response.index');
        Route::get('/employee-summary/response/department/{department}', [AdminSummaryDataController::class, 'response_department'])->name('admin.summary.response.department');
        Route::get('/employee-summary/response/category/{category}', [AdminSummaryDataController::class, 'response_category'])->name('admin.summary.response.category');
        Route::get('/employee-summary/response/question/{question}', [AdminSummaryDataController::class, 'response_question'])
            ->where('question', '.*')
            ->name('admin.summary.response.question');
        // Feedback
        Route::get('/employee-summary/feedback', [AdminSummaryDataController::class, 'feedback_index'])->name('admin.summary.feedback.index');
        Route::get('/employee-summary/feedback/{rating}', [AdminSummaryDataController::class, 'feedback_rating'])->name('admin.summary.feedback.rating');
        // Question
        Route::get('/employee-summary/question', [AdminSummaryDataController::class, 'question_index'])->name('admin.summary.question.index');
        Route::get('/employee-summary/question/department/{department}', [AdminSummaryDataController::class, 'question_department'])->name('admin.summary.question.department');
        Route::get('/employee-summary/question/category/{category}', [AdminSummaryDataController::class, 'question_category'])->name('admin.summary.question.category');
        // Employee
        Route::get('/employee-summary/employee', [AdminSummaryDataController::class, 'employee_index'])->name('admin.summary.employee.index');
        Route::get('/employee-summary/employee/source/{sources}', [AdminSummaryDataController::class, 'employee_source'])->name('admin.summary.employee.source');
        Route::get('/employee-summary/employee/source/{source}/division/{division}', [AdminSummaryDataController::class, 'employee_division'])
            ->name('admin.summary.employee.division');
        Route::get('/employee-summary/employee/detail/response/source/{source}/division/{division}/department/{department}', [AdminSummaryDataController::class, 'employee_response_division'])
            ->name('admin.summary.employee.response.division');
        Route::get('/employee-summary/employee/detail/not-response/source/{source}/division/{division}/department/{department}', [AdminSummaryDataController::class, 'employee_not_response_division'])
            ->name('admin.summary.employee.not.response.division');
        // Response Employee
        Route::get('/employee-summary/response/employee', [AdminSummaryDataController::class, 'response_employee_index'])->name('admin.summary.response_employee.index');
        Route::get('/employee-summary/response/employee/source/{source}', [AdminSummaryDataController::class, 'response_employee_source'])->name('admin.summary.response_employee.source');
        Route::get('/employee-summary/response/employee/source/{source}/division/{division}', [AdminSummaryDataController::class, 'response_employee_division'])
            ->name('admin.summary.response_employee.division');
        Route::get('/employee-summary/response/employee/source/{source}/division/{division}/department/{department}', [AdminSummaryDataController::class, 'response_employee_detail'])
            ->name('admin.summary.response_employee.detail');

        // HR Calendar
        Route::get('/hr-calendar/list', [AdminHrCalendarController::class, 'index_list'])->name('admin.hr.calendar.index.list');
        Route::post('/hr-calendar/list', [AdminHrCalendarController::class, 'filter'])->name('admin.hr.calendar.filter');


        Route::get('/hr-calendar/list/add', [AdminHrCalendarController::class, 'add_list'])->name('admin.hr.calendar.add.list');
        Route::post('/hr-calendar/list/store', [AdminHrCalendarController::class, 'store_list'])->name('admin.hr.calendar.store.list');
        Route::get('/hr-calendar/list/edit/{id}', [AdminHrCalendarController::class, 'edit_list'])->name('admin.hr.calendar.edit.list');
        Route::put('/hr-calendar/list/update/{id}', [AdminHrCalendarController::class, 'update_list'])->name('admin.hr.calendar.update.list');
        Route::delete('/hr-calendar/list/delete/{id}', [AdminHrCalendarController::class, 'delete_list'])->name('admin.hr.calendar.delete.list');
        Route::delete('/hr-calendar/list/delete-sub/{id}', [AdminHrCalendarController::class, 'delete_list_sub'])->name('admin.hr.calendar.delete.list.sub');

        Route::get('/hr-calendar/view', [AdminHrCalendarController::class, 'index_view'])->name('admin.hr.calendar.index.view');
    });
