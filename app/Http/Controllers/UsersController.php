<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $users = User::all();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('business', function($result){
                    return $result->business->count();
                })
                ->addColumn('restaurants', function($result){
                    return $result->restaurants->count();
                })
                ->addColumn('status', function($result){
                    $status = '';
                    if ($result->trashed()) {
                        $status .= '<div class="badge font-size-12 badge-soft-danger"> Suspendido </div>';
                    }else{
                        $status .= '<div class="badge font-size-12 badge-soft-success"> Activo </div>';
                    }
                    return $status;
                })
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
                ->rawColumns(['action','status'])
                ->make(true);
         }
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $business = Business::all();
        return view('users.create', compact('business'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
         $user = new User($request->all());
        //  if ($request->has('photo_user')) {
        //     $photo = $request->file('photo_user');
        //      $avatar =  $user->email.'.'.$photo->getClientOriginalExtension();
        //      $path = public_path('/assets/images/users/');
        //      $photo_user = $path . $avatar;
        //      Image::make($photo)->resize(150, 150)->save($photo_user);
        // }
        // $data = $request->validated();

        // if ($request->hasFile('restuarnt_file') && $request->file('restuarnt_file')->isValid()) {
        //     $imageName = Str::random(10) . '.' . $request->file('restuarnt_file')->getClientOriginalExtension();
        //     $request->file('restuarnt_file')->storeAs('restaurant', $imageName);
        //     $data['restuarnt_file'] = $imageName;
        // }
        $user->password = bcrypt($request->name.'2024');
        $user->save();
        $user->business()->attach($request->business_id);
        $restaurantIds = explode(',', $request->restaurant_ids);
        $user->restaurants()->attach($restaurantIds);

        // $restaurant = Restaurant::create($data);
        return redirect()->route('users.index');
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
