<?php
namespace App\Jobs;
use Illuminate\Contracts\Queue\ShouldQueue; use Illuminate\Foundation\Queue\Queueable; use Illuminate\Support\Facades\Storage;
class GeneratePdfJob implements ShouldQueue { use Queueable; public function __construct(public string $path, public string $html){} public function handle(): void { Storage::disk('local')->put($this->path,$this->html); } }
