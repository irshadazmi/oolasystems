@extends('layouts.app')

@section('content')
    <div class="manage-container">
        <div class="manage-header">
            <h1>Manage Contacts</h1>
            <a href="{{ route('admin') }}" class="btn btn-secondary">← Back to Dashboard</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            @if ($contacts->count() > 0)
                <table class="manage-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone ?? 'N/A' }}</td>
                                <td>{{ Str::limit($contact->subject ?? '', 30) }}</td>
                                <td>{{ $contact->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-view">View</a>
                                    <a href="#" class="btn btn-sm btn-delete">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <p>No contacts found</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .manage-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .manage-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .manage-header h1 {
            margin: 0;
            color: #333;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: auto;
        }

        .manage-table {
            width: 100%;
            border-collapse: collapse;
        }

        .manage-table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .manage-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        .manage-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .manage-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 12px;
            margin-right: 5px;
        }

        .btn-view {
            background-color: #667eea;
            color: white;
        }

        .btn-view:hover {
            background-color: #5568d3;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .empty-state {
            padding: 40px;
            text-align: center;
            color: #999;
        }
    </style>
@endsection
