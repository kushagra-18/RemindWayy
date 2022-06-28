<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reminder;
use App\User;
use Error;

class ReminderController extends Controller
{

    /**
     * This is used to show the index page.
     */

    public function index()
    {

        // $reminders = Reminder::where('user_id', auth()->user()->id)->get();
        
        return view('home');
    }

    public function getReminders()
    {
        $reminders = Reminder::where('user_id', auth()->user()->id)->get();
        return response()->json($reminders);
    }

    public function getUpcomingReminders()
    {
        error_log('getUpcomingReminders');
        $reminders = Reminder::where('user_id', auth()->user()->id)
        ->where('date', '>=', date('Y-m-d'))
        ->where('time', '>=', date('H:i'))
        ->get();

        return response()->json($reminders);
    }

    /**
     * This function is used to save the reminder.
     */
    public function saveReminder(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'description' => 'required'
        ]);

        // return error if validation fails
        if ($request->has('error')) {
            return response()->json(['error' => $request->error]);
        }

        try {


            // check if date is in past
            $date = $request->input('date');

            if (strtotime($date) < strtotime(date('Y-m-d'))) {
                error_log('Date is in past');
                return response()->json(['error' => 'Date cannot be in past.'], 200);
            }

            // if date is current and time is current + 5 mins then error

            if (strtotime($date) == strtotime(date('Y-m-d')) && strtotime($request->input('time')) < strtotime(date('H:i:s')) + 599) {
                return response()->json(['error' => 'Time should atleast be 10 mins from current time.'], 200);
            }

            $data = $request->all();
            $userId = auth()->user()->id;
            $reminder = new Reminder();


            $saveData = $reminder->saveReminder($userId, $data);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if ($saveData) {
            return response()->json(['success' => 'Reminder added successfully.'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    /**
     * This function is used to delete the reminder.
     */

    public function deleteReminder(Request $request)
    {



    //    check if reminder belongs to user
        $reminder = Reminder::where('id', $request->input('id'))->where('user_id', auth()->user()->id)->first();

        if (!$reminder) {
            return response()->json(['error' => 'You are not authorized to delete this reminder.'], 422);
        }

        // return error if validation fails
        if ($request->has('error')) {
            return response()->json(['error' => $request->error]);
        }

        try {
            $id = $request->input('id');
            $reminder = Reminder::find($id);
            $reminder->delete();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['success' => 'Reminder deleted successfully.'], 200);
    }

    public function addPhoneNumber(Request $request)
    {

        error_log('addPhoneNumber');
        $this->validate($request, [
            'phone' => 'required'
        ]);

        // return error if validation fails
        if ($request->has('error')) {
            return response()->json(['error' => $request->error]);
        }

        try {
            $userId = auth()->user()->id;
            $phoneNumber = $request->input('phone');
            $user = User::find($userId);
            $user->phone = $phoneNumber;
            $user->save();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['success' => 'Phone number added successfully.'], 200);
    }
}
