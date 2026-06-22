<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Services\Admin\{ExportService,ReportService};
class ReportController extends Controller { public function index(string $type,ReportService $r){ abort_unless(in_array($type,['bookings','passengers','agents','credits','revenue']),404); return view('admin.reports.index',['type'=>$type,'rows'=>$r->{$type}(request()->all())]); } public function export(string $type,string $format,ReportService $r,ExportService $e){ $rows=$r->{$type}(request()->all()); $items=method_exists($rows,'items')?$rows->items():$rows; return $format==='pdf' ? $e->pdf(view('admin.reports.export',['rows'=>$items,'type'=>$type])->render(),$type) : $e->csv($items,['id','name','status','total_amount','credit_balance'],$type); } }
