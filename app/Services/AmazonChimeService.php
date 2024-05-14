<?php
namespace App\Services;
use App\Models\Meeting;
use App\Models\MeetingAttendee;
use Illuminate\Support\Str;
class AmazonChimeService
{
    protected $meeting;
    protected $meetingAttendee;
    public function __construct()
    {
        $this->meeting = new Meeting();
        $this->meetingAttendee = new MeetingAttendee();
    }

    public function createMeetingWithAttendee($payload)
    {
        // handle error use DB transaction
        // @TODO for code refractor
        $payloadMeeting = $payload['Meeting'];
        $payloadAttendee['Attendee'] = $payload['Attendee'];

        $dataAttendeeSession['meeting_id'] = $payloadMeeting['ExternalMeetingId'];
        $dataAttendeeSession['user'] = $payload['user'] ?? "test";
        $dataAttendeeSession['meeting_id_amazon'] = $payloadMeeting['MeetingId'];
        $dataAttendeeSession['meeting_payload_raw'] = json_encode($payloadMeeting);
        $dataAttendeeSession['attendee_payload_raw'] = json_encode($payloadAttendee);

        $dataMeeting['meeting_id'] = $payloadMeeting['ExternalMeetingId'];
        $dataMeeting['meeting_id_amazon'] = $payloadMeeting['MeetingId'];
        $dataMeeting['meeting_payload_raw'] = json_encode($payloadMeeting);
        $dataMeeting['title'] = 'test-'. Str::random(10);
        $dataMeeting['meeting_password'] = '';
        $dataMeeting['invitees'] = '';


        if(!$this->createAttendeeSession($dataAttendeeSession))
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

    public function createAttendeeSession($payload)
    {
        return $this->meetingAttendee->create($payload);
    }

    public function joinAtendeeMeeting()
    {

    }

    public function endMeeting()
    {

    }

    public function findMeetingById($meetingId ,$mode = 'api')
    {
        if($res = $this->meeting
        ->where('meeting_id' ,$meetingId)
        // ->where('user',$user)
        ->first())
        {
            // if found

            return $mode  == 'api' ? response()->json($res,200) : $res ;
        }

        return response()->json(["message"=> "record not found"],404);

    }

    public function findAmazonMeetingById($meetingId ,$mode = 'api')
    {
        if($res = $this->meeting
        ->where('meeting_id_amazon' ,$meetingId)
        // ->where('user',$user)
        ->first())
        {
            // if found

            return $mode  == 'api' ? response()->json($res,200) : $res ;
        }

        return response()->json(["message"=> "record not found"],404);

    }

    public function findAttendeeMeetingById($meetingId, $user ='')
    {
        if($res = $this->meetingAttendee
        ->where('meeting_id' ,$meetingId)
        ->where('user',$user)
        ->first())
        {
            // if found
            return response()->json($res,200);
        }

        return response()->json(["message"=> "record not found"],404);
    }


    public function createAttendeInDB($payload)
    {
        $attendee = $payload['attendee'];
        $user = $payload['user'];
        // find meeting payload
        $payload = $this->findAmazonMeetingById($payload['meetingId'],'raw');
        if($payload){

            $payloadMeeting = $payload['meeting_payload_raw'];
            $payloadAttendee = $attendee;
            $dataAttendeeSession['meeting_id'] = $payload['meeting_id']; // -in app id
            $dataAttendeeSession['user'] = $user ?? "test";
            $dataAttendeeSession['meeting_id_amazon'] = $payload['meeting_id_amazon']; // amazon id
            $dataAttendeeSession['meeting_payload_raw'] = $payloadMeeting;
            $dataAttendeeSession['attendee_payload_raw'] = $payloadAttendee;
            return $this->createAttendeeSession($dataAttendeeSession);
        }

        return 'no record found';
    }
}
