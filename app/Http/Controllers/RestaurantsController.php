<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequestStore;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $providers = Restaurant::all();
            return DataTables::of($providers)
                ->addIndexColumn()
                ->addColumn('action', function($result) {
                    $buttons = [
                        'view' => [
                            'title' => 'View',
                            'class' => 'btn-outline-primary',
                            'icon' => 'mdi-eye-outline',
                            'href' => '#'
                        ],
                        'edit' => [
                            'title' => 'Edit',
                            'class' => 'btn-outline-info',
                            'icon' => 'mdi mdi-pencil',
                            'href' => '#'
                        ],
                        'delete' => [
                            'title' => 'Delete',
                            'class' => 'btn-outline-danger',
                            'icon' => 'mdi-delete-outline',
                            'href' => '#jobDelete',
                            'data-toggle' => 'modal'
                        ]
                    ];
                    $output = '<ul class="list-unstyled hstack gap-1 mb-0">';
                    foreach ($buttons as $key => $button) {
                        $output .= sprintf(
                            '<li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="%s">
                                <a href="%s" class="btn btn-sm %s" %s>
                                    <i class="mdi %s"></i>
                                </a>
                            </li>',
                            $button['title'],
                            $button['href'],
                            $button['class'],
                            isset($button['data-toggle']) ? 'data-bs-toggle="' . $button['data-toggle'] . '"' : '',
                            $button['icon']
                        );
                    }
                    $output .= '</ul>';
                
                    return $output;
                })
                ->rawColumns(['action'])
                ->make(true);
         }
        return view('restaurantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequestStore $request)
    {
        $data = $request->validated();

        if ($request->hasFile('restuarnt_file') && $request->file('restuarnt_file')->isValid()) {
            $imageName = Str::random(10) . '.' . $request->file('restuarnt_file')->getClientOriginalExtension();
            $request->file('restuarnt_file')->storeAs('restaurant', $imageName);
            $data['restuarnt_file'] = $imageName;
        }

        $restaurant = Restaurant::create($data);
        return redirect()->route('restaurants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
