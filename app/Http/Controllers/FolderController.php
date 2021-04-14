<?php

namespace App\Http\Controllers;

use App\File;
use App\Folder;
use DB;
use Illuminate\Http\Request;

class FolderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = DB::table('folders')
            ->join('users', 'folders.created_by', '=', 'users.id')
            ->select('folders.*', 'users.name')
            ->where('folders.deletion_status', 0)
            ->orderBy('folders.id', 'DESC')
            ->get();
        return view('administrator.folder.manage_folders', compact('folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.folder.add_folder');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $folder = request()->validate([
            'folder_name' => 'required|max:100',
            'folder_description' => 'required',
            'publication_status' => 'required',
        ], [
            'folder_name.required' => 'The folder name is required.',
        ]);

        $result = Folder::create($folder + ['created_by' => auth()->user()->id]);
        $inserted_id = $result->id;

        if (!empty($inserted_id)) {
            return redirect('/folders')->with('message', 'Add successfully.');
        }
        return redirect('/folders')->with('exception', 'Operation failed !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $files = File::where('folder_id', $id)->first();
        if (!empty($files)) {
            return redirect()->back()->with('exception', 'The folder is not empty!');
        } else {
            $folder = Folder::findOrFail($id);
            $deleted_id = $folder->delete();
            if (!empty($deleted_id)) {
                return redirect()->back()->with('message', ' Deleted Successfully!');
            } else {
                return redirect()->back()->with('exception', ' Operation Failed!');
            }

        }

    }

}
