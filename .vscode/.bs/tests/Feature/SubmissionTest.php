<?php

use App\Models\Submission;

use function Pest\Laravel\post;

test('received', function () {
    Notification::fake();

    $submission = Submission::factory(1)->make(parent: new Submission());
    /** @var Submission */
    $submission = $submission->first();

    $response = post(route('api.submissions.create', [
        'subject' => $submission->subject->value,
        'name' => $submission->name,
        'email' => $submission->email,
        'phone' => $submission->phone,
        'society' => $submission->society,
        'message' => $submission->message,
        'accept_conditions' => $submission->accept_conditions,
        'want_newsletter' => $submission->want_newsletter,
        'honeypot' => false,
    ]));

    Notification::assertCount(1);
    $response->assertStatus(200);
});
