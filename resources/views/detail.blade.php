@extends('layouts.app')

@section('content')
<script>
    // Pass data to JS
    const data = @json($dataset);
    const lists =  @json($ciselniky);
    const routeData = {
        ...data,
        lists,
    };
</script>
@endsection
