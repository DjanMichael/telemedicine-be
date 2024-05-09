<?php
namespace App\Services;
use App\Models\Meeting;
use App\Models\MeetingSession;
use Illuminate\Support\Str;
class AmazonChimeService
{
    protected $meeting;
    protected $meetingSession;
    public function __construct()
    {
        $this->meeting = new Meeting();
        $this->meetingSession = new MeetingSession();
    }

    public function createMeeting($payload)
    {

        $payloadMeeting = $payload['Meeting'];
        $payloadAttendee = $payload['Attendee'];

        $dataMeetingSession['meeting_id'] = $payloadMeeting['ExternalMeetingId'];
        $dataMeetingSession['user'] = $payload['user'] ?? "test";
        $dataMeetingSession['meeting_id_amazon'] = $payloadMeeting['MeetingId'];
        $dataMeetingSession['meeting_payload_raw'] = json_encode($payloadMeeting);
        $dataMeetingSession['attendee_payload_raw'] = json_encode($payloadAttendee);

        $dataMeeting['meeting_id'] = $payloadMeeting['ExternalMeetingId'];
        $dataMeeting['title'] = 'test-'. Str::random(10);
        $dataMeeting['meeting_password'] = '';
        $dataMeeting['invitees'] = '';


        if(!$this->createMeetingSession($dataMeetingSession))
        {
            return abort(409,'error creating a meeting session');
        }

        if(!$this->meeting->create($dataMeeting))
        {
            return abort(409,'error creating a meeting');
        }
        // add lang.success
        return response()->json(['message'=>'success'],200);

    }

    public function createMeetingSession($payload)
    {
        return $this->meetingSession->create($payload);
    }

    public function joinAtendeeMeeting()
    {

    }

    public function endMeeting()
    {

    }

    public function findMeetingSessionById($meetingId)
    {
        if(!$res = $this->meetingSession->where('meeting_id' ,$meetingId )->first())
        {
            return response()->json(['data' => $res],200);
        }

        return response()->json(['data' => [],404]);

    }
}
