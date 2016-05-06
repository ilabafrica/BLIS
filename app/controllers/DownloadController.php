<?php
use Illuminate\Database\QueryException;

/**
 *   
 * 
 */
class DownloadController extends Controller
{
  public function download($file_name) {
    $file_path = public_path('i/'.$file_name);
    return response()->download($file_path);
  }
}