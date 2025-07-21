<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\User;
use App\Models\ContadorEvaluacion;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmpresaRegistrada extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Company $newCompany,
        protected User $companyUser,
        protected string $loginURL,
    )
    {
        $this->companyUser->loadMissing('TestCounter');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Empresa Registrada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $availableTests = $this->companyUser->TestCounter()->first()->available_tests ;

        return new Content(
            view: 'emails.empresa_registrada',
            with: [
                'companyName' => $this->newCompany->name,
                'companyUser' => $this->companyUser->name,
                'email' => $this->companyUser->email,
                'availableTests' => $availableTests,
                'logoPath' => public_path('assets/img/Alobri/Alobri-light.png'),
                'loginURL' => $this->loginURL,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
