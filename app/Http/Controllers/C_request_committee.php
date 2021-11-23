<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_request_committee extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request_committee.create');
    }

    public function formrequest()
    {
        return view('request_committee.formrequest');

    }

    public function formrequestaffairs()
    {

        return view('request_committee.formrequest-affairs');

    }

    public function committee_members()
    {

        return view('request_committee.committee-members');


    }

    public function decision_committee()
    {
        return view('request_committee.decision-to-prepare-a-committee');

    }

    public function decision_to_form_committees()
    {

        return view('request_committee.decision-to-form-committees-at-the-relevant-departments');
    }

    public function final_report_for_the_adoption()
    {

        return view('request_committee.final-report for-the-adoption-of-the-committee-data');
    }

    public function view_committee_details()
    {
        return view('request_committee.view-committee-details');

    }

    public function composition_of_committee_members()
    {
        return view('request_committee.composition-of-committee-members');

    }

    public function committee_formation_requests()
    {
        return view('request_committee.committee-formation-requests');

    }

    public function notification()
    {
        return view('request_committee.notification');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
