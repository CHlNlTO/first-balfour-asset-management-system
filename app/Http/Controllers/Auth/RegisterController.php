<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\CEMREmployee;
// use App\Models\User;
// use App\Models\UserRole;
// use Illuminate\Auth\Events\Registered;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rule;

// class RegisterController extends Controller
// {
//     public function showRegistrationForm()
//     {
//         return view('auth.register');
//     }

//     public function store(Request $request)
//     {
//         // Validate the registration data including the custom id_num field
//         $validated = $request->validate([
//             'name' => ['required', 'string', 'max:255', 'unique:users,name'],
//             'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
//             'password' => ['required', 'string', 'min:8', 'confirmed'],
//             'id_num' => ['required', 'string', Rule::exists('central_employeedb.employees', 'id_num')],
//         ]);

//         // Check if id_num exists in the remote employees table
//         $employee = CEMREmployee::where('id_num', $validated['id_num'])->first();

//         if (!$employee) {
//             return back()->withErrors(['id_num' => 'ID Number not found. Try again or contact IT support.']);
//         }

//         // Create the user in the local database
//         $user = User::create([
//             'name' => $validated['name'],
//             'email' => $validated['email'],
//             'password' => Hash::make($validated['password']),
//             'id_num' => $validated['id_num'],
//         ]);

//         // Assign 'employee' role
//         UserRole::create([
//             'user_id' => $user->id,
//             'role_id' => 2,
//         ]);

//         event(new Registered($user));

//         Auth::login($user);

//         return redirect('/app');
//     }
// }
