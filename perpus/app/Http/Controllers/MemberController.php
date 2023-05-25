<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.member.index');
    }

    public function api(Request $request)
    {
        if ($request->gender) {
            $members = Member::where('gender', $request->gender)->get();
        } else {
            $members = Member::all();
        }

        $datatables = datatables()->of($members)
            ->addColumn('tanggal', function ($member) {
                return tanggal_helper($member->created_at);
            })
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|min:3',
            'gender'      => 'required',
            'email'     => 'required',
            'phone_number'     => 'required|numeric|min:11',
            'address'   => 'required'
        ]);

        Member::create($request->all());
        session()->flash('message', 'Data succesfully add');
        return redirect('members');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name'      => 'required|string|min:3',
            'gender'      => 'required',
            'email'     => 'required',
            'phone_number'     => 'required|numeric|min:11',
            'address'   => 'required'
        ]);

        $member->update($request->all());
        session()->flash('message', 'Data succesfully add');
        return redirect('members');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        session()->flash('message', 'Data succesfully delete');
        return redirect('members');
    }
}
