<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @param string $subject
     */
    public function __construct(array $data, string $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.feedback')
                    ->with($this->data);
    }
}
