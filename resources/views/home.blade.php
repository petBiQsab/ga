@extends('layouts.app')

@section('content')
<script>
    // Pass data to JS
    const routeData = @json($newData);
</script>
@endsection
