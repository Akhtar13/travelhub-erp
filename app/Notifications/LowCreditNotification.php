<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable; use Illuminate\Contracts\Queue\ShouldQueue; use Illuminate\Notifications\Messages\MailMessage; use Illuminate\Notifications\Notification;
class LowCreditNotification extends Notification implements ShouldQueue { use Queueable; public function __construct(public string $agent, public float $balance){} public function via($notifiable): array { return ['mail','database']; } public function toMail($notifiable): MailMessage { return (new MailMessage)->subject('Low Agent Credit')->line($this->agent.' balance is '.$this->balance); } public function toArray($notifiable): array { return ['agent'=>$this->agent,'balance'=>$this->balance,'event'=>'low_credit']; } }
