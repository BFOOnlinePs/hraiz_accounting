<?php

namespace App\Http\Controllers;

use App\Models\BfoAttendance;
use App\Models\TimeAttendanceDevicesModel;
use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;

class AttendaceDeviceController extends Controller
{
    public function index(){
        $time_attendance_device = TimeAttendanceDevicesModel::get();
        foreach ($time_attendance_device as $key){
        }
        return view('admin.setting.attendance_device.index',['time_attendance_device'=>$time_attendance_device]);

    }

    public function create_time_attendance_device_option(Request $request){
        $data = new TimeAttendanceDevicesModel();
        $data->ip = $request->ip;
        $data->port = $request->port;
        $data->user_name = $request->user_name;
        $data->password = $request->password;
        $data->status_right = $request->status_right;
        $data->status_left = $request->status_left;
        $data->status_up = $request->status_up;
        $data->status_down = $request->status_down;
        if ($data->save()){
            return redirect()->route('setting.attendance_device.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.attendance_device.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function update_time_attendance_device_option(Request $request){
        $data = TimeAttendanceDevicesModel::where('id',$request->id)->first();
        $data->ip = $request->ip;
        $data->port = $request->port;
        $data->user_name = $request->user_name;
        $data->password = $request->password;
        $data->status_right = $request->status_right;
        $data->status_left = $request->status_left;
        $data->status_up = $request->status_up;
        $data->status_down = $request->status_down;
        if ($data->save()){
            return redirect()->route('setting.attendance_device.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.attendance_device.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function async_data_from_attendance_device_ajax(Request $request){
        $attendance_device = TimeAttendanceDevicesModel::where('id',$request->attendance_device_id)->first();
        $zk = new ZKTeco(''.$attendance_device->ip.'',$attendance_device->port);
        $zk->connect();
        $zk->enableDevice();
        $attendances = $zk->getAttendance();
        $data = BfoAttendance::orderBy('id','desc')->latest('attendance_id')->first();
        $errorCondition = false;
        foreach ($attendances as $key){
            if (!empty($data)){
                if ($data->attendance_id < $key['uid']){
                    $bfo_attendance = new BfoAttendance();
                    $bfo_attendance->activity_type = $key['type'];
                    $bfo_attendance->user_id = $key['id'];
                    $bfo_attendance->in_time = $key['timestamp'];
                    $bfo_attendance->out_time = $key['timestamp'];
                    $bfo_attendance->attendance_id = $key['uid'];
                    $bfo_attendance->device_id = $request->attendance_device_id;
                    if (!$bfo_attendance->save()) {
                        $errorCondition = true;
                    }
                }
            }
            else{
                $bfo_attendance = new BfoAttendance();
                $bfo_attendance->activity_type = $key['type'];
                $bfo_attendance->user_id = $key['id'];
                $bfo_attendance->in_time = $key['timestamp'];
                $bfo_attendance->out_time = $key['timestamp'];
                $bfo_attendance->attendance_id = $key['uid'];
                $bfo_attendance->device_id = $request->attendance_device_id;
                if (!$bfo_attendance->save()) {
                    $errorCondition = true;
                }
            }
        }

        if ($errorCondition){
            return response()->json([
                'success'=>'false',
                'message'=>'لم يتم الاقتران بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'true',
                'message'=>'تم الاقتران بنجاح'
            ]);
        }
    }

    public function check_connection_attendance_device_ajax(Request $request){
        $zk = new ZKTeco(''.$request->ip.'',$request->port);
        if ($zk->connect()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم الاتصال بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خطا بالاتصال'
            ]);
        }
    }

    public function delete($id){
        $data = TimeAttendanceDevicesModel::where('id',$id)->first();
        if ($data->delete()){
            return redirect()->route('setting.attendance_device.index')->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.attendance_device.index')->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات']);
        }
    }

}
