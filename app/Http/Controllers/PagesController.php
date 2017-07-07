<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Statyczne ścieżki
class PagesController extends Controller
{
	public function error()
	{
		return view('panel.error');
	}
}
