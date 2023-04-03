<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $path = parse_url($url, PHP_URL_PATH);
            $query = parse_url($url, PHP_URL_QUERY);

            // remove the unwanted segments from the path
            $path = preg_replace('/^\/api\/email\/verify\//', '', $path);

            $newUrl = env("FRONTEND_URL", "https://olnx.com") . "/verify" . '/' . $path . '?' . $query;
            return (new MailMessage)
                ->subject('👋 Welcome to OLNX: Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $newUrl);
        });
    }
}
