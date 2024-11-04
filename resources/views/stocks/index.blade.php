@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold mb-6">Stocks</h1>
    <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-4">Add New Stock</a>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <th class="bg-base-200">ID</th>
                    <th class="bg-base-200">Description</th>
                    <th class="bg-base-200">Quantity</th>
                    @if(auth()->user()->usertype === 'admin')
                        <th class="bg-base-200">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td class="border">{{ $stock->id }}</td>
                        <td class="border">{{ $stock->description }}</td>
                        <td class="border">{{ $stock->quantity }}</td>
                        @if(auth()->user()->usertype === 'admin')
                            <td class="border">
                                <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm" onclick="return confirm('Are you sure you want to delete this stock?');">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
