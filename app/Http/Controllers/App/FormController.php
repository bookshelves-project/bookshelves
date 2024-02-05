<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessagePostRequest;
use Kiwilan\Notifier\Facades\Notifier;
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
