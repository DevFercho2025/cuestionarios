<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluacionesAsignadas;
use App\Models\User;
use App\Models\AccessCode;

class EvaluacionAsignadaTest extends TestCase
{
    public function test_envio_de_mailable_a_usuario_existente()
    {
        Mail::fake();

        $user = User::findOrFail(22);
        $code = AccessCode::with('tests')->findOrFail(31);
        $loginURL = route('login') . '#tab-candidate';

        Mail::to($user->email)->send(new EvaluacionesAsignadas($user, $code, $loginURL));

        Mail::assertSent(EvaluacionesAsignadas::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}