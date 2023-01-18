<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMailSubscriptionRequest;
use App\Http\Requests\UpdateMailSubscriptionRequest;
use App\Models\MailSubscription;

class MailSubscriptionController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMailSubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMailSubscriptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MailSubscription  $mailSubscription
     * @return \Illuminate\Http\Response
     */
    public function show(MailSubscription $mailSubscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MailSubscription  $mailSubscription
     * @return \Illuminate\Http\Response
     */
    public function edit(MailSubscription $mailSubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMailSubscriptionRequest  $request
     * @param  \App\Models\MailSubscription  $mailSubscription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMailSubscriptionRequest $request, MailSubscription $mailSubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailSubscription  $mailSubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailSubscription $mailSubscription)
    {
        //
    }
}
