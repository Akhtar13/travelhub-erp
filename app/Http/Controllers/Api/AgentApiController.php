<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Models\Agent;
class AgentApiController extends Controller { public function index(){ return Agent::with('currency','assignments.route')->paginate(25); } }
