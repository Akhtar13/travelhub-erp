<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable; use Illuminate\Contracts\Queue\ShouldQueue; use Illuminate\Notifications\Messages\MailMessage; use Illuminate\Notifications\Notification;
class CheckInCompletedNotification extends Notification implements ShouldQueue { use Queueable; public function __construct(public string $pnr){} public function via($notifiable): array { return ['mail','database']; } public function toMail($notifiable): MailMessage { return (new MailMessage)->subject('Check-In Completed')->line('Check-in completed for '.$this->pnr); } public function toArray($notifiable): array { return ['pnr'=>$this->pnr,'event'=>'check_in_completed']; } }
