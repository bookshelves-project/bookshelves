@extends('front::layouts.app', ['prose' => true, 'navigation' => true])

@section('title', 'Catalog')

@section('default')
    <p>
        Catalog is a feature that allows you to access books from your
        eReader’s
        web browser, you need to connect your eReader to the Internet and
        launch
        the browser (which is often hidden in sub-menus). When you are on
        your
        browser, simply add the Catalog address to access and download
        books.
    </p>
    <x-button route="{{ route('catalog') }}">Access to Catalog</x-button>
    <section>
        <p>To access to Catalog from your eReader, just put this address to your
            web browser*: </p>
        <pre><code>{{ route('front.opds') }}</code></pre>
    </section>
    <section>
        <i>Note: if you set the address of this page on a phone, tablet or
            eReader,
            your device will redirect you to Catalog.</i>
        <ul>
            <li>You can use search bar to find the book what you want from
                book’s title, book’s series or book’s author.</li>
            <li>If you have an author or a series as result, you can’t download
                books directly, but don’t hesitate to tap on an author or a
                series, you will see list of books associated with, just tap on
                the book that you want.</li>
            <li>If you want to browse books list, Catalog is not the right tool
                cause of it basic interface.</li>
        </ul>
        <strong>
            If you don’t know how to enable web browser on your eReader, check
            if your eReader have it on Internet, <a
                href="https://goodereader.com/blog/electronic-readers/how-to-use-the-internet-browser-on-the-kobo-aura-one"
                target="_blank"
                rel="noopener noreferrer">here an example for Kobo</a>.
        </strong>
    </section>
@endsection
