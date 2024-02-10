<?php

use App\Http\Controllers\Profile\RegistrationController;
use App\Http\Controllers\LoanTransactionController;
use App\Http\Controllers\RepaymentLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountJournalController;
use App\Http\Controllers\AccountReport;
use App\Http\Controllers\AccountSetup;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomedTransactionController;
use App\Http\Controllers\PDFReport;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::any('new-client', [RegistrationController::class, 'index'])
                ->name('register');
    Route::any('loan-request', [LoanTransactionController::class, 'index'])
        ->name('loan');
    Route::any('loan-marketer-review', [LoanTransactionController::class, 'marketerReview'])
        ->name('marketerReview');
    Route::any('loan-accountant-review', [LoanTransactionController::class, 'accountantReview'])
        ->name('accountantReview');
    Route::any('loan-analyst-review', [LoanTransactionController::class, 'analystReview'])
        ->name('analystReview');
    Route::any('loan-final-review', [LoanTransactionController::class, 'finalReview'])
        ->name('finalReview');
    Route::any('loan-disbursement', [LoanTransactionController::class, 'disbursement'])
        ->name('disbursement');
    Route::any('loan-repayment', [RepaymentLogController::class, 'index'])
        ->name('repayment');
    Route::any('customer/loan-repayment',   [CustomerController::class, 'repayment']);
    Route::any('customer/loan-report',      [CustomerController::class, 'loan']);
    Route::any('customer/loan-details',     [CustomerController::class, 'loanDetails']);
    Route::any('customer/profile',      [CustomerController::class, 'profile']);
    Route::any('loan-repayment-approval', [RepaymentLogController::class, 'approval'])
        ->name('repaymentApproval');
    Route::any('loan-report', [ReportController::class, 'loan'])
        ->name('loanReport');

    Route::any('loan-details', [ReportController::class, 'loanDetails'])
        ->name('loanDetails');
    Route::any('sub-account', [AccountController::class, 'subaccount'])
        ->name('subaccount');
    Route::any('account', [AccountController::class, 'newaccount'])
        ->name('newaAccount');
    Route::any('journal', [AccountJournalController::class, 'journal'])
        ->name('journal');
    Route::any('trialbalance', [AccountController::class, 'trialbalance'])
        ->name('trialbalance');
    Route::any('pl', [AccountController::class, 'pl'])
        ->name('pl');
    Route::any('active-customer', [ReportController::class, 'activeCustomer'])
        ->name('activeCustomer');
        Route::any('active-loan', [ReportController::class, 'activeLoan'])
        ->name('activeLoan');
        Route::any('overdue-loan', [ReportController::class, 'overdueLoan'])
        ->name('overdueLoan');
        Route::any('application-loan', [ReportController::class, 'applicationLoan'])
        ->name('applicationLoan');
        Route::any('balance-sheet', [AccountController::class, 'balanceSheet'])
        ->name('balanceSheet');
        Route::any('customer-loan/{id}', [ReportController::class, 'customerLoan'])
        ->name('customerLoan');
        Route::any('default-setup', [SettingController::class, 'defaultSetup'])
        ->name('defaultSetup');
        Route::any('income-setup', [SettingController::class, 'incomeSetup'])
        ->name('incomeSetup');

        Route::any('loan-schedule', [LoanTransactionController::class, 'schedule']);


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        Route::any('/pre-journal-post',     [AccountSetup::class, 'PreJournalPost']);
        Route::any('custom/upload',         [CustomedTransactionController::class, 'upload']);

        Route::any('agent/upload',          [CustomedTransactionController::class, 'agentupload']);

        Route::any('process/upload',          [CustomedTransactionController::class, 'processUpload']);

        Route::any('/group-journal-post',   [AccountSetup::class, 'Journal_Final_post']);

        Route::any('/account-statement',    [AccountReport::class, 'AccountStatements']);
        Route::any('/account-statement-pdf',[PDFReport::class, 'AccountStatements']);
        Route::any('/petty-cash',           [AccountSetup::class, 'PettyCashHandling']);
        Route::any('/particular-setup',     [AccountSetup::class, 'DefaultAccountSetup']);
        Route::any('/product-setup',     [AccountSetup::class, 'DefaultProductSetup']);


});
