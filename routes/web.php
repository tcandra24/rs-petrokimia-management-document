<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function(){
        return redirect('/login');
    });

    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

    Route::get('/verify-email/{token}', App\Http\Controllers\Auth\VerifyEmailController::class)->name('verify');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function(){
        return redirect('/dashboard');
    });

    Route::get('/dashboard', App\Http\Controllers\DashboardController::class)->name('dashboard.index');

    Route::prefix('master')->group(function() {
        Route::resource('/divisions', \App\Http\Controllers\Master\DivisionController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:master.divisions.index|master.divisions.create|master.divisions.edit|master.divisions.destroy');

        Route::resource('/sub-divisions', \App\Http\Controllers\Master\SubDivisionController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:master.sub-divisions.index|master.sub-divisions.create|master.sub-divisions.edit|master.sub-divisions.destroy');

        Route::resource('/instructions', \App\Http\Controllers\Master\InstructionController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:master.instructions.index|master.instructions.create|master.instructions.edit|master.instructions.destroy');

        Route::resource('/purposes', \App\Http\Controllers\Master\PurposeController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:master.purposes.index|master.purposes.create|master.purposes.edit|master.purposes.destroy');

        Route::resource('/positions', \App\Http\Controllers\Master\PositionController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:master.positions.index|master.positions.create|master.positions.edit|master.positions.destroy');
    });

    Route::prefix('transaction')->group(function() {
        Route::resource('/dispositions', \App\Http\Controllers\Transaction\DispositionController::class)
        ->middleware('permission:transaction.dispositions.index|transaction.dispositions.show|transaction.dispositions.create|transaction.dispositions.edit|transaction.dispositions.destroy');

        Route::resource('/memos', \App\Http\Controllers\Transaction\MemoController::class)
        ->middleware('permission:transaction.memos.index|transaction.memos.show|transaction.memos.create|transaction.memos.edit|transaction.memos.destroy');

        Route::resource('/pre-memos', \App\Http\Controllers\Transaction\PreMemoController::class)
        ->middleware('permission:transaction.pre-memos.index|transaction.pre-memos.show|transaction.pre-memos.create|transaction.pre-memos.edit|transaction.pre-memos.destroy');

        Route::post('disposition/change-status/{id}', \App\Http\Controllers\Transaction\Approval\Disposition\ChangeStatusController::class)->name('transaction.disposition.change-status');

        Route::post('pre-memo/change-status/{id}', \App\Http\Controllers\Transaction\Approval\PreMemo\ChangeStatusController::class)->name('transaction.pre-memo.change-status');

        Route::prefix('export')->group(function() {
            Route::prefix('pre-memo')->group(function() {
                Route::get('/pdf/{id}', [\App\Http\Controllers\Transaction\Export\Pdf\PreMemoController::class, 'download'])->name('download.pre-memos');
            });

            Route::prefix('memo')->group(function() {
                Route::get('/pdf/{id}', [\App\Http\Controllers\Transaction\Export\Pdf\MemoController::class, 'download'])->name('download.memos');
            });

            Route::prefix('disposition')->group(function() {
                Route::get('/pdf/{id}', [\App\Http\Controllers\Transaction\Export\Pdf\DispositionController::class, 'download'])->name('download.dispositions');
            });
        });

        Route::prefix('download')->group(function() {
            Route::prefix('pre-memo')->group(function() {
                Route::get('/attachment/{id}', \App\Http\Controllers\Transaction\Download\PreMemo\AttachmentController::class)->name('attachment.pre-memo');
            });

            Route::prefix('memo')->group(function() {
                Route::get('/attachment/{id}', \App\Http\Controllers\Transaction\Download\Memo\AttachmentController::class)->name('attachment.memo');
            });

            Route::prefix('disposition')->group(function() {
                Route::get('/attachment/{id}', \App\Http\Controllers\Transaction\Download\Disposition\AttachmentController::class)->name('attachment.disposition');
            });
        });

        Route::prefix('digital-signature')->group(function() {
            Route::prefix('pre-memo')->group(function() {
                Route::get('/', [\App\Http\Controllers\Transaction\DigitalSignature\PreMemo\VerifyController::class, 'index'])->name('digital-signature.pre-memo.index');
                Route::get('/verify', [\App\Http\Controllers\Transaction\DigitalSignature\PreMemo\VerifyController::class, 'check'])->name('digital-signature.pre-memo.verify');
            });

            Route::prefix('memo')->group(function() {
                Route::get('/', [\App\Http\Controllers\Transaction\DigitalSignature\Memo\VerifyController::class, 'index'])->name('digital-signature.memo.index');
                Route::get('/verify', [\App\Http\Controllers\Transaction\DigitalSignature\Memo\VerifyController::class, 'check'])->name('digital-signature.memo.verify');
            });

            Route::prefix('disposition')->group(function() {
                Route::get('/', [\App\Http\Controllers\Transaction\DigitalSignature\Disposition\VerifyController::class, 'index'])->name('digital-signature.disposition.index');
                Route::get('/verify', [\App\Http\Controllers\Transaction\DigitalSignature\Disposition\VerifyController::class, 'check'])->name('digital-signature.disposition.verify');
            });
        });
    });

    Route::prefix('setting')->group(function(){
        Route::resource('/users', \App\Http\Controllers\Setting\UserController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:setting.users.index|setting.users.create|setting.users.edit|setting.users.destroy');

        Route::resource('/roles', \App\Http\Controllers\Setting\RoleController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:setting.roles.index|setting.roles.create|setting.roles.edit|setting.roles.destroy');

        Route::resource('/permissions', \App\Http\Controllers\Setting\PermissionController::class, [ 'only' => [ 'index', 'create', 'store' ] ])
        ->middleware('permission:setting.permissions.index|setting.permission.create');
    });

    Route::prefix('my-profile')->group(function() {
        Route::get('/', App\Http\Controllers\Profile\MyProfileController::class)->name('profile.index');
        Route::post('/change-password', App\Http\Controllers\Profile\ChangePasswordController::class)->name('profile.change-password');

        Route::patch('/change-profile', App\Http\Controllers\Profile\ChangeProfileController::class)->name('profile.change-profile');
        Route::delete('/delete-profile', App\Http\Controllers\Profile\DeleteImageProfileController::class)->name('profile.delete-profile');
    });

    Route::post('/resend-email/{email}', App\Http\Controllers\Auth\ResendEmailController::class)->name('email.resend');

    Route::resource('/notifications', \App\Http\Controllers\NotificationController::class, [ 'only' => [ 'index', 'show' ] ]);

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
