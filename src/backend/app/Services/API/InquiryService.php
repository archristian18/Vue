<?php

namespace App\Services\API;

use App\Models\Inquiry;
use App\Mail\NewInquiry;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\InquiryNotFoundException;

class InquiryService
{
    /** @var \App\Models\Inquiry */
    protected $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function create(array $data): Inquiry
    {
        $inquiry = $this->inquiry->create($data);

        // notify admin via email notification
        $send = Mail::to(env('MAIL_FROM_ADDRESS'))->send(new NewInquiry($inquiry));
        return $inquiry;
    }

    public function findById(int $id): Inquiry
    {
        // retrieve the inquiry
        $inquiries = $this->inquiry->find($id);

        if (!($inquiries instanceof Inquiry)) {
            throw new InquiryNotFoundException();
        }

        return $inquiries;
    }
}
