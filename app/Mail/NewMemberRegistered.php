<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Member;

class NewMemberRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $member;

    /**
     * Create a new message instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('dhazriana.ramalan@jmc.my')
            ->to('it@jmc.my')
            ->subject('New Member Registered: ' . $this->member->member_name)
            ->markdown('emails.new_member_registered')
            ->with(['member' => $this->member]);
    }
}
