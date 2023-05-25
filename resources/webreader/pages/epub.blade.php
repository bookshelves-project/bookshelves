@extends('webreader::app')

@section('content')
  <div
    x-data="epub"
    x-init="boot(`{{ $book }}`)"
  >
    <div
      class="h-screen"
      x-ref="webreader"
    ></div>
    <nav class="fixed bottom-0 z-10">
      <button @click="navFirst">
        first
      </button>
      <button @click="navPrevious">
        previous
      </button>
      <button @click="navNext">
        next
      </button>
      <button @click="navLast">
        last
      </button>
    </nav>
  </div>
@endsection
