<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;

use App\Models\User;

use Hash;

use Illuminate\Support\Facades\Mail;

use App\Mail\UserCreatedMail;

use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $users = User::query()->get();
            return response()->json( $users );    
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'country' => $request->country,
            'national_identity_document' => $request->national_identity_document,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'category_id' => $request->category_id
        ]);

        Mail::to($request->email)->send(new UserCreatedMail($user, $request->password));

        $users = User::select('country', DB::raw('count(*) as cantidad'))->groupBy('country')->get();

        view()->share('users', $users);
        $pdf = \PDF::loadView('users.report', $users);
        $pdf->save(public_path('reporte/users-pdf.pdf'));

        $data["email"] = "administrador@app.com";
        $data["title"] = "Reporte de usuarios";
        $data["body"] = "Esto es un correo con archivo adjunto";
 
        $file = public_path('reporte/users-pdf.pdf');
  
        Mail::send('emails.admid_report', $data, function($message)use($data, $file) {
            $message->to($data["email"])
                    ->subject($data["title"]);
            $message->attach($file);         
        });


        return response()->json(['user' => $user]);
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
        $user = User::find($id);
        return response()->json(['user'=> $user]);
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
        $user = User::find($id);

       if($user)
       {
            $user->update([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'country' => $request->country,
                'national_identity_document' => $request->national_identity_document,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'category_id' => $request->category_id
            ]);
       }


        return response()->json(['user'=> $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json(['user'=> []]);
    }
}
