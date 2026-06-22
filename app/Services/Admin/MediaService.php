<?php
namespace App\Services\Admin;
use App\Models\MediaAsset; use Illuminate\Http\UploadedFile;
class MediaService { public function upload(UploadedFile $file,string $collection,$model=null,?int $userId=null): MediaAsset { $path=$file->store($collection,'public'); return MediaAsset::create(['mediable_type'=>$model?get_class($model):null,'mediable_id'=>$model?->id,'collection'=>$collection,'disk'=>'public','path'=>$path,'original_name'=>$file->getClientOriginalName(),'mime_type'=>$file->getMimeType(),'size'=>$file->getSize(),'uploaded_by'=>$userId]); } }
