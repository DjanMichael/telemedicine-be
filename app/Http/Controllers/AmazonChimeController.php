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
    public function createMeetingWithAttendee(CreateMeetingRequest $payload)
    {
       return $this->amazonService->createMeetingWithAttendee($payload->all());
    }

    public function findMeetingById(Request $request)
    {
        return $this->amazonService->findMeetingById($request->meetingId);
    }

    public function findAttendeeMeetingById(Request $request)
    {
        return $this->amazonService->findAttendeeMeetingById($request->meetingId,$request->user);
    }

    public function createAttendeInDB(Request $request)
    {
        return $this->amazonService->createAttendeInDB($request->all());
    }
}
