<?php

namespace App\Filament\App\Pages\Auth;

use App\Models\CEMREmployee;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Events\Registered;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Filament\Http\Responses\Auth\RegistrationResponse;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getIDNumFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getIDNumFormComponent(): Component
    {
        return TextInput::make('id_num')
            ->label('Employee ID Number')
            ->required();
    }

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        // Check if the ID number already exists in the users table
        if (User::where('id_num', $data['id_num'])->exists()) {
            // Add error to the form
            $this->form->getState()['errors']['id_num'] = 'ID Number already exists in the system.';

            Notification::make()
                ->title('ID Number Already Exists')
                ->body('The ID Number you provided is already registered. Please use a different ID Number.')
                ->danger()
                ->send();

            return null;
        }

        // Check if the ID number exists in the CEMREmployee table, in descending order
        $employee = CEMREmployee::where('id_num', $data['id_num'])->orderBy('id_num', 'desc')->first();

        if (!$employee) {
            // Add error to the form
            $this->form->getState()['errors']['id_num'] = 'ID Number not found.';

            Notification::make()
                ->title('ID Number Not Found')
                ->body('Try again or contact IT support.')
                ->danger()
                ->send();

            return null;
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'id_num' => $data['id_num'],
            ]);

            UserRole::create([
                'user_id' => $user->id,
                'role_id' => 2,
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            Notification::make()
                ->title('Successfully Registered')
                ->body('You have been successfully registered and logged in.')
                ->success()
                ->send();

            return app(RegistrationResponse::class);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Registration failed: ' . $e->getMessage());
            $this->form->addError('id_num', 'Failed to register user. Please try again.');
            return null;
        }
    }
}
