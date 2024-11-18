@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-3xl font-bold mb-6">Stok</h1>
        <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-4">Tambah Stok Baru</a>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="bg-base-200">No. Kod</th>
                        <th class="bg-base-200">Perihal Stok</th>
                        <th class="bg-base-200">Kuantiti</th>
                        @if (auth()->user()->usertype === 'admin')
                            <th class="bg-base-200">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $stock)
                        <tr>
                            <td class="border">{{ $stock->id }}</td>
                            <td class="border">{{ $stock->description }}</td>
                            <td class="border">{{ $stock->quantity }}</td>
                            @if (auth()->user()->usertype === 'admin')
                                <td class="border">
                                    <!-- Edit Button with Icon -->
                                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <!-- Delete Button with Icon -->
                                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this stock?');">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
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
