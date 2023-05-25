@extends('webreader::app')

@section('content')
  <div
    x-data="epub"
    x-init="boot('{{ $url }}')"
  >
    webreader
    <div id="epub-render"></div>
  </div>
@endsection
