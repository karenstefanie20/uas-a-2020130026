<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }


    public function store(Request $request)
    {
        $rules = [
            'id' => 'required|not_in:none',
            'nama' => 'required',
            'rekomendasi' => 'present',
            'harga' => 'required|min:0',
        ];
        $validated = $request->validate($rules);
        $type = '';
        switch ($validated["id"]) {
            case "Makanan":
                $type = 'MKN';
                break;
            case "Minuman":
                $type = 'MNM';
                break;
            case "Cemilan":
                $type = 'CEM';
                break;
            default:
                $type = 'OMS';
                break;
        }

        $latestId = DB::select("SELECT RIGHT(id,4) rightid FROM menus WHERE id LIKE '$type%' ORDER BY rightid DESC");

        if(!$latestId){
            $currentId = sprintf("%04d", 1);
        }else{
            $currentId = sprintf("%04d", $latestId[0]->rightid + 1);
        }

        $validated["id"] = $type . $currentId;

        Menu::create($validated);
        $request->session()->flash('Berhasil',"Berhasil Ditambahkan {$validated['nama']}!");
        return redirect(route('menus.index'));
    }

    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view("menus.edit", compact("menu"));
    }

    public function update(Request $request, Menu $menu)
    {
        $rules = [
            'id' => 'required|not_in:none',
            'nama' => 'required',
            'rekomendasi' => 'present',
            'harga' => 'required|min:0',
        ];
        $validated = $request->validate($rules);
        $type = '';
        switch ($validated["id"]) {
            case "Makanan":
                $type = 'MKN';
                break;
            case "Minuman":
                $type = 'MNM';
                break;
            case "Cemilan":
                $type = 'CEM';
                break;
            default:
                $type = 'OMS';
                break;
        }

        $latestId = DB::select("SELECT RIGHT(id,4) rightid FROM menus WHERE id LIKE '$type%' ORDER BY rightid DESC");

        if(!$latestId){
            $currentId = sprintf("%04d", 1);
        }else{
            $currentId = sprintf("%04d", $latestId[0]->rightid + 1);
        }

        $validated["id"] = $type . $currentId;

        $menu->update($validated);
        $request->session()->flash('Berhasil',"Berhasil Diupdate {$validated['nama']}!");
        return redirect(route('menus.index'));
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect(route('menus.index'))->with('Berhasil',"Berhasil Dihapus {$menu['nama']}!");
    }
}
