<?php

namespace App\Http\Controllers\App;

use App\Facades\Bookshelves;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessagePostRequest;
use Kiwilan\Steward\Utils\Notifier;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class FormController extends Controller
{
    #[Get('/form/message', name: 'form.message')]
    public function message()
    {
        return inertia('Forms/Message');
    }

    #[Post('/form/message', name: 'form.message.post')]
    public function messageSubmit(MessagePostRequest $request)
    {
        Notifier::discord(Bookshelves::notificationDiscordWebhook())
            ->username('Bookshelves')
            ->message([
                '**Kiwiflix Message**',
                "- Type: {$request->input('type')}",
                "- Description: {$request->input('description')}",
            ])
            ->send();

        return redirect()->route('form.message');
    }
}
