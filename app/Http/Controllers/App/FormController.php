<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessagePostRequest;
use Kiwilan\LaravelNotifier\Facades\Notifier;
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
        Notifier::discord()
            ->message([
                '**Kiwiflix Message**',
                "- Type: {$request->input('type')}",
                "- Description: {$request->input('description')}",
            ])
            ->user('Bookshelves')
            ->send();

        return redirect()->route('form.message');
    }
}
