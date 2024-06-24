<?php

use App\Http\Controllers\Admin\Category\DeleteCategoryController;
use App\Http\Controllers\Admin\Category\EditCategoryController;
use App\Http\Controllers\Admin\Category\IndexCategoryController;
use App\Http\Controllers\Admin\Category\StoreCategoryController;
use App\Http\Controllers\Admin\Post\CreatePostController;
use App\Http\Controllers\Admin\Post\DeletePostController;
use App\Http\Controllers\Admin\Post\EditPostController;
use App\Http\Controllers\Admin\Post\IndexPostController;
use App\Http\Controllers\Admin\Post\ShowPostController;
use App\Http\Controllers\Admin\Tag\DeleteTagController;
use App\Http\Controllers\Admin\Tag\EditTagController;
use App\Http\Controllers\Admin\Tag\IndexTagController;
use App\Http\Controllers\Admin\Tag\StoreTagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Dashboard\ProfilCredentialsController;
use App\Http\Controllers\Dashboard\UpdateCredentialsController;
use App\Http\Controllers\Public\Post\CommentAppendingController;
use App\Http\Controllers\Public\Post\FilterPostController;
use App\Http\Controllers\Public\Post\PublicLatestPostController;
use App\Http\Controllers\Public\Post\PublicPostController;
use App\Http\Controllers\Public\Post\ShowPublicPostController;

Route::middleware(['auth:sanctum'])->group(function (): void {

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.store');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');


    Route::prefix('comment')->group(function (): void {
        Route::post('/create', [CommentAppendingController::class, 'new_comment'])->name('new_comment');
        Route::delete('/delete/{id}', [CommentAppendingController::class, 'delete_comment'])->name('delete_comment');
    });

    Route::prefix('dashboard')->group(function (): void {
        Route::get('/', ProfilCredentialsController::class)->name('profile_credentials');
        Route::post('/update_user_name', [UpdateCredentialsController::class, 'update_user_name'])->name('update_user_name');
        Route::post('/update_user_email', [UpdateCredentialsController::class, 'update_user_email'])->name('update_user_email');
        Route::post('/update_user_password', [UpdateCredentialsController::class, 'update_user_password'])->name('update_user_password');
    });

    Route::prefix('admin')->group(function (): void {

        Route::prefix('tags')->group(function (): void {
            Route::get('/', IndexTagController::class)->name('tags');
            Route::post('/create', StoreTagController::class)->name('create_tag');
            Route::put('/edit/{id}', EditTagController::class)->name('edit_tag');
            Route::delete('/delete/{id}', DeleteTagController::class)->name('delete_tag');
        });

        Route::prefix('categories')->group(function (): void {
            Route::get('/', IndexCategoryController::class)->name('categories');
            Route::post('/create', StoreCategoryController::class)->name('create_category');
            Route::put('/edit/{id}', EditCategoryController::class)->name('edit_category');
            Route::delete('/delete/{id}', DeleteCategoryController::class)->name('delete_category');
        });

        Route::prefix('posts')->group(function (): void {
            Route::get('/', IndexPostController::class)->name('posts');
            Route::post('/create', CreatePostController::class)->name('create_post');
            Route::put('/edit/{id}', EditPostController::class)->name('edit_post');
            Route::post('/show/{id}', ShowPostController::class)->name('show_post');
            Route::delete('/delete/{id}', DeletePostController::class)->name('delete_post');
        });
    });
});


Route::prefix('public')->group(function (): void {
    Route::get('posts', PublicPostController::class)->name('public_posts');
    Route::get('latest_posts', PublicLatestPostController::class)->name('public_latest_posts');
    Route::post('single_post/{slug}', ShowPublicPostController::class)->name('show_public_post');
    Route::get('filter_post_by_category', [FilterPostController::class, 'filter_post_by_category'])->name('filter_post_by_category');
})->middleware('throttle:60,1');
