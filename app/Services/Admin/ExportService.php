<?php
namespace App\Services\Admin;
class ExportService { public function csv(iterable $rows, array $headers, string $name){ return response()->streamDownload(function() use($rows,$headers){ $out=fopen('php://output','w'); fputcsv($out,$headers); foreach($rows as $row) fputcsv($out,array_map(fn($h)=>data_get($row,$h,''),$headers)); fclose($out); },$name.'.csv',['Content-Type'=>'text/csv']); } public function pdf(string $html,string $name){ return response($html,200,['Content-Type'=>'application/pdf','Content-Disposition'=>'attachment; filename="'.$name.'.pdf"']); } }
