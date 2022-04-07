<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class PasswordResetNotification extends Notification {
	use Queueable;

	public $token;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($token) {
		$this->token = $token;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) {
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable) {

		$urlToResetForm = "" . $this->token;
		return (new MailMessage)
			->subject(Lang::get('Reset Password'))
			->line(Lang::get('Seems like you forgot password for bedabeda app. If this true click below to reset your password.'))
			->action('Reset Password', url('password/reset', $this->token))
			->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
			->line(Lang::get('If you did not request a password reset, no further action is required.you can safely ignore this email'));

	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable) {
		return [
			//
		];
	}
}