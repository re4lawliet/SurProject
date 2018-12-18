@extends('layouts.appCompras')


@section('content')

<script>
  var self = this;

  self.on('mount',function(){
    //levantar plugins jquery
    __clientAutocomplete();
  })

  function __clientAutocomplete(){
    var options = {
      data: ["blue", "green", "pink", "red", "yellow"]
    };

    $("client").easyAutocomplete(options);    
  }
</script>
@endsection