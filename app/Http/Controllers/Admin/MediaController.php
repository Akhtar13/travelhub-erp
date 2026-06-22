<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Http\Requests\Admin\MediaUploadRequest; use App\Models\MediaAsset; use App\Services\Admin\MediaService;
class MediaController extends Controller { public function index(){ return view('admin.media.index',['media'=>MediaAsset::latest()->paginate(30)]); } public function store(MediaUploadRequest $r,MediaService $s){ $s->upload($r->file('file'),$r->collection,null,$r->user()->id); return back(); } }
