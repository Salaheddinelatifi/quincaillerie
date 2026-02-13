@extends('admin.layout')

@section('title','Notifications')

@section('content')
<h2>Notifications</h2>

@if($notifications->count() > 0)
    <ul>
    @foreach($notifications as $note)
        <li>{{ $note->data['message'] ?? 'Nouvelle notification' }} - {{ $note->created_at->diffForHumans() }}</li>
    @endforeach
    </ul>
@else
    <p>Aucune notification</p>
@endif
@endsection
