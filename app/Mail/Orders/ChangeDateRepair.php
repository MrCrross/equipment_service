<?php

namespace App\Mail\Orders;

use App\Models\Orders\EquipmentOrder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeDateRepair extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ?string $oldDate, public EquipmentOrder $order)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('orders.mail.headers.changed_date'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'orders.mail.changed-date-repair',
            with: [
                'oldDateRepair' => !empty($this->oldDate) ? Carbon::parse($this->oldDate)->format('d.m.Y') : __('order_mails.changed_date.empty_date'),
                'newDateRepair' => !empty($this->order->date_repair) ? Carbon::parse($this->order->date_repair)->format('d.m.Y') : __('order_mails.changed_date.empty_date'),
                'order' => $this->order,
            ]
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
