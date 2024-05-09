<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AmazonChimeService;

// Request Validation
use App\Http\Requests\CreateMeetingRequest;

class AmazonChimeController extends Controller
{
    protected $amazonService;

    public function __construct()
    {
        $this->amazonService = new AmazonChimeService;
    }
    //
    public function createMeeting(CreateMeetingRequest $payload)
    {
       return $this->amazonService->createMeeting($payload->all());
    }

    public function findMeetingSessionById(Request $request)
    {
        return $this->amazonService->findMeetingSessionById($request->meetingId,$request->user);
    }
}
