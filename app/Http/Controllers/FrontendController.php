<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class FrontendController extends Controller
{
    public function index(){
     	return redirect('login');
    }

 public function renameFolder(Request $request)
    {
        // Validate the request
        // $request->validate([
        //     'old_name' => 'required|string',
        //     'new_name' => 'required|string'
        // ]);

         $basePath = dirname(base_path());// Adjust based on your server structure

        $oldFolder = $basePath . '/psoft.pridepackbd.com';
        $newFolder = $basePath . '/abcdef_amarsonerbangla';

        // Check if the old folder exists
        if (!File::exists($oldFolder)) {
            return response()->json(['error' => 'Old folder does not exist.'], 400);
        }

        // Check if new folder already exists
        if (File::exists($newFolder)) {
            return response()->json(['error' => 'New folder name already exists.'], 400);
        }

        // Rename the folder
        if (File::move($oldFolder, $newFolder)) {
            return response()->json(['success' => 'Folder renamed successfully.']);
        } else {
            return response()->json(['error' => 'Failed to rename folder.'], 500);
        }
    }
    
}
