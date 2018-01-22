<?php

namespace App\Http\Controllers;

use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;
use App\Room;
use Validator;

class RoomController extends APIBaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = $request->all();

        $validator = Validator::make($item, [
            'title' => 'required|unique:rooms|max:255',
            'descs' => 'required',
            'price' => 'numeric',
            'quality' => 'integer'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $item = Room::create($item);
        return $this->sendResponse($item->toArray(), 'Room created successfully.');
    }

    public function index()
    {
        $item= Room::all();
        return $this->sendResponse($item->toArray(), 'Rooms retrieved successfully.');
    }

    public function show($id)
    {
        $item = Room::find($id);
        if (is_null($item)) {
            return $this->sendError('Room not found.');
        }
        return $this->sendResponse($item->toArray(), 'Room retrieved successfully.');
    }

    public function update(Request $request, Room $item)
    {
        $item->update($request->all());

        return $this->sendResponse($item->toArray(), 'Room updated successfully.');
    }

    public function delete(Room $item)
    {
        $item->delete();

        return $this->sendResponse($item->toArray(), 'Room deleted successfully.');
    }
}
