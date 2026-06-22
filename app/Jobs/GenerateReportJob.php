<?php
namespace App\Jobs;
use App\Services\Admin\ReportService; use Illuminate\Contracts\Queue\ShouldQueue; use Illuminate\Foundation\Queue\Queueable;
class GenerateReportJob implements ShouldQueue { use Queueable; public function __construct(public string $type, public array $filters=[]){} public function handle(ReportService $reports): void { $reports->{$this->type}($this->filters); } }
