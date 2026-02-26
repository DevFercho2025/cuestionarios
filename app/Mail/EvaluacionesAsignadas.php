<?php

namespace App\Mail;

use App\Models\User;
use App\Models\AccessCode;
use App\Models\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EvaluacionesAsignadas extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected User $candidate,
        protected AccessCode $code,
        protected string $loginURL,
    )
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Evaluaciones Asignadas',
            //from global en config mail.php
            replyTo: [
                new Address(config('mail.from.address', 'noreply@psicometrias.com'), config('mail.from.name', 'Psicometrías')),
            ],
        );
    }

    public function content(): Content
    {
        $assignedTests = $this->candidate->assignedTestsPorCodigo($this->code->id)->get();

        return new Content(
            view: 'emails.evaluaciones_asignadas',
            with: [
                'candidateName' => $this->candidate->name,
                'assignedTests' => $assignedTests,
                'testsCount' => $assignedTests->count(),
                'company' => $this->code->company?->name ?? '',
                'code' => $this->code,
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
